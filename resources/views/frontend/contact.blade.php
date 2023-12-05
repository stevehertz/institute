@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', 'Contact | ' . app_name())
@section('meta_description', '')
@section('meta_keywords', '')

@push('after-styles')
    <style>
        .my-alert {
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block;
        }
    </style>
@endpush

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-07.jpg') }}');">
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <h4 class="txt-center mtext-105 cl2">
                Get in touch
            </h4>
            <p class="p-b-30">
                Do you want to buy a CCIB-ICSI course or ICSI certification, learn more about our Training
                courses, private training or enterprise program? Please fill out the form below and a member of
                our team will be in touch as soon as possible.
            </p>
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                    <form>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-28 p-tb-25" type="text"
                                        name="first_name" placeholder="First Name">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-28 p-tb-25" type="text"
                                        name="last_name" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <!--/.row -->

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-28 p-tb-25" type="email" name="email"
                                        placeholder="Your Email Address">
                                </div>
                            </div>
                        </div>
                        <!--/.row -->

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-28 p-tb-25" type="text"
                                        name="organization" placeholder="Organization/Institution Name">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <select name="country" id="country"
                                        class="stext-111 cl2 plh3 size-116 p-lr-28 form-control p-tb-25 select2"
                                        style="width: 100%; padding:1.5rem !important;">
                                        <option disabled="disabled" selected>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option>{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/.row -->

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-28 p-tb-25" type="text" name="title"
                                        placeholder="Job Title">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <select name="country" id="country"
                                        class="stext-111 cl2 plh3 size-116 p-lr-28 form-control p-tb-25 select2"
                                        style="width: 100%; padding:1.5rem !important;">
                                        <option disabled="disabled" selected="selected">
                                            What would you like to know more about?
                                        </option>
                                        <option>Buying CCIB Institute training - individual</option>
                                        <option>Buying CCIB Institute training – group training</option>
                                        <option>Private Training</option>
                                        <option>The CCIB Institute Voucher Program</option>
                                        <option>CCIB Institute Cyber Ranges offering</option>
                                        <option>Security Awareness Training</option>
                                        <option>Buying GIAC Certification</option>
                                        <option>Partnering with CCIB Institute</option>
                                        <option>Cybersecurity Frameworks</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="bor8 m-b-30">
                                    <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="message" placeholder="Message"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row p-b-10">
                            <div class="col-12">
                                <p class="p-b-10">
                                    By providing this information, you agree to the processing of your personal data by
                                    CCIB-ICSI as described in our <a href="#">Privacy Policy.</a>
                                </p>

                                <small class="p-b-10">
                                    This site is protected by reCAPTCHA and the Google<a href="#"> Privacy Policy</a> and <a href="#">Terms of Service</a> apply.
                                </small>
                            </div>
                        </div>

                        <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                            Submit
                        </button>
                    </form>
                </div>

                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                    <div class="flex-w w-full p-b-42">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-map-marker"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Address
                            </span>

                            <p class="stext-115 cl6 size-213 p-t-18">
                                Keystone Park, 95 Riverside Drive
                                <br>
                                P.O Box 35509-00100 Westlands, Nairobi
                            </p>
                        </div>
                    </div>

                    {{-- <div class="flex-w w-full p-b-42">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-phone-handset"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Lets Talk
                            </span>

                            <p class="stext-115 cl1 size-213 p-t-18">
                                +1 800 1236879
                            </p>
                        </div>
                    </div> --}}

                    <div class="flex-w w-full">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-envelope"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Sale Support
                            </span>

                            <p class="stext-115 cl1 size-213 p-t-18">
                                info@ccib-icsi.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('after-scripts')
    @if (config('access.captcha.registration'))
        {{ no_captcha()->script() }}
    @endif
@endpush
