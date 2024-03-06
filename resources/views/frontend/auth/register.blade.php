@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-01.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            {{-- <span>@lang('labels.frontend.blog.title')</span> --}}
            @lang('labels.frontend.auth.register_box_title')
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col col-sm-8 align-self-center">
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

                            <form action="{{ route('frontend.auth.register.post') }}" class="form-horizontal" role="form" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                            {{ html()->text('first_name')->class('form-control')->placeholder(__('validation.attributes.frontend.first_name'))->attribute('maxlength', 191) }}
                                        </div><!--col-->
                                    </div><!--row-->

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                            {{ html()->text('last_name')->class('form-control')->placeholder(__('validation.attributes.frontend.last_name'))->attribute('maxlength', 191) }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                            {{ html()->email('email')->class('form-control')->placeholder(__('validation.attributes.frontend.email'))->attribute('maxlength', 191)->required() }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                            {{ html()->password('password')->class('form-control')->placeholder(__('validation.attributes.frontend.password'))->required() }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                            {{ html()->password('password_confirmation')->class('form-control')->placeholder(__('validation.attributes.frontend.password_confirmation'))->required() }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                                @if (config('access.captcha.registration'))
                                    <div class="row">
                                        <div class="col">
                                            {!! Captcha::display() !!}
                                            {{ html()->hidden('captcha_status', 'true') }}
                                        </div><!--col-->
                                    </div><!--row-->
                                @endif

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-0 clearfix">
                                            {{ form_submit(__('labels.frontend.auth.register_button'))->class(
                                                'flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer',
                                            ) }}
                                        </div><!--form-group-->
                                    </div><!--col-->
                                </div><!--row-->

                            </form>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <p>Already have an account? <a href="{{ route('frontend.auth.login') }}"
                                                class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">Log in here</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--/.card-body -->
                        @if ($socialiteLinks)
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-center">
                                            {!! $socialiteLinks !!}
                                        </div>
                                    </div><!--/ .col -->
                                </div><!-- / .row -->
                            </div>
                        @endif
                    </div>
                    <!--/.card -->
                </div>
                <!--/.col -->
            </div>
        </div>
        <!--/.container -->
    </section>

@endsection

@push('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {

                $(document).on('submit', '#registerForm', function(e) {
                    e.preventDefault();
                    console.log('he')
                    var $this = $(this);

                    $.ajax({
                        type: $this.attr('method'),
                        url: "{{ route('frontend.auth.register.post') }}",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function(data) {
                            $('#first-name-error').empty()
                            $('#last-name-error').empty()
                            $('#email-error').empty()
                            $('#password-error').empty()
                            $('#captcha-error').empty()
                            if (data.errors) {
                                if (data.errors.first_name) {
                                    $('#first-name-error').html(data.errors.first_name[
                                        0]);
                                }
                                if (data.errors.last_name) {
                                    $('#last-name-error').html(data.errors.last_name[
                                        0]);
                                }
                                if (data.errors.email) {
                                    $('#email-error').html(data.errors.email[0]);
                                }
                                if (data.errors.password) {
                                    $('#password-error').html(data.errors.password[0]);
                                }

                                var captcha = "g-recaptcha-response";
                                if (data.errors[captcha]) {
                                    $('#captcha-error').html(data.errors[captcha][0]);
                                }
                            }
                            if (data.success) {
                                $('#registerForm')[0].reset();
                                // $('#register').removeClass('active').addClass('fade')
                                $('.error-response').empty();
                                // $('#login').addClass('active').removeClass('fade')
                                $('.success-response').empty().html(
                                    "@lang('labels.frontend.modal.registration_message')");
                                
                                setTimeout(() => {
                                    window.location.href = '{{ route('frontend.auth.login') }}';
                                }, 1000);
                            }
                        }
                    });
                });

            });

        });
    </script>
@endpush
