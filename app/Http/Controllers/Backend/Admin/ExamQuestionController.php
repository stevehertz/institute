<?php

namespace App\Http\Controllers\Backend\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExamQuestionsRequest;
use App\Http\Requests\Admin\UpdateExamQuestionsRequest;
use App\Models\ExamQuestion;
use App\Models\ExamQuestionsOption;
use App\Models\Exam;
use Illuminate\Http\Request;
use function foo\func;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;

class ExamQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use FileUploadTrait;

    /**
     * Display a listing of ExamQuestion.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('question_access')) {
            return abort(401);
        }

        $exams = Exam::where('status', '=', 1)->pluck('title', 'id')->prepend('Please select', '');

        return view('backend.exam_questions.index', compact('exams'));
    }


    /**
     * Display a listing of ExamQuestions via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;

        /*TODO:: Show All questions if Admin, Show related if  Teacher*/
        $questions = ExamQuestion::orderBy('created_at', 'desc')->has('exams');

        if ($request->exam_id != "") {
            $exam_id = $request->exam_id;
            $questions = ExamQuestion::query()->whereHas('exams', function ($q) use ($exam_id) {
                $q->where('exam_id', $exam_id);
            })->orderBy('created_at', 'desc');
        }

        if (!auth()->user()->role('administrator')) {
            $questions->where('user_id', '=', auth()->user()->id);
        }

        if ($request->show_deleted == 1) {
            if (!Gate::allows('question_delete')) {
                return abort(401);
            }
            $questions->onlyTrashed()->get();
        }


        if (auth()->user()->can('question_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('question_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('question_delete')) {
            $has_delete = true;
        }

        return DataTables::of($questions)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.questions', 'label' => 'id', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.exam_questions.show', ['exam_question' => $q->id])])->render();

                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.exam_questions.edit', ['exam_question' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.exam_questions.destroy', ['exam_question' => $q->id, 'exam_id' => $request->exam_id??''])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->editColumn('question_image', function ($q) {
                return ($q->question_image != null) ? '<img height="50px" src="' . asset('storage/uploads/' . $q->question_image) . '">' : 'N/A';
            })
            ->rawColumns(['question_image', 'actions'])
            ->make();
    }

    /**
     * Show the form for creating new ExamQuestion.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('question_create')) {
            return abort(401);
        }
        $exams = \App\Models\Exam::get()->pluck('title', 'id');
        return view('backend.exam_questions.create', compact( 'exams'));
    }

    /**
     * Store a newly created ExamQuestion in storage.
     *
     * @param  \App\Http\Requests\StoreExamQuestionsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamQuestionsRequest $request)
    {
        if (!Gate::allows('question_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $question = ExamQuestion::create($request->all());
        $question->user_id = auth()->user()->id;
        $question->save();
        $question->exams()->sync(array_filter((array)$request->input('exams')));

        for ($q = 1; $q <= 4; $q++) {
            $option = $request->input('option_text_' . $q, '');
            $explanation = $request->input('explanation_' . $q, '');
            if ($option != '') {
                ExamQuestionsOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                    'explanation' => $explanation,
                    'correct' => $request->input('correct_' . $q)
                ]);
            }
        }

        return redirect()->route('admin.exam_questions.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing ExamQuestion.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('question_edit')) {
            return abort(401);
        }
        $question = ExamQuestion::findOrFail($id);
        $exams = Exam::get()->pluck('title', 'id');

        return view('backend.exam_questions.edit', compact('question', 'exams'));
    }

    /**
     * Update ExamQuestion in storage.
     *
     * @param  \App\Http\Requests\UpdateExamQuestionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamQuestionsRequest $request, $id)
    {
        if (!Gate::allows('question_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $question = ExamQuestion::findOrFail($id);
        $question->update($request->all());
        $question->user_id = auth()->user()->id;
        $question->save();
        $question->exams()->sync(array_filter((array)$request->input('exams')));

        if($request->input('options_available')) {

            for ($q = 1; $q <= 4; $q++) {
                $option = $request->input('option_text_' . $q, '');
                $explanation = $request->input('explanation_' . $q, '');
                $option_id = $request->input('option_id_' . $q, '');
                $correct = ($request->input('correct_' . $q) == 1) ? 1 : 0;
                if ($option != '') {
                    $option_data = ExamQuestionsOption::find($option_id);
                    if ($option_data) {
                        $option_data->question_id = $question->id;
                        $option_data->option_text = $option;
                        $option_data->explanation = $explanation;
                        $option_data->correct = $correct;
                        $option_data->save();
                    }
                }
            }
        }else{
            for ($nq = 1; $nq <= 4; $nq++) {
                $option = $request->input('option_text_' . $nq, '');
                $explanation = $request->input('explanation_' . $nq, '');
                if ($option != '') {
                    ExamQuestionsOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option,
                        'explanation' => $explanation,
                        'correct' => $request->input('correct_' . $nq)
                    ]);
                }
            }
        }

        return redirect()->route('admin.exam_questions.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display ExamQuestion.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('question_view')) {
            return abort(401);
        }
        $questions_options = ExamQuestionsOption::where('question_id', $id)->get();

        $exams = Exam::whereHas(
            'questions',
            function ($query) use ($id) {
                $query->where('id', $id);
            }
        )->get();

        $question = ExamQuestion::findOrFail($id);

        return view('backend.exam_questions.show', compact('question', 'questions_options', 'exams'));
    }


    /**
     * Remove ExamQuestion from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = ExamQuestion::findOrFail($id);
        if (request()->get('exam_id')) {
            \DB::table('question_exam')->where('question_id', $id)->where('exam_id', request()->get('exam_id'))->delete();
        } else {
            \DB::table('question_exam')->where('question_id', $id)->delete();
        }

        $question->delete();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected ExamQuestion at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = ExamQuestion::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore ExamQuestion from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = ExamQuestion::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete ExamQuestion from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = ExamQuestion::onlyTrashed()->findOrFail($id);
        $question->forceDelete();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
}
