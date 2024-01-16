<?php

namespace App\Http\Requests\Frontend\Contact;

use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SendContactRequest.
 */
class SendContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return [
           'first_name' => ['required', 'string', 'max:255'],
           'last_name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'email'],
           'organization' => ['required', 'string'],
           'country' => ['required', 'string'],
           'title' => ['required', 'string'],
           'topic' => ['required', 'string'],
           'message' => ['required'],
           'g-recaptcha-response' => (config('access.captcha.registration') ? ['required',new CaptchaRule()] : ''),
       ];
    }
}
