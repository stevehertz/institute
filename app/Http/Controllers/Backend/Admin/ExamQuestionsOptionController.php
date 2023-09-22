<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\ExamQuestionsOption;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionsOptionsRequest;
use App\Http\Requests\Admin\UpdateQuestionsOptionsRequest;
use \Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class ExamQuestionsOptionController extends Controller
{
    /**
     * Display a listing of QuestionsOption.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('questions_option_access')) {
            return abort(401);
        }

        return view('backend.exam_questions_options.index', compact('exam_questions_options'));
    }

    /**
     * Display a listing of QuestionsOption via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        if ($request->show_deleted == 1) {
            if (!Gate::allows('questions_option_delete')) {
                return abort(401);
            }
            $questions_options = ExamQuestionsOption::query()->with('question')->onlyTrashed()->get();
        } else {
            $questions_options = ExamQuestionsOption::query()->with('question')->get();
        }

        if (auth()->user()->can('questions_option_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('questions_option_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('questions_option_delete')) {
            $has_delete = true;
        }

        return DataTables::of($questions_options)
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.exam_questions_options', 'label' => 'questions_option', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.exam_questions_options.show', ['questions_option' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.exam_questions_options.edit', ['questions_option' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.exam_questions_options.destroy', ['questions_option' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                return $view;

            })
            ->editColumn('question', function ($q) {
                return ($q->question) ? $q->question->question : '';
            })
            ->editColumn('correct', function ($q) {
                return ($q->correct == 1) ? "Yes" : "No";
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Show the form for creating new QuestionsOption.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('questions_option_create')) {
            return abort(401);
        }
        $questions = ExamQuestion::get()->pluck('question', 'id')->prepend('Please select', '');

        return view('backend.exam_questions_options.create', compact('questions'));
    }

    /**
     * Store a newly created QuestionsOption in storage.
     *
     * @param  \App\Http\Requests\StoreExamQuestionsOptionsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionsOptionsRequest $request)
    {
        if (!Gate::allows('questions_option_create')) {
            return abort(401);
        }
        $questions_option = ExamQuestionsOption::create($request->all());


        return redirect()->route('admin.exam_questions_options.index');
    }


    /**
     * Show the form for editing QuestionsOption.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('questions_option_edit')) {
            return abort(401);
        }
        $questions = ExamQuestion::get()->pluck('question', 'id')->prepend('Please select', '');

        $questions_option = ExamQuestionsOption::findOrFail($id);

        return view('backend.exam_questions_options.edit', compact('questions_option', 'questions'));
    }

    /**
     * Update QuestionsOption in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionsOptionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionsOptionsRequest $request, $id)
    {
        if (!Gate::allows('questions_option_edit')) {
            return abort(401);
        }
        $questions_option = ExamQuestionsOption::findOrFail($id);
        $questions_option->update($request->all());


        return redirect()->route('admin.exam_questions_options.index');
    }


    /**
     * Display QuestionsOption.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('questions_option_view')) {
            return abort(401);
        }
        $questions_option = ExamQuestionsOption::findOrFail($id);

        return view('backend.exam_questions_options.show', compact('questions_option'));
    }


    /**
     * Remove QuestionsOption from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        $questions_option = ExamQuestionsOption::findOrFail($id);
        $questions_option->delete();

        return redirect()->route('admin.exam_questions_options.index');
    }

    /**
     * Delete all selected QuestionsOption at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = ExamQuestionsOption::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore QuestionsOption from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        $questions_option = ExamQuestionsOption::onlyTrashed()->findOrFail($id);
        $questions_option->restore();

        return redirect()->route('admin.exam_questions_options.index');
    }

    /**
     * Permanently delete QuestionsOption from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('questions_option_delete')) {
            return abort(401);
        }
        $questions_option = ExamQuestionsOption::onlyTrashed()->findOrFail($id);
        $questions_option->forceDelete();

        return redirect()->route('admin.exam_questions_options.index');
    }
}
