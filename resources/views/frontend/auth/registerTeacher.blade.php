@extends('frontend' . (session()->get('display_type') == 'rtl' ? '-rtl' : '') . '.layouts.app' . config('theme_layout'))

@section('title', app_name() . ' | ' . __('labels.teacher.teacher_register_box_title'))

@section('content')

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{ asset('storage/bg/bg-01.jpg') }}');">
        <h2 class="ltext-105 cl0 txt-center">
            @if (isset($category))
                {{ $category->name }}
            @elseif(isset($tag))
                {{ $tag->name }}
            @endif
            {{-- <span>@lang('labels.frontend.blog.title')</span> --}}
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
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

                            {{ html()->form('POST', route('frontend.auth.teacher.register.post'))->acceptsFiles()->class('form-horizontal')->open() }}
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="col-12  mt-3 mb-2 text-center">
                                    <h3>{{ __('validation.attributes.frontend.personal_information') }}</h3>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    {{ html()->hidden('active')->class('form-control')->attribute('maxlength', 191)->required()->value(0) }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.first_name') . '*')->for('first_name') }} 

                                        {{ html()->text('first_name')->class('form-control')->placeholder(__('validation.attributes.frontend.first_name'))->attribute('maxlength', 191)->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.last_name') . '*')->for('last_name') }}

                                        {{ html()->text('last_name')->class('form-control')->placeholder(__('validation.attributes.frontend.last_name'))->attribute('maxlength', 191)->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.email') . '*')->for('email') }}

                                        {{ html()->email('email')->class('form-control')->placeholder(__('validation.attributes.frontend.email'))->attribute('maxlength', 191)->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password') . '*')->for('password') }}

                                        {{ html()->password('password')->class('form-control')->placeholder(__('validation.attributes.frontend.password'))->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.password_confirmation') . '*')->for('password_confirmation') }}

                                        {{ html()->password('password_confirmation')->class('form-control')->placeholder(__('validation.attributes.frontend.password_confirmation'))->required() }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.backend.teachers.fields.image') . '*')->class('form-control-label')->for('image') }}

                                        {!! Form::file('image', ['class' => 'form-control d-inline-block', 'placeholder' => '']) !!}
                                    </div><!--form-group-->
                                </div><!--col-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.backend.general_settings.user_registration_settings.fields.gender') . '*')->for('password_confirmation') }}
                                        <div class="form-control inline-radio">
                                            <label class="radio-inline mr-3 mb-0">
                                                <input type="radio" name="gender" value="male">
                                                {{ __('validation.attributes.frontend.male') }}
                                            </label>
                                            <label class="radio-inline mr-3 mb-0">
                                                <input type="radio" name="gender" value="female">
                                                {{ __('validation.attributes.frontend.female') }}
                                            </label>
                                            <label class="radio-inline mr-3 mb-0">
                                                <input type="radio" name="gender" value="other">
                                                {{ __('validation.attributes.frontend.other') }}
                                            </label>
                                        </div>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('validation.attributes.frontend.specialities') . '*') }}

                                        {{ html()->text('specialities')->class('form-control')->placeholder(__('validation.attributes.frontend.specialities'))->attribute('maxlength', 191)->required() }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {{ html()->label(__('labels.teacher.description')) }}

                                        {{ html()->textarea('description')->class('form-control')->placeholder(__('labels.teacher.description')) }}
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->


                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-0 text-center mt-4 clearfix">
                                        <button class="btn btn-info btn-block mx-auto btn-lg"
                                            type="submit">{{ __('labels.frontend.modal.register_now') }}</button>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                            {{ html()->form()->close() }}


                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/.col-sm-12 -->
            </div>
            <!--/.row -->
        </div>
        <!--/.container -->
    </section>
    <!--/.bg0 -->

@endsection
@push('after-scripts')
    @if (old('payment_method') && old('payment_method') == 'bank')
        <script>
            $('.paypal_details').hide();
            $('.bank_details').show();
        </script>
    @elseif(old('payment_method') && old('payment_method') == 'paypal')
        <script>
            $('.paypal_details').show();
            $('.bank_details').hide();
        </script>
    @else
        <script>
            $('.paypal_details').hide();
        </script>
    @endif
    <script>
        $(document).on('change', '#payment_method', function() {
            if ($(this).val() === 'bank') {
                $('.paypal_details').hide();
                $('.bank_details').show();
            } else {
                $('.paypal_details').show();
                $('.bank_details').hide();
            }
        });
    </script>
@endpush
