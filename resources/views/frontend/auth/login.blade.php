@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-01.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            {{-- <span>@lang('labels.frontend.blog.title')</span> --}}
            @lang('labels.frontend.auth.login_box_title')
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-8 align-self-center col">
                    <div class="card  border-0">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-inline list-style-none">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <span class="success-response text-success">
                                {{ session()->get('flash_success') }}
                            </span>

                            {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                            
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                        {{ html()->email('email')->class('form-control stext-111 cl2 plh3 size-116 p-r-30')->placeholder(__('validation.attributes.frontend.email'))->attribute('maxlength', 191)->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                        {{ html()->password('password')->class('form-control stext-111 cl2 plh3 size-116 p-r-30')->placeholder(__('validation.attributes.frontend.password'))->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            {{ html()->label(html()->checkbox('remember', true, 1) . ' ' . __('labels.frontend.auth.remember_me'))->for('remember') }}
                                        </div>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group clearfix">
                                        {{ form_submit(__('labels.frontend.auth.login_button'))->class('flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer') }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col">
                                    <div class="form-group text-right">
                                        <a href="{{ route('frontend.auth.password.reset') }}">@lang('labels.frontend.passwords.forgot_password')</a>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                            {{ html()->form()->close() }}

                            <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <p>New customer? <a href="{{ route('frontend.auth.register') }}" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">Create an account</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if ($socialiteLinks)
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center">
                                            {!! $socialiteLinks !!}
                                        </div>
                                    </div><!--col-->
                                </div><!--row-->
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <!--/.row -->
        </div>
        <!--/.container -->
    </section>

@endsection
