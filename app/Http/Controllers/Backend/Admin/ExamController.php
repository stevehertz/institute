<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Requests\Admin\StoreExamsRequest;
use App\Http\Requests\Admin\UpdateExamsRequest;
use App\Models\Auth\User;
use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\CourseTimeline;
use App\Models\Exam;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ExamTimeline;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('exam_access')) {
            return abort(401);
        }

        $courses = Course::ofTeacher()->whereHas('exams')->pluck('title', 'id')->prepend('Please select', '');
        return view('backend.exams.index', compact( 'courses'));
    }

    /**
     * Display a listing of Courses via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        $exams = "";


        if ($request->course_id != "") {
            $exams = Exam::query()->where('course_id', '=', $request->course_id)->orderBy('created_at', 'desc');
        }

        if (request('show_deleted') == 1) {
            if (!Gate::allows('exam_delete')) {
                return abort(401);
            }
            $exams = Exam::query()->onlyTrashed();
        }


        if (auth()->user()->can('exam_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('exam_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('exam_delete')) {
            $has_delete = true;
        }

        return DataTables::of($exams)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.exams', 'label' => 'id', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.exams.show', ['exam' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.exams.edit', ['exam' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.exams.destroy', ['exam' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->addColumn('questions', function ($q) {
                if (count($q->questions) > 0) {
                    return "<span>".count($q->questions)."</span><a class='btn btn-success float-right' href='".route('admin.exam_questions.index', ['exam_id'=>$q->id])."'><i class='fa fa-arrow-circle-o-right'></i></a> ";
                }
                return count($q->questions);
            })

            ->addColumn('course', function ($q) {
                return ($q->course) ? $q->course->title : "N/A";
            })

            ->addColumn('lesson', function ($q) {
                return ($q->lesson) ? $q->lesson->title : "N/A";
            })

            ->editColumn('status', function ($q) {
                return ($q->status == 1) ? "Yes" : "No";
            })
            ->rawColumns(['actions','questions'])
            ->make();
    }

    /**
     * Show the form for creating new Exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('exam_create')) {
            return abort(401);
        }
        $courses = \App\Models\Course::ofTeacher()->get()->sortByDesc('created_at');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $supervisors = User::role('teacher')->pluck('first_name', 'id');
        return view('backend.exams.create', compact('courses', 'supervisors'));
    }

    /**
     * Store a newly created Exam in storage.
     *
     * @param  \App\Http\Requests\StoreExamsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExamsRequest $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'title' => 'required',
        ], ['course_id.required' => 'The course field is required'],
        ['supervisor.required'  =>'The supervisor field is required']
        );

        if (! Gate::allows('exam_create')) {
            return abort(401);
        }


        $exam = Exam::create($request->all());
        $exam->slug = str_slug($request->title);
        $exam->uniqueExamId = uniqid('E');
        $exam->save();

        $sequence = 1;
        if (count($exam->course->courseTimeline) > 0) {
            $sequence = $exam->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ($exam->status == 1) {
            $timeline = ExamTimeline::where('model_type', '=', Exam::class)
                ->where('model_id', '=', $exam->id)
                ->where('exam_id', $request->exam_id)->first();
            if ($timeline == null) {
                $timeline = new ExamTimeline();
            }
            $timeline->exam_id = $request->exam_id;
            $timeline->model_id = $exam->id;
            $timeline->model_type = Exam::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }

        $supervisors = \Auth::user()->isAdmin() ? array_filter((array)$request->input('supervisors')) : [\Auth::user()->id];
        $exam->supervisor()->sync($supervisors);

        return redirect()->route('admin.exams.index')->withFlashSuccess(trans('alerts.backend.general.created'));
    }


    /**
     * Show the form for editing Exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('exam_edit')) {
            return abort(401);
        }
        $courses = \App\Models\Course::ofTeacher()->get();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $supervisors = User::pluck('first_name', 'id')->prepend('Please select', '');
        $exam = Exam::findOrFail($id);

        return view('backend.exams.edit', compact('exam', 'courses', 'supervisors'));
    }

    /**
     * Update Exam in storage.
     *
     * @param  \App\Http\Requests\UpdateExamsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExamsRequest $request, $id)
    {
        if (! Gate::allows('exam_edit')) {
            return abort(401);
        }
        $exam = Exam::findOrFail($id);
        $exam->update($request->all());
        $exam->slug = str_slug($request->title);
        $exam->save();


        $sequence = 1;
        if (count($exam->course->courseTimeline) > 0) {
            $sequence = $exam->course->courseTimeline->max('sequence');
            $sequence = $sequence + 1;
        }

        if ($exam->published == 1) {
            $timeline = CourseTimeline::where('model_type', '=', Exam::class)
                ->where('model_id', '=', $exam->id)
                ->where('course_id', $request->course_id)->first();
            if ($timeline == null) {
                $timeline = new CourseTimeline();
            }
            $timeline->course_id = $request->course_id;
            $timeline->model_id = $exam->id;
            $timeline->model_type = Exam::class;
            $timeline->sequence = $sequence;
            $timeline->save();
        }


        return redirect()->route('admin.exams.index')->withFlashSuccess(trans('alerts.backend.general.updated'));
    }


    /**
     * Display Exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('exam_view')) {
            return abort(401);
        }
        $exam = Exam::findOrFail($id);

        return view('backend.exams.show', compact('exam'));
    }


    /**
     * Remove Exam from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('exam_delete')) {
            return abort(401);
        }
        $exam = Exam::findOrFail($id);
        $exam->chapterStudents()->where('course_id', $exam->course_id)->forceDelete();
        $exam->delete();

        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    /**
     * Delete all selected Exam at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('exam_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Exam::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Exam from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('exam_delete')) {
            return abort(401);
        }
        $exam = Exam::onlyTrashed()->findOrFail($id);
        $exam->restore();

        return back()->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Exam from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('exam_delete')) {
            return abort(401);
        }
        $exam = Exam::onlyTrashed()->findOrFail($id);
        $exam->forceDelete();

        return back()->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    public function superVisorStartExam(Request $request)
    {
        $exam = Exam::findOrFail($request->exam_id);
        $exam->update($request->all());
        $exam->start_time_official = Carbon::now()->format('Y-m-d H:m:s');
        $exam->save();
        return redirect()->back()->with(['flash_success'=>'Exam started successfully']);

    }

     public function superVisorEndExam(Request $request)
    {
        $exam = Exam::findOrFail($request->exam_id);
        $exam->update($request->all());
        $exam->start_time_official = Carbon::now()->format('Y-m-d H:m:s');
        $exam->save();
        return redirect()->back()->with(['flash_success'=>'Exam started successfully']);

    }
     public function superVisorViewResults(Request $request)
    {
        $exam = Exam::findOrFail($request->exam_id);
        $exam->update($request->all());
        $exam->save();
        return redirect()->back()->with(['flash_success'=>'Exam started successfully']);

    }
     public function superVisorRescheduleExam(Request $request)
    {
        $exam = Exam::findOrFail($request->exam_id);
        $exam->update($request->all());
        $exam->start_time_official = Carbon::now()->format('Y-m-d H:m:s');
        $exam->save();
        return redirect()->back()->with(['flash_success'=>'Exam started successfully']);

    }
    public function superVisorCancelExam(Request $request)
    {
        $exam = Exam::findOrFail($request->exam_id);
        $exam->update($request->all());
        $exam->save();
        return redirect()->back()->with(['flash_success'=>'Exam cancelled successfully']);

    }

    public function importQuestionsPage()
    {
        return view('backend.exams.importQuestions');
    }
    public function importQuestions(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('select_file')->getRealPath();
        Excel::import(new QuestionsImport, $path);

        return redirect()->back()->with(['flash_success'=>'Questions imported successfully']);


    }

}
