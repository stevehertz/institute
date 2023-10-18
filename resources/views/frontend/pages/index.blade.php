@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', $page->meta_title ? $page->meta_title : app_name())
@section('meta_description', $page->meta_description ? $page->meta_description : '')
@section('meta_keywords', $page->meta_keywords ? $page->meta_keywords : app_name())

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('storage/images/bg-01.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            <span>{{ $page->title }}</span>
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container">

            <div class="row p-b-148">

                <div class="col-md-7 col-lg-8">
                    <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                        <h3 class="mtext-111 cl2 p-b-16">
                            {{ $page->title }}
                        </h3>

                        {!! $page->content !!}

                        @if ($page->title == 'About Us')
                            <br>
                            <h3 class="mtext-111 cl2 p-b-16">
                                Our Ethos
                            </h3>

                            <div class="bor16 p-l-29 p-b-9 m-t-22">
                                <p class="stext-114 cl6 p-r-40 p-b-11">
                                    To be the global professional institution of choice for many generations of the future
                                    where
                                    professionalism, character and intelligence is embedded whereas commitment to ethical
                                    leadership and social responsibility is illuminated.
                                </p>

                                {{-- <span class="stext-111 cl8">
                                - Steve Job’s
                            </span> --}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                    <div class="how-bor1 ">
                        <div class="hov-img0">
                            <img src="{{ asset('storage/images/about-01.jpg') }}" alt="IMG">
                        </div>
                    </div>

                </div>
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <!-- Tab01 -->
                    <div class="tab01">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item p-b-10">
                                <a class="nav-link active" data-toggle="tab" href="#nothStarTab" role="tab">
                                    North Star
                                </a>
                            </li>

                            <li class="nav-item p-b-10">
                                <a class="nav-link" data-toggle="tab" href="#valueTab" role="tab">
                                    Value
                                </a>
                            </li>

                            <li class="nav-item p-b-10">
                                <a class="nav-link" data-toggle="tab" href="#visionTab" role="tab">
                                    Vision
                                </a>
                            </li>

                            <li class="nav-item p-b-10">
                                <a class="nav-link" data-toggle="tab" href="#missionTab" role="tab">
                                    Mission
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-t-50">
                            <!-- - -->
                            <div class="tab-pane fade show active" id="nothStarTab" role="tabpanel">
                                <br>
                                <h3 class="mtext-111 cl2 txt-center respon1">
                                    Our North Star
                                </h3>
                                <br>
                                <p class="txt-center">
                                    "To be the global standard in professional training and certification for intelligence,
                                    investigations, and law enforcement, transforming individuals into leaders who enact
                                    change, safeguard communities, and embody justice."
                                </p>
                            </div>

                            <!-- - -->
                            <div class="tab-pane fade" id="valueTab" role="tabpanel">
                                <br>
                                <h3 class="mtext-111 cl2 txt-center respon1">
                                    Institutional Values
                                </h3>
                                <br>
                                <p class="txt-center">
                                    Innovation, Sustainability, Diversity, Equity & Inclusion
                                </p>
                            </div>

                            <!-- - -->
                            <div class="tab-pane fade" id="visionTab" role="tabpanel">
                                <br>
                                <h3 class="mtext-111 cl2 txt-center respon1">
                                    Our Vision Statement
                                </h3>
                                <br>
                                <p class="txt-center">
                                    Our vision is to be the global professional training and certification company for
                                    cybersecurity, intelligence and investigations.
                                </p>
                            </div>

                            <!-- - -->
                            <div class="tab-pane fade" id="missionTab" role="tabpanel">

                                <br>
                                <h3 class="mtext-111 cl2 txt-center respon1">
                                    Our Mission Statement
                                </h3>
                                <br>
                                <p class="txt-center">
                                    Our mission is to provide advanced and latest cybersecurity training tools that empowers
                                    professionals to transform their areas of work with precision.
                                </p>

                            </div>
                        </div>
                    </div>

                </div>
                <!--/.col-md-12-->
            </div>
            <!--/.row -->
        </div>
        <!--/.container -->
    </section>


@endsection
