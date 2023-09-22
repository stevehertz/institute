<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionsOption;
use App\Models\ExamResultAnswer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Cart;
use App\Models\ExamResult;
use function PHPUnit\Framework\isEmpty;
use Carbon;
use DatePeriod;
use DateInterval;
use function PHPUnit\Framework\isNull;

class ExamController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } else if (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
        $this->middleware('preventBackHistory');
    }

    public function studentExams()
    {
        $exams = 0;
        $exams = Exam::whereHas('students', function ($query) {
            $query->where('id', \Auth::id());
        })->with('examResults')->with('students', function ($query1) {
            $query1->where('user_id', \Auth::id())->first()->get();
        })->get();
//       foreach ($exams as $exam)
//       {
//          dd($exam->students[0]->pivot->created_at);
//       }
        return view('backend.student_exams.index', compact('exams'));

    }

    public function previewExam(Request $request)
    {
        $continue_exam = NULL;
        $exam = Exam::withoutGlobalScope('filter')->where('uniqueExamId', $request->uniqueExam)->with('course')->with('supervisor')->firstOrFail();

        $certified = \Auth::check() && Certificate::where('user_id', \Auth::id())->where('course_id', $exam->course_id)->first();
        $enrolmentStatus = \DB::table('exam_student')->where('exam_id', $exam->course_id)->where('user_id', \Auth::id())->first();

        if (($exam->status == 0) && ($enrolmentStatus == false)) {
            abort(403);
        }

        return view('backend.student_exams.preview', compact('exam'));

    }

    public function startExam(Request $request)
    {

        $exam = Exam::withoutGlobalScope('filter')->where('uniqueExamId', $request->uniqueExam)->with('course')->with('questions')->firstOrFail();
        $enrolmentStatus = \DB::table('exam_student')->where('exam_id', $exam->course_id)->where('user_id', \Auth::id())->first();

        if (($exam->status == 0) && ($enrolmentStatus == false)) {
            abort(403, 'Student not enrolled in the exam.');
        }

        return view($this->path . '.exams.showQuestions', compact('exam'));
    }

    public function submitExamTest(Request $request)
    {

        $exam = Exam::where('id', $request->exam_id)->firstOrFail();
        $answers = [];
        $exam_score = 0;
        if (!$request->get('questions')) {

            return back()->with(['flash_warning' => 'No options selected']);
        }
        foreach ($request->get('questions') as $question_id => $answer_id) {
            $question = ExamQuestion::find($question_id);
            $correct = ExamQuestionsOption::where('question_id', $question_id)
                    ->where('id', $answer_id)
                    ->where('correct', 1)->count() > 0;
            $answers[] = [
                'question_id' => $question_id,
                'option_id' => $answer_id,
                'correct' => $correct
            ];
            if ($correct) {
                if ($question->score) {
                    $exam_score += $question->score;
                }
            }
            /*
             * Save the answer
             * Check if it is correct and then add points
             * Save all test result and show the points
             */
        }

        //check if the exam is already submitted and prevent re-submission
        $alreadySubmitted = ExamResult::where('exam_id', $exam->id)->where('user_id', \Auth::id())->get()->first();
        if ($alreadySubmitted) {
            ExamResult::where('exam_id', $exam->id)->where('user_id', \Auth::id())->delete();
            ExamResultAnswer::where('exams_result_id', $alreadySubmitted->id)->delete();
        }
        $exam_result = ExamResult::create([
            'exam_id' => $exam->id,
            'user_id' => \Auth::id(),
            'exam_result' => $exam_score,
        ]);
        $exam_result->answers()->createMany($answers);

        return redirect()->route('admin.exam.completed')->with(['message' => 'Exam submitted successfully. ' . $exam_score, 'result' => $exam_result]);
    }

    public function examCompleted()
    {
        return view('frontend.exams.completed');
    }

    public function viewResults(Request $request)
    {
        $exam = Exam::where('uniqueExamId', $request->uniqueExam)->where('exam_status', '=', 'completed')->where('status', '=', 1)->first();

        if (empty($exam))
       {
           return redirect()->back()->with(['flash_warning'=>'Exam results not ready at the moment. Check back later.']);
       }
        $exam_result = NULL;
        if ($exam) {
            $exam_result = ExamResult::where('exam_id', $exam->id)
                ->where('user_id', \Auth::id())
                ->first();
        }

        return view('frontend.exams.viewResults', compact('exam', 'exam_result'));
    }
}
