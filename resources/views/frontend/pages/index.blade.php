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
                                    Our Ethos
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

            <div class="row bg0 p-t-100 p-b-50">
                <div class="col-md-12">
                    <div class="">
                        <h3 class="mtext-111 cl2 txt-center respon1">
                            MEET OUR AMAZING LEADERSHIP
                        </h3>
                        <p class="txt-center">
                            The McAfee Institute team are some of the most passionate, caring and helpful professionals
                            within the law enforcement, intelligence and investigative sectors.
                        </p>
                    </div>
                    <!-- Banner -->
                    <div class="sec-banner bg0 p-t-50">
                        <div class="flex-w flex-c-m">
                            <div class="size-202 m-lr-auto respon4">
                                <!-- Block1 -->
                                <div class="block1 wrap-pic-w team">
                                    <img src="{{ asset('storage/teams/joshua.png') }}" alt="Joshua Mcafee">

                                    <a href="product.html"
                                        class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                        <div class="block1-txt-child1 flex-col-l">
                                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                                Joshua Mcafee
                                            </span>

                                            <span class="block1-info stext-102 trans-04">
                                                CEO & Founder
                                            </span>
                                        </div>

                                        <div class="block1-txt-child2 p-b-4 trans-05">
                                            <div class="block1-link stext-101 cl0 trans-09">
                                                More Details
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="size-202 m-lr-auto respon4">
                                <!-- Block1 -->
                                <div class="block1 wrap-pic-w">
                                    <img src="{{ asset('storage/teams/nicole.png')}}" alt="IMG-BANNER">

                                    <a href="product.html"
                                        class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                        <div class="block1-txt-child1 flex-col-l">
                                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                                Nicole Mcafee
                                            </span>

                                            <span class="block1-info stext-102 trans-04">
                                                Chief Academic Officer(CAO)
                                            </span>
                                        </div>

                                        <div class="block1-txt-child2 p-b-4 trans-05">
                                            <div class="block1-link stext-101 cl0 trans-09">
                                                More Details
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="size-202 m-lr-auto respon4">
                                <!-- Block1 -->
                                <div class="block1 wrap-pic-w">
                                    <img src="{{ asset('storage/teams/terry.png')}}" alt="Terry Farris" style="width: 83%;">
                
                                    <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                        <div class="block1-txt-child1 flex-col-l">
                                            <span class="block1-name ltext-102 trans-04 p-b-8">
                                                Bags
                                            </span>
                
                                            <span class="block1-info stext-102 trans-04">
                                                New Trend
                                            </span>
                                        </div>
                
                                        <div class="block1-txt-child2 p-b-4 trans-05">
                                            <div class="block1-link stext-101 cl0 trans-09">
                                                Shop Now
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--/.row -->
        </div>
        <!--/.container -->
    </section>


@endsection
