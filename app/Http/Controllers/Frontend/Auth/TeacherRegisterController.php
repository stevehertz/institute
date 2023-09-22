<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Models\TeacherProfile;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\TeacherRegisterRequest;

class TeacherRegisterController extends Controller
{
    /**
     * Show the application teacher registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTeacherRegistrationForm()
    {
        return view('frontend.auth.registerTeacher');
    }

    /**
     * Register new teacher
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     **/
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191', Rule::unique('users')],
            'password'            => ['required', 'string', 'min:6', 'confirmed'],
            'gender'              => ['required', 'in:male,female,other'],
            'facebook_link'       => ['nullable', 'url'],
            'twitter_link'        => ['nullable', 'url'],
            'linkedin_link'       => ['nullable', 'url'],
        ]);
        
        $user = User::create($request->all());
        $user->confirmed = 1;
        if ($request->has('image')) {
            $user->avatar_type = 'storage';
            $user->avatar_location = $request->image->store('/avatars', 'public');
        }
        $user->active = 0;
        $user->save();
        $user->assignRole('teacher');
        // $payment_details = [
        //     'bank_name' => request()->bank_name,
        //     'ifsc_code' => request()->ifsc_code,
        //     'account_number' => request()->account_number,
        //     'account_name' => request()->account_name,
        //     'paypal_email' => request()->paypal_email,
        // ];
        $data = [
            'user_id' => $user->id,
            // 'facebook_link' => request()->facebook_link,
            // 'twitter_link' => request()->twitter_link,
            // 'linkedin_link' => request()->linkedin_link,
            // 'payment_method' => request()->payment_method,
            // 'payment_details' => json_encode($payment_details),
            'description'       => request()->description,
        ];
        TeacherProfile::create($data);
        return redirect()->route('frontend.index')->withFlashSuccess(trans('labels.frontend.modal.registration_message'))->with(['openModel' => true]);
    }

}
