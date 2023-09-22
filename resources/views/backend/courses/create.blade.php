@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.courses.store'], 'files' => true]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">@lang('labels.backend.courses.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.courses.index') }}"
                   class="btn btn-success">@lang('labels.backend.courses.view')</a>
            </div>
        </div>

        <div class="card-body">
            @if (Auth::user()->isAdmin())
                <div class="row">
                    <div class="col-10 form-group">
                        {!! Form::label('teachers',trans('labels.backend.courses.fields.teachers'), ['class' => 'control-label']) !!}
                        {!! Form::select('teachers[]', $teachers, old('teachers'), ['class' => 'form-control select2 js-example-placeholder-multiple', 'multiple' => 'multiple', 'required' => true]) !!}
                    </div>
                    <div class="col-2 d-flex form-group flex-column">
                        OR <a target="_blank" class="btn btn-primary mt-auto"
                              href="{{route('admin.teachers.create')}}">{{trans('labels.backend.courses.add_teachers')}}</a>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('category_id',trans('labels.backend.courses.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required' => true]) !!}
                </div>
                <div class="col-2 d-flex form-group flex-column">
                    OR <a target="_blank" class="btn btn-primary mt-auto"
                          href="{{route('admin.categories.index').'?create'}}">{{trans('labels.backend.courses.add_categories')}}</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', trans('labels.backend.courses.fields.title').' *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.title'), 'required' => false]) !!}
                </div>
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('slug',  trans('labels.backend.courses.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' =>  trans('labels.backend.courses.slug_placeholder')]) !!}

                </div>
            </div>
            <div class="row">

                <div class="col-12 form-group">
                    {!! Form::label('description',  trans('labels.backend.courses.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control editor', 'placeholder' => trans('labels.backend.courses.fields.description')]) !!}

                </div>
            </div>
                <div class="row">
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('price', trans('labels.backend.courses.fields.price').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']) !!}
                        {!! Form::number('price', old('price'), ['required' => true,'class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.price') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('strike', trans('labels.backend.courses.fields.strike').' (in '.$appCurrency["symbol"].')', ['class' => 'control-label']) !!}
                        {!! Form::number('strike', old('strike'), ['required' => true, 'class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.strike') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('KES_cost', trans('labels.backend.courses.fields.KES_cost'))!!}
                        {!! Form::number('KES_cost', old('KES_cost'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.KES_cost') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('USD_cost', trans('labels.backend.courses.fields.USD_cost'))!!}
                        {!! Form::number('USD_cost', old('USD_cost'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.USD_cost') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('AUD_cost', trans('labels.backend.courses.fields.AUD_cost')) !!}
                        {!! Form::number('AUD_cost', old('AUD_cost'), ['required' => true,'class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.AUD_cost') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('EUR_cost', trans('labels.backend.courses.fields.EUR_cost')) !!}
                        {!! Form::number('EUR_cost', old('EUR_cost'), ['required' => true,'class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.EUR_cost') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('GBP_cost', trans('labels.backend.courses.fields.GBP_cost')) !!}
                        {!! Form::number('GBP_cost', old('GBP_cost'), ['required' => true,'class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.GBP_cost') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('CAD_cost', trans('labels.backend.courses.fields.CAD_cost')) !!}
                        {!! Form::number('CAD_cost', old('CAD_cost'), ['required' => true,'class' => 'form-control','placeholder' => trans('labels.backend.courses.fields.CAD_cost') ,'step' => 'any', 'pattern' => "[0-9]"]) !!}
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12 col-lg-4 form-group">

                        {!! Form::label('course_image', trans('labels.backend.courses.fields.course_image'), ['class' => 'control-label','accept' => 'image/jpeg,image/gif,image/png']) !!}
                        {!! Form::file('course_image', ['class' => 'form-control']) !!}
                        {!! Form::hidden('course_image_max_size', 8) !!}
                        {!! Form::hidden('course_image_max_width', 4000) !!}
                        {!! Form::hidden('course_image_max_height', 4000) !!}

                    </div>
                    <div class="col-12 col-lg-4 form-group">
                        {!! Form::label('start_date', trans('labels.backend.courses.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                        {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('start_date'))
                            <p class="help-block">
                                {{ $errors->first('start_date') }}
                            </p>
                        @endif
                    </div>
                    @if (Auth::user()->isAdmin())
                        <div class="col-12 col-lg-4 form-group">
                            {!! Form::label('expire_at', trans('labels.backend.courses.fields.expire_at').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                            {!! Form::text('expire_at', old('expire_at'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.expire_at').' (Ex . 2019-01-01)','autocomplete' => 'off']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('expire_at'))
                                <p class="help-block">
                                    {{ $errors->first('expire_at') }}
                                </p>
                            @endif
                        </div>
                    @endif

                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        {!! Form::label('add_video', trans('labels.backend.lessons.fields.add_video'), ['class' => 'control-label']) !!}

                        {!! Form::select('media_type', ['youtube' => 'Youtube','vimeo' => 'Vimeo','upload' => 'Upload','embed' => 'Embed'],null,['class' => 'form-control', 'placeholder' => 'Select One','id'=>'media_type' ]) !!}

                        {!! Form::text('video', old('video'), ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video'  ]) !!}


                        {!! Form::file('video_file', ['class' => 'form-control mt-3 d-none', 'placeholder' => trans('labels.backend.lessons.enter_video_url'),'id'=>'video_file'  ]) !!}

                    </div>
                    {{--<div class="col-md-12 form-group d-none" id="video_subtitle_box">--}}

                        {{--{!! Form::label('add_subtitle', trans('labels.backend.lessons.fields.add_subtitle'), ['class' => 'control-label']) !!}--}}

                        {{--{!! Form::file('video_subtitle', ['class' => 'form-control', 'placeholder' => trans('labels.backend.lessons.video_subtitle'),'id'=>'video_subtitle'  ]) !!}--}}

                    {{--</div>--}}
                    <div class="col-md-12 form-group">

                    @lang('labels.backend.lessons.video_guide')
                    </div>

                </div>

                <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('published', 0) !!}
                        {!! Form::checkbox('published', 1, false, []) !!}
                        {!! Form::label('published',  trans('labels.backend.courses.fields.published'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    @if (Auth::user()->isAdmin())


                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('featured', 0) !!}
                        {!! Form::checkbox('featured', 1, false, []) !!}
                        {!! Form::label('featured',  trans('labels.backend.courses.fields.featured'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('trending', 0) !!}
                        {!! Form::checkbox('trending', 1, false, []) !!}
                        {!! Form::label('trending',  trans('labels.backend.courses.fields.trending'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('popular', 0) !!}
                        {!! Form::checkbox('popular', 1, false, []) !!}
                        {!! Form::label('popular',  trans('labels.backend.courses.fields.popular'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>

                    @endif

                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('free', 0) !!}
                        {!! Form::checkbox('free', 1, false, []) !!}
                        {!! Form::label('free',  trans('labels.backend.courses.fields.free'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>


                </div>

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('meta_title',trans('labels.backend.courses.fields.meta_title'), ['class' => 'control-label']) !!}
                    {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_title')]) !!}

                </div>
                <div class="col-12 form-group">
                    {!! Form::label('meta_description',trans('labels.backend.courses.fields.meta_description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_description')]) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::label('meta_keywords',trans('labels.backend.courses.fields.meta_keywords'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_keywords', old('meta_keywords'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.courses.fields.meta_keywords')]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12  text-center form-group">

                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@stop

@push('after-scripts')
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script>
        $('.editor').each(function () {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
                extraPlugins: 'smiley,lineutils,widget,codesnippet,prism,flash,colorbutton,colordialog',
            });

        });

        $(document).ready(function () {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            var dateToday = new Date();
            $('#expire_at').datepicker({
                autoclose: true,
                minDate: dateToday,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            $(".js-example-placeholder-single").select2({
                placeholder: "{{trans('labels.backend.courses.select_category')}}",
            });

            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{trans('labels.backend.courses.select_teachers')}}",
            });
        });

        var uploadField = $('input[type="file"]');

        $(document).on('change', 'input[type="file"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        })


        $(document).on('change', '#media_type', function () {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true)
                    $('#video_file').addClass('d-none').attr('required', false)
//                    $('#video_subtitle_box').addClass('d-none').attr('required', false)

                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false)
                    $('#video_file').removeClass('d-none').attr('required', true)
//                    $('#video_subtitle_box').removeClass('d-none').attr('required', true)
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false)
//                $('#video_subtitle_box').addClass('d-none').attr('required', false)
                $('#video').addClass('d-none').attr('required', false)
            }
        })


    </script>

@endpush
