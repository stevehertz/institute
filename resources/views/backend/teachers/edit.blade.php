@extends('backend.layouts.app')
@section('title', __('labels.backend.teachers.title') . ' | ' . app_name())

@section('content')
    {{ html()->modelForm($teacher, 'PATCH', route('admin.teachers.update', $teacher->id))->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">
                @lang('labels.backend.teachers.edit')
            </h3>
            <div class="float-right">
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-success">
                    @lang('labels.backend.teachers.view')
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.first_name'))->class('col-md-2 form-control-label')->for('first_name') }}

                        <div class="col-md-10">
                            {{ html()->text('first_name')->class('form-control')->placeholder(__('labels.backend.teachers.fields.first_name'))->attribute('maxlength', 191)->required()->autofocus() }}
                        </div>
                        <!--col-->
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.last_name'))->class('col-md-2 form-control-label')->for('last_name') }}

                        <div class="col-md-10">
                            {{ html()->text('last_name')->class('form-control')->placeholder(__('labels.backend.teachers.fields.last_name'))->attribute('maxlength', 191)->required() }}
                        </div>
                        <!--col-->
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.email'))->class('col-md-2 form-control-label')->for('email') }}

                        <div class="col-md-10">
                            {{ html()->email('email')->class('form-control')->placeholder(__('labels.backend.teachers.fields.email'))->attributes(['maxlength' => 191, 'readonly' => true])->required() }}
                        </div>
                        <!--col-->
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.image'))->class('col-md-2 form-control-label')->for('image') }}

                        <div class="col-md-10">
                            {!! Form::file('image', ['class' => 'form-control d-inline-block', 'placeholder' => '']) !!}
                        </div>
                        <!--col-->
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.general_settings.user_registration_settings.fields.gender'))->class('col-md-2 form-control-label')->for('gender') }}
                        <div class="col-md-10">
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="male"
                                    {{ $teacher->gender == 'male' ? 'checked' : '' }}>
                                {{ __('validation.attributes.frontend.male') }}
                            </label>
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="female"
                                    {{ $teacher->gender == 'female' ? 'checked' : '' }}>
                                {{ __('validation.attributes.frontend.female') }}
                            </label>
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="other"
                                    {{ $teacher->gender == 'other' ? 'checked' : '' }}>
                                {{ __('validation.attributes.frontend.other') }}
                            </label>
                        </div>
                    </div>
                    <!--form-group-->

                    @php
                        $teacherProfile = $teacher->teacherProfile ?? '';
                        $payment_details = $teacher->teacherProfile ? json_decode($teacher->teacherProfile->payment_details) : new stdClass();
                    @endphp

                    @isset($teacherProfile->facebook_link)
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.facebook_link'))->class('col-md-2 form-control-label')->for('facebook_link') }}

                            <div class="col-md-10">
                                {{ html()->text('facebook_link')->class('form-control')->value($teacherProfile->facebook_link)->placeholder(__('labels.teacher.facebook_link')) }}
                            </div>
                            <!--col-->
                        </div>
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.facebook_link'))->class('col-md-2 form-control-label')->for('facebook_link') }}

                            <div class="col-md-10">
                                {{ html()->text('facebook_link')->class('form-control')->placeholder(__('labels.teacher.facebook_link')) }}
                            </div>
                            <!--col-->
                        </div>
                    @endisset

                    @isset($teacherProfile->twitter_link)
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.twitter_link'))->class('col-md-2 form-control-label')->for('twitter_link') }}

                            <div class="col-md-10">
                                {{ html()->text('twitter_link')->class('form-control')->value($teacherProfile->twitter_link)->placeholder(__('labels.teacher.twitter_link')) }}

                            </div>
                            <!--col-->
                        </div>
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.twitter_link'))->class('col-md-2 form-control-label')->for('twitter_link') }}

                            <div class="col-md-10">
                                {{ html()->text('twitter_link')->class('form-control')->placeholder(__('labels.teacher.twitter_link')) }}

                            </div>
                            <!--col-->
                        </div>
                    @endisset

                    @isset($teacherProfile->linkedin_link)
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.linkedin_link'))->class('col-md-2 form-control-label')->for('linkedin_link') }}

                            <div class="col-md-10">
                                {{ html()->text('linkedin_link')->class('form-control')->value($teacherProfile->linkedin_link)->placeholder(__('labels.teacher.linkedin_link')) }}
                            </div>
                            <!--col-->
                        </div>
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.linkedin_link'))->class('col-md-2 form-control-label')->for('linkedin_link') }}

                            <div class="col-md-10">
                                {{ html()->text('linkedin_link')->class('form-control')->placeholder(__('labels.teacher.linkedin_link')) }}
                            </div>
                            <!--col-->
                        </div>
                    @endisset

                    @isset($teacherProfile->payment_method)
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.payment_details'))->class('col-md-2 form-control-label')->for('payment_details') }}
                            <div class="col-md-10">
                                <select class="form-control" name="payment_method" id="payment_method" required>
                                    <option value="bank" {{ $teacherProfile->payment_method == 'bank' ? 'selected' : '' }}>
                                        {{ trans('labels.teacher.bank') }}</option>
                                    <option value="paypal" {{ $teacherProfile->payment_method == 'paypal' ? 'selected' : '' }}>
                                        {{ trans('labels.teacher.paypal') }}</option>
                                </select>
                            </div>
                        </div>

                        @php
                            $bankName = $payment_details ? $payment_details->bank_name : '';
                            $ifsc_code = $payment_details ? $payment_details->ifsc_code : '';
                            $accountNumber = $payment_details ? $payment_details->account_number : '';
                            $accountName = $payment_details ? $payment_details->account_name : '';
                            $paypal_email = $payment_details ? $payment_details->paypal_email : '';
                        @endphp

                        <div class="bank_details"
                            style="display:{{ $teacher->teacherProfile->payment_method == 'bank' ? '' : 'none' }}">
                            <div class="form-group row">

                                {{ html()->label(__('labels.teacher.bank_details.name'))->class('col-md-2 form-control-label')->for('bank_name') }}
                                <div class="col-md-10">
                                    {{ html()->text('bank_name')->class('form-control')->value($bankName)->placeholder(__('labels.teacher.bank_details.name')) }}
                                </div>
                                <!--col-->

                            </div>

                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.bank_code'))->class('col-md-2 form-control-label')->for('ifsc_code') }}
                                <div class="col-md-10">
                                    {{ html()->text('ifsc_code')->class('form-control')->value($ifsc_code)->placeholder(__('labels.teacher.bank_details.bank_code')) }}
                                </div>
                                <!--col-->
                            </div>

                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.account'))->class('col-md-2 form-control-label')->for('account_number') }}
                                <div class="col-md-10">
                                    {{ html()->text('account_number')->class('form-control')->value($accountNumber)->placeholder(__('labels.teacher.bank_details.account')) }}
                                </div>
                                <!--col-->
                            </div>

                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.holder_name'))->class('col-md-2 form-control-label')->for('account_name') }}
                                <div class="col-md-10">
                                    {{ html()->text('account_name')->class('form-control')->value($accountName)->placeholder(__('labels.teacher.bank_details.holder_name')) }}
                                </div>
                                <!--col-->
                            </div>

                        </div>


                        <div class="paypal_details"
                            style="display:{{ $teacher->teacherProfile->payment_method == 'paypal' ? '' : 'none' }}">
                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.paypal_email'))->class('col-md-2 form-control-label')->for('paypal_email') }}
                                <div class="col-md-10">
                                    {{ html()->text('paypal_email')->class('form-control')->value($paypal_email)->placeholder(__('labels.teacher.paypal_email')) }}
                                </div>
                                <!--col-->
                            </div>
                        </div>
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.payment_details'))->class('col-md-2 form-control-label')->for('payment_details') }}
                            <div class="col-md-10">
                                <select class="form-control" name="payment_method" id="payment_method" required>
                                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>
                                        {{ trans('labels.teacher.bank') }}</option>
                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>
                                        {{ trans('labels.teacher.paypal') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="bank_details">
                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.name'))->class('col-md-2 form-control-label')->for('bank_name') }}
                                <div class="col-md-10">
                                    {{ html()->text('bank_name')->class('form-control')->placeholder(__('labels.teacher.bank_details.name')) }}
                                </div><!--col-->
                            </div>

                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.bank_code'))->class('col-md-2 form-control-label')->for('ifsc_code') }}
                                <div class="col-md-10">
                                    {{ html()->text('ifsc_code')->class('form-control')->placeholder(__('labels.teacher.bank_details.bank_code')) }}
                                </div><!--col-->
                            </div>

                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.account'))->class('col-md-2 form-control-label')->for('account_number') }}
                                <div class="col-md-10">
                                    {{ html()->text('account_number')->class('form-control')->placeholder(__('labels.teacher.bank_details.account')) }}
                                </div><!--col-->
                            </div>

                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.bank_details.holder_name'))->class('col-md-2 form-control-label')->for('account_name') }}
                                <div class="col-md-10">
                                    {{ html()->text('account_name')->class('form-control')->placeholder(__('labels.teacher.bank_details.holder_name')) }}
                                </div><!--col-->
                            </div>
                        </div>

                        <div class="paypal_details">
                            <div class="form-group row">
                                {{ html()->label(__('labels.teacher.paypal_email'))->class('col-md-2 form-control-label')->for('paypal_email') }}
                                <div class="col-md-10">
                                    {{ html()->text('paypal_email')->class('form-control')->placeholder(__('labels.teacher.paypal_email')) }}
                                </div><!--col-->
                            </div>
                        </div>
                    @endisset

                    @isset($teacherProfile->specialities)
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.specialities'))->class('col-md-2 form-control-label')->for('specialities') }}

                            <div class="col-md-10">
                                {{ html()->text('specialities')->class('form-control')->value($teacherProfile->specialities)->placeholder(__('labels.teacher.specialities')) }}
                            </div>
                            <!--col-->
                        </div>
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.specialities'))->class('col-md-2 form-control-label')->for('specialities') }}

                            <div class="col-md-10">
                                {{ html()->text('specialities')->class('form-control')->placeholder(__('labels.teacher.specialities')) }}
                            </div>
                            <!--col-->
                        </div>
                    @endisset

                    @isset($teacherProfile->description)
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.description'))->class('col-md-2 form-control-label')->for('description') }}

                            <div class="col-md-10">
                                {{ html()->textarea('description')->class('form-control')->value($teacherProfile->description)->placeholder(__('labels.teacher.description')) }}
                            </div>
                            <!--col-->
                        </div>
                    @else
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.description'))->class('col-md-2 form-control-label')->for('description') }}

                            <div class="col-md-10">
                                {{ html()->textarea('description')->class('form-control')->placeholder(__('labels.teacher.description')) }}
                            </div>
                            <!--col-->
                        </div>
                    @endisset

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.status'))->class('col-md-2 form-control-label')->for('active') }}
                        <div class="col-md-10">
                            {{ html()->label(
                                    html()->checkbox('')->name('active')->checked($teacher->active == 1 ? true : false)->class('switch-input')->value($teacher->active == 1 ? 1 : 0) .
                                        '<span class="switch-label"></span><span class="switch-handle"></span>',
                                )->class('switch switch-lg switch-3d switch-primary') }}
                        </div>

                    </div>


                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                    </div>
                    <!--col-->
                </div>
            </div>
        </div>

    </div>
    {{ html()->closeModelForm() }}
@endsection
@push('after-scripts')
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
