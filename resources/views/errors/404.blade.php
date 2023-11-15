@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', trans('labels.frontend.home.title') . ' | ' . app_name())
@section('meta_description', '')
@section('meta_keywords', '')

@push('after-styles')
    <style>
        .b-not_found {
            padding-bottom: 100px;
            padding-top: 50px;
        }

        .b-not_found .b-page_header {
            border-bottom: 0;
            padding-bottom: 0;
            margin: 0;
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
        }

        .b-not_found .b-page_header::before {
            content: "404";
            top: 0;
            width: 100%;
            text-align: center;
            left: 0;
            position: absolute;
            color: rgba(142, 142, 142, 0.15);
            font-size: 400px;
            line-height: 320px;
            font-weight: 700;
        }

        .b-not_found .b-page_header h1 {
            margin: auto;
            padding: 115px 0;
            text-align: center;
            text-transform: uppercase;
            color: #17d0cf;
            opacity: .8;
            letter-spacing: 3px;
            font-size: 75px;
            font-weight: 700;
        }

        .b-not_found h2 {
            font-size: 36px;
            letter-spacing: 1px;
            line-height: 1.5;
            color: #1B1919;
            font-weight: bold;
        }

        .b-not_found p {
            line-height: 1.7;
            color: #8E8E8E;
            margin-bottom: 20px;
        }

        .b-not_found .b-searchform {
            max-width: 350px;
            margin: auto;
            position: relative;
        }

        .b-not_found .b-searchform input {
            width: 100%;
            height: 40px;
            position: relative;
            padding-right: 105px;
            border: 1px solid rgba(129, 129, 129, 0.25);
            font-size: 14px;
            line-height: 18px;
            padding: 0 10px;
            transition: border-color .5s;
            box-shadow: none;
            border-radius: 0;
        }

        .b-not_found .b-searchform .btn {
            cursor: pointer;
            background-color: #1daaa3;
            color: #fff;
            position: absolute;
            right: 0;
            top: 0;
        }

        .b-not_found .b-searchform .btn:hover {
            opacity: 0.75;
        }

        @media (max-width: 990px) {
            .b-not_found .b-page_header::before {
                font-size: 300px;
            }

            .b-not_found h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 767px) {
            .b-not_found .b-page_header h1 {
                font-size: 35px;
                padding: 55px 0;
            }

            .b-not_found .b-page_header::before {
                font-size: 150px;
                line-height: 150px;
            }

            .b-not_found h2 {
                font-size: 22px;
            }

            .b-not_found .b-searchform {
                max-width: 300px;
            }
        }
    </style>
@endpush

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('storage/images/bg-02.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            <span>@lang('http.404.title2')</span>
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container">
            <div class="row  p-b-148">
                <div class="col-md-12">
                    <div class="b-not_found w-100">
                        <div class="text-center">
                            <div class="b-page_header p-b-45">
                                <h1 class="page-title ltext-106 cl5 txt-center">
                                    @lang('http.404.title')
                                </h1>
                            </div>
                            <h2 class="p-b-10">
                                @lang('http.404.description')
                            </h2>
                            <p class="p-b-10">
                                @lang('http.404.description2')
                            </p>
                            <div class="nws-button genius-btn text-center  d-inline-block text-uppercase">
                                <a href="{{ url('/') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    @lang('http.404.back')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.container -->
    </section>


@endsection
