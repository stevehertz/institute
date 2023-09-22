@extends('frontend.layouts.app'.config('theme_layout'))

@push('after-styles')
    {{--<link rel="stylesheet" href="{{asset('plugins/YouTube-iFrame-API-Wrapper/css/main.css')}}">--}}
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/>
    <link href="{{asset('plugins/touchpdf-master/jquery.touchPDF.css')}}" rel="stylesheet">

    <style>
        .test-form {
            color: #333333;
        }

        .course-details-category ul li {
            width: 100%;
        }

        .sidebar.is_stuck {
            top: 15% !important;
        }

        .course-timeline-list {
            max-height: 300px;
            overflow: scroll;
        }

        .options-list li {
            list-style-type: none;
        }

        .options-list li.correct {
            color: green;

        }

        .options-list li.incorrect {
            color: red;

        }

        .options-list li.correct:before {
            content: "\f058"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: green;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .options-list li.incorrect:before {
            content: "\f057"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: red;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .options-list li:before {
            content: "\f111"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: black;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .touchPDF {
            border: 1px solid #e3e3e3;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar {
            height: 0;
            color: black;
            padding: 5px 0;
            text-align: right;
        }

        .pdf-tabs {
            width: 100% !important;
        }

        .pdf-outerdiv {
            width: 100% !important;
            left: 0 !important;
            padding: 0px !important;
            transform: scale(1) !important;
        }

        .pdf-viewer {
            left: 0px;
            width: 100% !important;
        }

        .pdf-drag {
            width: 100% !important;
        }

        .pdf-outerdiv {
            left: 0px !important;
        }

        .pdf-outerdiv {
            padding-left: 0px !important;
            left: 0px;
        }

        .pdf-toolbar {
            left: 0px !important;
            width: 99% !important;
            height: 30px;
        }

        .pdf-viewer {
            box-sizing: border-box;
            left: 0 !important;
            margin-top: 10px;
        }

        .pdf-title {
            display: none !important;
        }

        @media screen  and  (max-width: 768px) {

        }

    </style>
@endpush
@section('content')
    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span>{{$exam->title}}</span> (Exam Results)</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->
    @if(count($exam->questions) > 0  )
        <hr>
        <div class="container-fluid">
            <h4>Total Score {{$exam->total_score}}, Passmark : {{$exam->pass_mark}}</h4>
            <h4>Your score {{$exam_result->exam_result}}, Status: @if($exam_result->exam_result < $exam->pass_mark)
                    Failed @else Passed @endif</h4>
            @foreach ($exam->questions as $question)

                <h4 class="mb-0">{{ $loop->iteration }}
                    . {!! $question->question !!}   @if(!$question->isAttempted($exam_result->id))
                        <small class="badge badge-danger"> @lang('labels.frontend.course.not_attempted')</small> @endif
                </h4>
                <br/>
                <ul class="options-list pl-4">
                    @foreach ($question->options as $option)

                        <li class="@if(($option->answered($exam_result->id) != null && $option->answered($exam_result->id) == 1) || ($option->correct == true)) correct @elseif($option->answered($exam_result->id) != null && $option->answered($exam_result->id) == 2) incorrect  @endif"> {{ $option->option_text }}

                            @if($option->correct == 1 && $option->explanation != null)
                                <p class="text-dark">
                                    <b>@lang('labels.frontend.course.explanation')</b><br>
                                    {{$option->explanation}}
                                </p>
                            @endif
                        </li>

                    @endforeach
                </ul>
                <br/>
            @endforeach

            @else
                <h3>@lang('labels.general.no_data_available')</h3>
        </div>
    @endif
@endsection