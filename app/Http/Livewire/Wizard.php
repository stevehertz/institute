<?php

namespace App\Http\Livewire;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionsOption;
use App\Models\ExamResult;
use App\Models\ExamResultAnswer;
use App\Models\Question;
use Livewire\Component;
use App\Models\Team;
use Illuminate\Support\Collection;

class Wizard extends Component
{
    public $successMsg = '';
    public $examCompleted = '';
    public $questionIndexId;
    public $qid = 0;
    public $questionIndex = 0;
    public $question1 = [];
    public $questionA = [];
    public $data = [];
    public $exam = [];
    public $totalQuestions = 0;
    public $inputID;


    public function mount()
    {
        $this->question1 = $this->exam->questions[$this->qid];
        $this->totalQuestions = count($this->exam->questions);
    }

    /**
     * Write code on Method
     */
    public function render()
    {

        return view('livewire.wizard');
    }

    /**
     * Write code on Method
     */
    public function firstStepSubmit($formQid)
    {
        $nextQuestion = $formQid + 1;
        $this->qid = $nextQuestion;
        $this->question1 = $this->exam->questions[$this->qid];
        $this->questionIndex = $this->questionIndex + 1;

    }

    /**
     * Write code on Method
     */
    public function secondStepSubmit()
    {
        $validatedData = $this->validate([
            'status' => 'required',
        ]);
    }

    /**
     * Write code on Method
     */
    public function submitForm($formQid)
    {
        $exam = $this->exam;
        $answers = [];
        $exam_score = 0;
        foreach ($this->questionA as $questionId =>$answerId) {
            $question = ExamQuestion::find($questionId);
            $correct = ExamQuestionsOption::where('question_id', $questionId)
                    ->where('id', $answerId)
                    ->where('correct', 1)->count() > 0;
            $answers[] = [
                'question_id' => $questionId,
                'option_id' => $answerId,
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
        //check if the exam is already submitted and delete the existing record
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

        $this->examCompleted = 'Exams completed successfully';
        $this->clearFormCompleted();

        $this->currentStep = 1;
    }

    /**
     * Write code on Method
     */
    public function back()
    {

        $this->qid = $this->questionIndex - 1;
        $this->question1 = $this->exam->questions[$this->qid];
        $this->questionIndex = $this->questionIndex - 1;
    }

    /**
     * Write code on Method
     */
    public function clearForm()
    {
        $this->qid = 0;
        $this->questionIndex = 0;
        $this->question1 = $this->exam->questions[$this->qid];
        $this->successMsg = 'Form successfully cleared.';
    }

    public function clearFormCompleted()
    {
        $this->qid = 0;
        $this->questionIndex = 0;
        $this->questionA = [];
        $this->question1 = $this->exam->questions[$this->qid];

    }
}
