@extends('frontend.layouts.app' . config('theme_layout'))
@section('title', trans('labels.frontend.cart.payment_status') . ' | ' . app_name())
@push('after-styles')
    <style>
        input[type="radio"] {
            display: inline-block !important;
        }

        .course-rate li {
            color: #ffc926 !important;
        }

        #applyCoupon {
            box-shadow: none !important;
            color: #fff !important;
            font-weight: bold;
        }

        #coupon.warning {
            border: 1px solid red;
        }

        .purchase-list .in-total {
            font-size: 18px;
        }

        #coupon-error {
            color: red;
        }

        .in-total:not(:first-child):not(:last-child) {
            font-size: 15px;
        }
    </style>

    <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
@endpush
@section('content')


    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('{{ asset('storage/bg/bg-06.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            @lang('labels.frontend.cart.checkout')
        </h2>
    </section>


    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ url('/') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                @lang('labels.frontend.cart.checkout')
            </span>
        </div>
    </div>

    <!-- Shoping Cart -->
    <section class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        @if (session()->has('danger'))
                            <div class="alert alert-dismissable alert-danger fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {!! session('danger') !!}
                            </div>
                        @endif
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <thead>
                                    <tr class="table_head">
                                        <th class="column-1">@lang('labels.frontend.cart.product_name')</th>
                                        <th class="column-2"></th>
                                        <th class="column-3">@lang('labels.frontend.cart.price')</th>
                                        <th class="column-4">@lang('labels.frontend.cart.product_type')</th>
                                        <th class="column-5">@lang('labels.frontend.cart.starts')</th>
                                        <th style="margin-right: 10px; padding-right:10px;" class="column-6">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($courses) > 0)
                                        @foreach ($courses as $course)
                                            <tr class="table_row">
                                                <td class="column-1">
                                                    <div class="how-itemcart1">
                                                        @if ($course->course_image != '')
                                                            <img src="{{ asset('storage/uploads/' . $course->course_image) }}"
                                                                alt="{{ $course->title }}">
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="column-2">
                                                    <a href="{{ route('courses.show', [$course->slug]) }}">
                                                        {{ $course->title }}
                                                    </a>
                                                </td>
                                                <td class="column-3">
                                                    @if ($course->free == 1)
                                                        <span>{{ trans('labels.backend.bundles.fields.free') }}</span>
                                                    @else
                                                        <span>
                                                            {{ Session::get('cartCurrency') ? Session::get('cartCurrency') : $cartCurrency['short_code'] . ' ' }}.{{ $course->price }}</span>
                                                    @endif
                                                </td>
                                                <td class="column-4">
                                                    <div class="course-type-list">
                                                        <span>{{ class_basename($course) }}</span>
                                                    </div>
                                                </td>
                                                <td class="column-5">
                                                    {{ $course->start_date != '' ? $course->start_date : 'N/A' }}
                                                </td>

                                                <td class="column-6">
                                                    <a class="text-danger text-center"
                                                        href="{{ route('cart.remove', ['course' => $course]) }}"><i
                                                            class="fa fa-times"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                @lang('labels.frontend.cart.empty_cart')
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if (count($courses) > 0)
                            <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                <div class="flex-w flex-m m-r-20 m-tb-5">
                                    <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                        name="coupon" id="coupon" pattern="[^\s]+" placeholder="Enter Coupon">

                                    <div id="applyCoupon"
                                        class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                        @lang('labels.frontend.cart.apply')
                                    </div>
                                </div>

                                {{-- <div
                                    class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                    Update Cart
                                </div> --}}
                            </div>
                        @endif

                        @if (count($courses) > 0)
                            @if (config('services.stripe.active') == 0 &&
                                    config('paypal.active') == 0 &&
                                    config('payment_offline_active') == 0 &&
                                    config('services.instamojo.active') == 0 &&
                                    config('services.razorpay.active') == 0 &&
                                    config('services.cashfree.active') == 0 &&
                                    config('services.payu.active') == 0 &&
                                    config('flutter.active') == 0 &&
                                    config('pesapal.active') == 0)
                                <div class="order-payment">
                                    <div class="section-title-2 headline text-left">
                                        <h2>@lang('labels.frontend.cart.no_payment_method')</h2>
                                    </div>
                                </div>
                            @else
                                <div class="order-payment">
                                    <div class="section-title-2  headline text-left">
                                        <h2>@lang('labels.frontend.cart.order_payment')</h2>
                                    </div>
                                    {{-- Pesapal option here --}}
                                    @if (config('pesapal.active') == 1)
                                        <div class="payment-method w-100 mb-0">
                                            <div class="payment-method-header">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="method-header-text">
                                                            <div class="radio">
                                                                <label>
                                                                    <input data-toggle="collapse"
                                                                        href="#collapsePaymentPesapal" type="radio"
                                                                        name="paymentMethod" value="2">
                                                                </label>
                                                                <label>Pay with <span style="color: orangered"> PESAPAL
                                                                    </span>
                                                                    <img src="{{ asset('assets/img/banner/pesapal.jpg') }}"
                                                                        width="105px" alt=""></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="check-out-form collapse disabled" id="collapsePaymentPesapal"
                                                data-parent="#accordion">
                                                <form class="w3-container w3-display-middle w3-card-4 " method="POST"
                                                    action="{{ route('make.payment') }}">
                                                    {{ csrf_field() }}
                                                    <p> @lang('labels.frontend.cart.pay_securely_pesapal')</p>
                                                    <div class="form-control">
                                                        <p>Amount:</p>
                                                        <input class="form-control col-md-3" name="amount" required
                                                            value=" {{ Session::get('cartCurrency') ? Session::get('cartCurrency') : $cartCurrency['short_code'] . ' ' }}. {{ number_format(Cart::session(auth()->user()->id)->getTotal(), 2) }}"
                                                            readonly>
                                                    </div>

                                                    <button type="submit"
                                                        class="text-white genius-btn mt25 gradient-bg text-center text-uppercase  bold-font">
                                                        @lang('labels.frontend.cart.pay_now') <i class="fas fa-caret-right"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif

                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            @lang('labels.frontend.cart.order_detail')
                        </h4>


                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    @lang('labels.frontend.cart.price') <small class="text-muted">
                                        ({{ Cart::getContent()->count() }}{{ Cart::getContent()->count() > 1 ? ' ' . trans('labels.frontend.cart.items') : ' ' . trans('labels.frontend.cart.item') }}
                                        )
                                    </small>
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    @if (isset($total))
                                        {{ Session::get('cartCurrency') ? Session::get('cartCurrency') : $cartCurrency['short_code'] . ' ' }}{{ $total }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if (Cart::getConditionsByType('coupon') != null)
                            @foreach (Cart::getConditionsByType('coupon') as $condition)
                                <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                    <div class="size-208 w-full-ssm">
                                        <span class="stext-110 cl2">
                                            {{ $condition->getValue() . ' ' . $condition->getName() }}
                                        </span>
                                    </div>
                                    <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                        {{ Session::get('cartCurrency') ? Session::get('cartCurrency') : $cartCurrency['short_code'] . ' ' }}.{{ number_format($condition->getCalculatedValue($total), 2) }}
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    @lang('labels.frontend.cart.total_payable')
                                </span>
                            </div>

                            <div class="size-209">
                                @if (count($courses) > 0)
                                    <span class="mtext-110 cl2">
                                        <span class="font-weight-bold">
                                            @if (isset($total))
                                                {{ Session::get('cartCurrency') ? Session::get('cartCurrency') : $cartCurrency['short_code'] . ' ' }}{{ $total }}
                                            @endif
                                        </span>
                                    </span>
                                @else
                                    <span class="mtext-110 cl2">
                                        {{ Session::get('cartCurrency') ? Session::get('cartCurrency') : $cartCurrency['short_code'] . ' ' }}.{{ number_format(Cart::session(auth()->user()->id)->getTotal(), 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('after-scripts')
    @if (config('services.stripe.active') == 1)
        <script type="text/javascript" src="{{ asset('js/stripe-form.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {

            $(document).on('click', 'input[type="radio"]:checked', function() {
                $('#accordion .check-out-form').addClass('disabled')
                $(this).closest('.payment-method').find('.check-out-form').removeClass('disabled')
            })

            $(document).on('click', '#applyCoupon', function() {
                var coupon = $('#coupon');
                if (!coupon.val() || (coupon.val() == "")) {
                    coupon.addClass('warning');
                    $('#coupon-error').html(
                        "<small>{{ trans('labels.frontend.cart.empty_input') }}</small>").removeClass(
                        'd-none')
                    setTimeout(function() {
                        $('#coupon-error').empty().addClass('d-none')
                        coupon.removeClass('warning');

                    }, 5000);
                } else {
                    $('#coupon-error').empty().addClass('d-none')
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('cart.applyCoupon') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            coupon: coupon.val()
                        }
                    }).done(function(response) {
                        if (response.status === 'fail') {
                            coupon.addClass('warning');
                            $('#coupon-error').removeClass('d-none').html("<small>" + response
                                .message + "</small>");
                            setTimeout(function() {
                                $('#coupon-error').empty().addClass('d-none');
                                coupon.removeClass('warning');

                            }, 5000);
                        } else {
                            $('.purchase-list').empty().html(response.html)
                            $('#applyCoupon').removeClass('btn-dark').addClass('btn-success')
                            $('#coupon-error').empty().addClass('d-none');
                            coupon.removeClass('warning');
                        }
                    });

                }
            });


            $(document).on('click', '#removeCoupon', function() {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('cart.removeCoupon') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                }).done(function(response) {
                    $('.purchase-list').empty().html(response.html)
                });
            })

        })
    </script>

    @if (session()->get('razorpay'))
        @php
            $cart = session()->get('razorpay');
        @endphp

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        <script>
            var options = {
                "key": "{{ config('services.razrorpay.key') }}", // Enter the Key ID generated from the Dashboard
                "amount": "{{ $cart['amount'] }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "{{ $cart['currency'] }}",
                "name": "{{ config('app.name') }}",
                "description": "{{ $cart['description'] }}",
                "image": "{{ asset('storage/logos/' . config('logo_b_image')) }}",
                "order_id": "{{ $cart['order_id'] }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function(response) {
                    $('#razorpay_payment_id').val(response.razorpay_payment_id);
                    $('#razorpay_order_id').val(response.razorpay_order_id);
                    $('#razorpay_signature').val(response.razorpay_signature)
                    $("#razorpay-callback-form").submit();
                },
                "prefill": {
                    "name": "{{ $cart['name'] }}",
                    "email": "{{ $cart['email'] }}",
                }
            };
            var rzp1 = new Razorpay(options);
            document.getElementById('razor-pay-btn').onclick = function(e) {
                rzp1.open();
                e.preventDefault();
            }
            window.onload = function() {
                document.getElementById('razor-pay-btn').click();
            }
        </script>
    @endif
@endpush
