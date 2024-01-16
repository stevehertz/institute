<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use Illuminate\Support\Facades\Session;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use PragmaRX\Countries\Package\Countries;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if(session()->has('display_type')){
            if(session('display_type') == 'rtl'){
                $path = 'frontend-rtl';
            }else{
                $path = 'frontend';
            }
        }else if(config('app.display_type') == 'rtl'){
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }


    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $countries = new Countries();
        $countryList = $countries->all()->pluck('name.common');
        return view($this->path.'.contact', [
            'countries' => $countryList
        ]);
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {
        
        $data = $request->except("_token");

        $contact = new Contact();

        $contact->first_name = $data['first_name'];
        $contact->last_name = $data['last_name'];
        $contact->email = $data['email'];
        $contact->organization = $data['organization'];
        $contact->country = $data['country'];
        $contact->title = $data['title'];
        $contact->topic = $data['topic'];
        $contact->phone = $data['phone'];
        $contact->message = $data['message'];

        $contact->save();

        Mail::send(new SendContact($request));
        Session::flash('alert','Response received successfully!');
        
        return redirect()->back();
    }
}
