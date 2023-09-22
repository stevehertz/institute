@extends('backend.layouts.app')
@section('title', __('labels.backend.exams.title').' | '.app_name())

@push('after-styles')
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

    </style>
@endpush
@section('content')

    {!! Form::model($exam, ['method' => 'PUT', 'route' => ['admin.exams.update', $exam->id]]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.exams.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.exams.index') }}"
                   class="btn btn-success">@lang('labels.backend.exams.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('course_id',trans('labels.backend.exams.fields.course'), ['class' => 'control-label']) !!}
                    {!! Form::select('course_id', $courses, old('course_id'), ['class' => 'form-control select2']) !!}
                </div>

                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('supervisor_id',trans('labels.backend.exams.fields.supervisor'), ['class' => 'control-label']) !!}
                    {!! Form::select('supervisor_id', $supervisors, old('supervisor_id'), ['class' => 'form-control select2']) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('supervisor_id', trans('labels.backend.exams.fields.invigilators'), ['class' => 'control-label']) !!}
                    {!! Form::select('supervisors[]', $supervisors, old('supervisors'), ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => 'multiple', 'required' => true]) !!}

                </div>

                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('labels.backend.exams.fields.title'), ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.exams.fields.title')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('scheduled_start_time',trans('labels.backend.exams.fields.scheduled_start_time'), ['class' => 'control-label border-danger']) !!}
                    {!! Form::datetimeLocal('scheduled_start_time', old('scheduled_start_time'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.exams.fields.scheduled_date')]) !!}

                </div>
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('scheduled_end_time',trans('labels.backend.exams.fields.scheduled_end_time'), ['class' => 'control-label']) !!}
                    {!! Form::datetimeLocal('scheduled_end_time', old('scheduled_end_time'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.exams.fields.scheduled_end_time')]) !!}

                </div>
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('total_score',trans('labels.backend.exams.fields.total_score'), ['class' => 'control-label']) !!}
                    {!! Form::number('total_score', old('total_score'), ['class' => 'form-control',  'placeholder' => trans('labels.backend.exams.fields.total_score')]) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('pass_mark',trans('labels.backend.exams.fields.pass_mark'), ['class' => 'control-label']) !!}
                    {!! Form::number('pass_mark', old('pass_mark'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.exams.fields.pass_mark')]) !!}

                </div>
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('fail_mark',trans('labels.backend.exams.fields.fail_mark'), ['class' => 'control-label']) !!}
                    {!! Form::number('fail_mark', old('fail_mark'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.exams.fields.fail_mark')]) !!}

                </div>
                <div class="col-12 col-lg-4  form-group">
                    {!! Form::label('exam_status',trans('labels.backend.exams.fields.exam_status'), ['class' => 'control-label']) !!}
                    {!! Form::text('exam_status', old('exam_status'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.exams.fields.exam_status')]) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::hidden('status', 1) !!}
                    {!! Form::checkbox('status', 1, old('status'), []) !!}
                    {!! Form::label('published', trans('labels.backend.exams.fields.published'), ['class' => 'control-label font-weight-bold']) !!}

                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('examinationType', 'Examination Type', ['class' => 'control-label font-weight-bold']) !!}
                    {{Form::select('examinationType', array(1 => 'Multiple choices', 2 => 'Written'), old('examinationType'), ['class' => 'form-control font-weight-bold'])}}
                </div>

            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('status', 'Exam instructions', ['class' => 'control-label font-weight-bold']) !!}
                    {!! Form::textarea('exam_instructions', old('exam_instructions'), ['class' => 'form-control ckeditor', 'placeholder' => trans('labels.backend.categories.fields.description'), 'required' => false]) !!}

                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn  btn-danger']) !!}
    {!! Form::close() !!}
@stop
@push('after-scripts')
    <script src="{{asset('ckeditor/standard/ckeditor.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush

