@extends('frontend.layouts.app1')
@section('title', trans('labels.frontend.cart.payment_status').' | '.app_name())

@section('content')

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"><span>@lang('labels.frontend.cart.checkout')</span></h2>
                </div>
            </div>
        </div>
    </section>

    <iframe src="https://demo.pesapal.com/api/PostPesapalDirectOrderV4" {{ $iframe }} width="100%" height="300" style="height: 9000px; width:100%;"></iframe>
    <p>Display me anything here please</p>
    @endsection