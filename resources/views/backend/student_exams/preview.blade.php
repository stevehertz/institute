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
                            <th>Supervisor</th>
                            @if($exam->supervisor->count()>0)
                            <td>{!! $exam->supervisor[0]['first_name'] !!} {!! $exam->supervisor[0]['last_name'] !!}</td>
                            @endif
                        </tr>

                        <tr>
                            <th>Scheduled time</th>
                            <td>{!! $exam->scheduled_start_time !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.exams.fields.published')</th>
                            <td>{{ Form::checkbox("status", 1, $exam->status == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('admin.studentExams') }}" class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>

                </div>
                <div class="col-md-3">
                    @if($exam->exam_status =='ongoing')

                        <form action="{{route('admin.exam.studentExamStarted')}}" method="POST">
                            @csrf
                            <input type="hidden" name="uniqueExam" value="{{$exam->uniqueExamId}}">
                            <input type="submit" value="Go to Exam" class="btn mb-1 btn-danger">
                        </form>

                    @elseif($exam->exam_status =='scheduled')
                        Scheduled to start on: {{$exam->scheduled_start_time}}
                    @elseif($exam->exam_status == 'completed')
                        <span class="bg-success"><i class="icon-check">Exam Completed</i> </span>
                    @elseif($exam->exam_status == 'cancelled')
                        <span class="bg-danger"><i class="icon-check">Exam Cancelled</i> </span>
                    @elseif($exam->exam_status == 'postponed')
                        <span class="bg-danger"><i class="icon-check">Exam Postponed</i> </span>
                    @elseif($exam->exam_status == 'paused')
                        <span class="bg-success"><i class="icon-check">Exam Paused</i> </span>
                    @else
                        Status Unknown <span class="btn btn-success" onClick="refreshPage()">Click here to refresh status</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
@stop

@stack('before-scripts')

<script>
    function refreshPage(){
        window.location.reload();
    }
</script>
@stack('after-scripts')