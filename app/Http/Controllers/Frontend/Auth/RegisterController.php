<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use App\Helpers\Frontend\Auth\Socialite;
use Illuminate\Support\Facades\Validator;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use App\Mail\Frontend\Auth\AdminRegistered;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ClosureValidationRule;
use App\Repositories\Frontend\Auth\UserRepository;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => (config('access.captcha.registration') ? ['required',new CaptchaRule] : ''),
        ],[
            'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
        ]);

        if ($validator->passes()) {
            // Store your user in database
            event(new Registered($user = $this->create($request->all())));

            Session::flash('success', 'Registration successful! You can now login.');
            // return response(['success' => true]);
            return redirect()->route('frontend.auth.login');

        }

        // return response(['errors' => $validator->errors()]);

        return back()->withErrors([
            'errors' => $validator->errors()
        ]);

       
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->dob = isset($data['dob']) ? $data['dob'] : NULL ;
        $user->phone = isset($data['phone']) ? $data['phone'] : NULL ;
        $user->gender = isset($data['gender']) ? $data['gender'] : NULL;
        $user->address = isset($data['address']) ? $data['address'] : NULL;
        $user->city =  isset($data['city']) ? $data['city'] : NULL;
        $user->pincode = isset($data['pincode']) ? $data['pincode'] : NULL;
        $user->state = isset($data['state']) ? $data['state'] : NULL;
        $user->country = isset($data['country']) ? $data['country'] : NULL;
        $user->save();

        $userForRole = User::find($user->id);
        $userForRole->confirmed = 1;
        $userForRole->save();
        $userForRole->assignRole('student');

        if(config('access.users.registration_mail')) {
            $this->sendAdminMail($user);
        }

        return $user;
    }

    private function sendAdminMail($user)
    {
        $admins = User::role('administrator')->get();

        foreach ($admins as $admin){
            \Mail::to($admin->email)->send(new AdminRegistered($user));
        }
    }



}
