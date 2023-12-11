@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', $page->meta_title ? $page->meta_title : app_name())
@section('meta_description', $page->meta_description ? $page->meta_description : '')
@section('meta_keywords', $page->meta_keywords ? $page->meta_keywords : app_name())

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-03.jpg') }}');">
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container">
            <div class="row p-b-30">
                <div class="col-md-7 col-lg-8">
                    <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md instructors-badge">

                        <h3 class="mtext-111 cl2 p-b-16 txt-center">
                            {{ $page->title }}
                        </h3>

                        <p class="p-b-20">
                            ICSI recruits the best cybersecurity practitioners to join the ranks of our world-class
                            cadre of
                            instructors. Becoming our Certified instructor is an honor reserved for those who exhibit
                            consistent expertise as practitioners and an insatiable desire to improve the community
                            through
                            education.
                        </p>

                        <a href="{{ route('frontend.auth.teacher.register') }}"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Apply Now
                        </a>
                    </div>
                </div>

                <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                    <div class="">
                        <div class="hov-img0">
                            <img src="{{ asset('storage/uploads/' . $page->image) }}" alt="{{ $page->title }}">
                        </div>
                    </div>

                </div>
            </div>
            <!--/.row -->
            <div class="row">
                <div class="col-md-12 col-lg-12 p-b-10 instructors-content">
                    {!! $page->content !!}
                </div>
            </div>
            <!--/.row -->
        </div>
        <!--/.container -->
    </section>

@endsection
