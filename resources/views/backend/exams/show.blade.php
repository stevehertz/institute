@extends('backend.layouts.app')
@section('title', __('labels.backend.exams.title').' | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.exams.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.exams.fields.course')</th>
                            <td>{{ ($exam->course) ? $exam->course->title : 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.exams.fields.title')</th>
                            <td>{{ $exam->title }}</td>
                        </tr>
                        <tr>
                            <th>Exam status</th>
                            <td>{!! $exam->exam_status !!}</td>
                        </tr>
                        <tr>
                            <th>Exam UniqueID</th>
                            <td>{!! $exam->uniqueExamId !!}</td>
                        </tr>
                        <tr>
                            <th>Scheduled time</th>
                            <td>{!! $exam->scheduled_start_time !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.exams.fields.questions')</th>
                            <td>
                                <ol class="pl-3 mb-0">
                                    @foreach ($exam->questions as $singleQuestions)
                                        <li class="label label-info label-many">{{ $singleQuestions->question }}</li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.exams.fields.students_enrolled') ({{$exam->students->count()}})
                            </th>
                            <td>
                                <ol class="pl-3 mb-0">
                                    @foreach ($exam->students as $student)
                                        <li class="label label-info label-many">{{ $student->first_name }}</li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.exams.fields.published')</th>
                            <td>{{ Form::checkbox("status", 1, $exam->status == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-3">
                    <a href="{{ route('admin.exams.index') }}"
                       class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>

                </div>

                @if($exam->status == 'scheduled')
                    <div class="col-md-3">
                        <form name="superVisorExam" action="{{route('admin.exam.superVisorStartExam')}}" method="POST">
                            {{ csrf_field() }}
                            <input name="exam_id" value="{{$exam->id}}" type="hidden">
                            <input name="exam_status" type="hidden" value="ongoing">
                            <input type="submit" value="Start Exam" class="btn btn-primary">
                        </form>
                    </div>
                @elseif($exam->exam_status == 'ongoing')
                    <div class="col-md-3">
                        <form name="superVisorExam" action="{{route('admin.exam.superVisorEndExam')}}" method="POST">
                            {{ csrf_field() }}
                            <input name="exam_id" value="{{$exam->id}}" type="hidden">
                            <input name="exam_status" type="hidden" value="completed">
                            <input type="submit" value="End Exam" class="btn btn-danger">
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form name="superVisorExam" action="{{route('admin.exam.superVisorCancelExam')}}" method="POST">
                            {{ csrf_field() }}
                            <input name="exam_id" value="{{$exam->id}}" type="hidden">
                            <input name="exam_status" type="hidden" value="cancelled">
                            <input type="submit" value="Cancel Exam" class="btn btn-danger">
                        </form>
                    </div>
                @elseif($exam->exam_status == 'completed')
                    <div class="col-md-3">
                        <form name="superVisorExam" action="{{route('admin.exam.superVisorViewResults')}}"
                              method="POST">
                            {{ csrf_field() }}
                            <input name="exam_id" value="{{$exam->id}}" type="hidden">
                            <input type="submit" value="View results">
                        </form>
                    </div>
                @elseif($exam->exam_status == 'cancelled')
                    <div class="col-md-3">
                        <form name="superVisorExam" action="{{route('admin.exam.superVisorRescheduleExam')}}"
                              method="POST">
                            {{ csrf_field() }}
                            <input name="exam_id" value="{{$exam->id}}" type="hidden">
                            <input name="exam_status" type="hidden" value="scheduled">
                            <input type="submit" value="Reschedule Exam" class="btn btn-danger">
                        </form>
                    </div>
                @endif


                <div class="col-md-3"></div>

            </div>

        </div>
    </div>
@stop