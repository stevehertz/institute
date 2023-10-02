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
        style="background-image: url('{{ asset('storage/images/bg-01.jpg') }}');">
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
                Shoping Cart
            </span>
        </div>
    </div>

    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                </tr>

                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{ asset('storage/images/item-cart-04.jpg')}}" alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">Fresh Strawberries</td>
                                    <td class="column-3">$ 36.00</td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                name="num-product1" value="1">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-5">$ 36.00</td>
                                </tr>

                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{ asset('storage/images/item-cart-05.jpg')}}" alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">Lightweight Jacket</td>
                                    <td class="column-3">$ 16.00</td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                name="num-product2" value="1">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-5">$ 16.00</td>
                                </tr>
                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                    name="coupon" placeholder="Coupon Code">

                                <div
                                    class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div>

                            <div
                                class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Update Cart
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Subtotal:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    $79.65
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    Shipping:
                                </span>
                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                <p class="stext-111 cl6 p-t-2">
                                    There are no shipping methods available. Please double check your address, or contact us
                                    if you need any help.
                                </p>

                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Calculate Shipping
                                    </span>

                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="time">
                                            <option>Select a country...</option>
                                            <option>USA</option>
                                            <option>UK</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state"
                                            placeholder="State /  country">
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode"
                                            placeholder="Postcode / Zip">
                                    </div>

                                    <div class="flex-w">
                                        <div
                                            class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                            Update Totals
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    $79.65
                                </span>
                            </div>
                        </div>

                        <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>



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
