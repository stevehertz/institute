@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', $course->meta_title ? $course->meta_title : app_name())
@section('meta_description', $course->meta_description)
@section('meta_keywords', $course->meta_keywords)

@push('after-styles')
    <style>
        .leanth-course.go {
            right: 0;
        }

        .video-container iframe {
            max-width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css" />
@endpush

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('storage/images/bg-01.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            {{ $course->title }}
        </h2>
    </section>


    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="#" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="#" class="stext-109 cl8 hov-cl1 trans-04">
                Men
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $course->title }}
            </span>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                @if ($course->course_image != '')
                                    <div class="item-slick3"
                                        data-thumb="{{ asset('storage/uploads/' . $course->course_image) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('storage/uploads/' . $course->course_image) }}"
                                                alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ asset('storage/uploads/' . $course->course_image) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                {{-- <div class="item-slick3" data-thumb="{{ asset('storage/images/product-detail-02.jpg') }}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{ asset('storage/images/product-detail-02.jpg') }}" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="{{ asset('storage/images/product-detail-02.jpg') }}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="item-slick3" data-thumb="{{ asset('storage/images/product-detail-03.jpg') }}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{ asset('storage/images/product-detail-03.jpg') }}" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="{{ asset('storage/images/product-detail-03.jpg') }}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $course->title }}
                        </h4>

                        <span class="mtext-106 cl2">
                            {{ $appCurrency['symbol'] . ' ' . $course->price }}
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {!! $course->description !!}
                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Size
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="time">
                                            <option>Choose an option</option>
                                            <option>Size S</option>
                                            <option>Size M</option>
                                            <option>Size L</option>
                                            <option>Size XL</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Color
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="time">
                                            <option>Choose an option</option>
                                            <option>Red</option>
                                            <option>Blue</option>
                                            <option>White</option>
                                            <option>Grey</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number"
                                            name="num-product" value="1">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                    @if (!$purchased_course)
                                        @if (auth()->check() &&
                                                auth()->user()->hasRole('student') &&
                                                Cart::session(auth()->user()->id)->get($course->id))
                                            <button
                                                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                @lang('labels.frontend.course.added_to_cart')
                                            </button>
                                        @elseif(!auth()->check())
                                            @if ($course->free == 1)
                                                <a href="javascript:void()" id="openLoginModal"
                                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                    @lang('labels.frontend.course.get_now')
                                                </a>
                                            @else
                                                <a href="javascript:void()" id="openLoginModal" data-target="#myModal"
                                                    style="margin-bottom:10px;"
                                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                    @lang('labels.frontend.course.buy_now')
                                                </a>

                                                <a href="javascript:void()" id="openLoginModal" style="margin-bottom:10px;"
                                                    data-target="#myModal"
                                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                    @lang('labels.frontend.course.add_to_cart')
                                                </a>

                                                <a href="javascript:void()" id="openLoginModal" data-target="#myModal"
                                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                    @lang('labels.frontend.course.subscribe')
                                                </a>
                                            @endif
                                        @elseif(auth()->check() &&
                                                auth()->user()->hasRole('student'))
                                            @if ($course->free == 1)
                                                <form action="{{ route('cart.getnow') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}" />
                                                    <input type="hidden" name="amount" id="amount11"
                                                        value="{{ $course->free == 1 ? 0 : $course->price }}" />
                                                    <input type="hidden" name="cartCurrency" id="cartCurrency11"
                                                        value="{{ $appCurrency['symbol'] }}">
                                                    <button
                                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                        @lang('labels.frontend.course.get_now')
                                                    </button>
                                                </form>
                                            @else
                                                @if ($anyPendingOrders == true)
                                                    <p>@lang('labels.frontend.course.course_pending_purchase') </p>

                                                    <p>
                                                        <a class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                                                            href="{{ url('user/dashboard') }}">@lang('labels.frontend.course.go_to_dashboard')
                                                            <i class="fas fa-caret-right"></i></a>
                                                    </p>
                                                @else
                                                    <form action="{{ route('cart.checkout') }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" name="course_id"
                                                            value="{{ $course->id }}" />
                                                        <input type="hidden" name="amount" id="amount12"
                                                            value="{{ $course->free == 1 ? 0 : $course->price }}" />
                                                        <input type="hidden" name="cartCurrency" id="cartCurrency12"
                                                            value="{{ $appCurrency['symbol'] }}">

                                                        <button
                                                            class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                            href="#">@lang('labels.frontend.course.buy_now') <i
                                                                class="fas fa-caret-right"></i></button>
                                                    </form>
                                                    <form action="{{ route('cart.addToCart') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="course_id"
                                                            value="{{ $course->id }}" />
                                                        <input type="hidden" name="amount" id="amount13" />
                                                        <input type="hidden" name="cartCurrency" id="cartCurrency13"
                                                            value="{{ $appCurrency['symbol'] }}">

                                                        <button type="submit"
                                                            class="genius-btn btn-block my-2 bg-dark text-center text-white text-uppercase">
                                                            @lang('labels.frontend.course.add_to_cart') <i class="fa fa-shopping-bag"></i></button>
                                                    </form>
                                                    @if (auth()->user()->subscription('default'))
                                                        <form action="{{ route('subscription.course_subscribe') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course->id }}" />
                                                            <input type="hidden" name="amount" id="amount14"
                                                                value="{{ $course->free == 1 ? 0 : $course->price }}" />
                                                            <input type="hidden" name="cartCurrency" id="cartCurrency14"
                                                                value="{{ $appCurrency['symbol'] }}">

                                                            <button type="submit"
                                                                class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font">
                                                                @lang('labels.frontend.course.subscribe')</button>
                                                        </form>
                                                    @else
                                                        <a class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                            href="{{ route('subscription.plans') }}">@lang('labels.frontend.course.subscribe')</a>
                                                    @endif

                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if ($enrolmentStatus == 0)
                                        @else
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!--  -->
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                    data-tooltip="Add to Wishlist">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description"
                                role="tab">Description</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional
                                information</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {!! $course->description !!}
                                </p>
                                @if ($course->mediaVideo && $course->mediavideo->count() > 0)
                                    <div class="course-single-text">
                                        <p class="stext-102 cl6">
                                            @if ($course->mediavideo != '')
                                                <div class="course-details-content mt-3">
                                                    <div class="video-container mb-5"
                                                        data-id="{{ $course->mediavideo->id }}">
                                                        @if ($course->mediavideo->type == 'youtube')
                                                            <div id="player" class="js-player"
                                                                data-plyr-provider="youtube"
                                                                data-plyr-embed-id="{{ $course->mediavideo->file_name }}">
                                                            </div>
                                                        @elseif($course->mediavideo->type == 'vimeo')
                                                            <div id="player" class="js-player"
                                                                data-plyr-provider="vimeo"
                                                                data-plyr-embed-id="{{ $course->mediavideo->file_name }}">
                                                            </div>
                                                        @elseif($course->mediavideo->type == 'upload')
                                                            <video poster="" id="player" class="js-player"
                                                                playsinline controls>
                                                                <source src="{{ $course->mediavideo->url }}"
                                                                    type="video/mp4" />
                                                            </video>
                                                        @elseif($course->mediavideo->type == 'embed')
                                                            {!! $course->mediavideo->url !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Weight
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                0.79 kg
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Dimensions
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                110 x 33 x 100 cm
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Materials
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                60% cotton
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Color
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                Black, Blue, Grey, Green, Red, White
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Size
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                XL, L, M, S
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        <div class="flex-w flex-t p-b-68">
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                <img src="images/avatar-01.jpg" alt="AVATAR">
                                            </div>

                                            <div class="size-207">
                                                <div class="flex-w flex-sb-m p-b-17">
                                                    <span class="mtext-107 cl2 p-r-20">
                                                        Ariana Grande
                                                    </span>

                                                    <span class="fs-18 cl11">
                                                        <i class="zmdi zmdi-star"></i>
                                                        <i class="zmdi zmdi-star"></i>
                                                        <i class="zmdi zmdi-star"></i>
                                                        <i class="zmdi zmdi-star"></i>
                                                        <i class="zmdi zmdi-star-half"></i>
                                                    </span>
                                                </div>

                                                <p class="stext-102 cl6">
                                                    Quod autem in homine praestantissimum atque optimum est, id deseruit.
                                                    Apud ceteros autem philosophos
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Add review -->
                                        <form class="w-full">
                                            <h5 class="mtext-108 cl2 p-b-7">
                                                Add a review
                                            </h5>

                                            <p class="stext-102 cl6">
                                                Your email address will not be published. Required fields are marked *
                                            </p>

                                            <div class="flex-w flex-m p-t-50 p-b-23">
                                                <span class="stext-102 cl3 m-r-16">
                                                    Your Rating
                                                </span>

                                                <span class="wrap-rating fs-18 cl11 pointer">
                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    <input class="dis-none" type="number" name="rating">
                                                </span>
                                            </div>

                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Your review</label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                                </div>

                                                <div class="col-sm-6 p-b-5">
                                                    <label class="stext-102 cl3" for="name">Name</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name"
                                                        type="text" name="name">
                                                </div>

                                                <div class="col-sm-6 p-b-5">
                                                    <label class="stext-102 cl3" for="email">Email</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                                        type="text" name="email">
                                                </div>
                                            </div>

                                            <button
                                                class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">
                SKU: JAK-01
            </span>

            <span class="stext-107 cl6 p-lr-25">
                Categories: Jacket, Men
            </span>
        </div>
    </section>






@endsection

@push('after-scripts')
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>

    <script>
        const player = new Plyr('#player');

        $(document).on('change', 'input[name="stars"]', function() {
            $('#rating').val($(this).val());
        })
        @if (isset($review))
            var rating = "{{ $review->rating }}";
            $('input[value="' + rating + '"]').prop("checked", true);
            $('#rating').val(rating);
        @endif
    </script>

    <script type="text/javascript">
        var
            selector = document.getElementById("currencySelector");
        var
            currencyElements = document.getElementsByClassName("currency");
        var
            usdChangeRate = {
                KES: {!! $course->KES_cost !!},
                AUD: {!! $course->AUD_cost !!},
                EUR: {!! $course->EUR_cost !!},
                GBP: {!! $course->GBP_cost !!},
                USD: {!! $course->USD_cost !!},
            };

        selector.onchange = function() {
            var
                toCurrency = selector.value.toUpperCase();

            for (var i = 0, l = currencyElements.length; i < l; ++i) {
                var
                    el = currencyElements[i];
                var
                    fromCurrency = el.getAttribute("data-currencyName").toUpperCase();

                if (fromCurrency in usdChangeRate) {
                    var
                        // currency change to usd
                        fromCurrencyToUsdAmount = usdChangeRate[fromCurrency];
                    //console.log(parseInt(el.innerHTML,10) + fromCurrency + "=" + fromCurrencyToUsdAmount + "USD");

                    // change to currency unit selected
                    var toCurrenyAmount = usdChangeRate[toCurrency];

                    el.innerHTML = "<span>" + toCurrency.toUpperCase() + "</span> : " + toCurrenyAmount;
                    el.setAttribute("data-currencyName", toCurrency);
                    //document.getElementById("amount11").value = toCurrency;
                    // $('#amount11').attr('value', '000000')

                }

            }
            //Append the selected amount value to the forms
            $('#amount11').val(toCurrenyAmount);
            $('#amount12').val(toCurrenyAmount);
            $('#amount13').val(toCurrenyAmount);
            $('#amount14').val(toCurrenyAmount);
            //appends the selected currency to the cart form
            $('#cartCurrency11').val(toCurrency.toUpperCase());
            $('#cartCurrency12').val(toCurrency.toUpperCase());
            $('#cartCurrency13').val(toCurrency.toUpperCase());
            $('#cartCurrency14').val(toCurrency.toUpperCase());

        };
    </script>
@endpush
