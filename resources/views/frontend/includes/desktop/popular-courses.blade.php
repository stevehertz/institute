@if (count($popular_courses) > 0)
    <section class="sec-product bg0 p-t-100 p-b-50">
        <div class="container">
            <div class="p-b-32">
                <h3 class="ltext-105 cl5 txt-center respon1">
                    @lang('labels.frontend.layouts.partials.learn_new_skills')
                </h3>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#featuredTab" role="tab">
                            @lang('labels.frontend.layouts.partials.browse_featured_course')
                        </a>
                    </li>
                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#popular" role="tab">
                            @lang('labels.frontend.layouts.partials.popular_courses')
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-50">
                    <div class="tab-pane fade show active" id="featuredTab" role="tabpanel">
                        @if (count($featured_courses) > 0)
                            <!-- Slide2 -->
                            <div class="wrap-slick2">
                                <div class="slick2">
                                    @foreach ($featured_courses as $item)
                                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                            <!-- Block2 -->
                                            <div class="block2">
                                                <div class="block2-pic hov-img0">
                                                    <img src="{{ asset('storage/uploads/' . $item->course_image) }}"
                                                        alt="{{ $item->title }}">

                                                    {{-- <a href="{{ route('courses.show', [$item->slug]) }}"
                                                        class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                        Quick View
                                                    </a> --}}
                                                </div>
                                                <!--/.block2-pic -->
                                                <div class="block2-txt flex-w flex-t p-t-14">
                                                    <div class="block2-txt-child1 flex-col-l ">
                                                        <a href="{{ route('courses.show', [$item->slug]) }}"
                                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                            {{ $item->title }}
                                                        </a>

                                                        <span class="stext-105 cl3">
                                                            {{ $appCurrency['symbol'] . ' ' . $item->price }}
                                                        </span>
                                                    </div>

                                                    {{-- @include('frontend.includes.desktop.wishlist') --}}
                                                </div>
                                            </div>
                                        </div>
                                        <!--/.item-slick2 -->
                                    @endforeach
                                </div>
                                <!--/.slick2 -->
                            </div>
                            <!--/.wrap-slick2 -->
                        @endif
                    </div>
                    <div class="tab-pane fade" id="popular" role="tabpanel">
                        <!-- Slide2 -->
                        <div class="wrap-slick2">
                            <div class="slick2">
                                @foreach ($popular_courses as $item)
                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="{{ asset('storage/uploads/' . $item->course_image) }}"
                                                    alt="IMG-PRODUCT">

                                                {{-- <a href="{{ route('courses.show', [$item->slug]) }}"
                                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                    Quick View
                                                </a> --}}
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.html"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        {{ $item->title }}
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        33 Reviews
                                                    </span>
                                                </div>

                                                <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#"
                                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="{{ asset('storage/icons/icon-heart-01.png') }}"
                                                            alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="{{ asset('storage/icons/icon-heart-02.png') }}"
                                                            alt="ICON">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
