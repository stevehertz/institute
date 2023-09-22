<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pesapal;
use Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Bundle;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MakePayment extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /*****
         *
         * when you post to make payment make sure you have the amount to charge its is required in the from
         * you can choose to add phone number to user model if you want to access it via user-phone_number
         *  the payment model needs
         *
         */
         //        $this->validate($request, [
         //            'amount' => 'required|numeric|gt:0'
         //        ]);

        $cartItems = Cart::session(auth()->user()->id)->getContent();
        $cartTotal = Cart::session(auth()->user()->id)->getTotal();
        $currency = getCurrency(config('app.currency'));
        $course_ids = [];
        $bundle_ids = [];
        $courses = new Collection(Course::find($course_ids));
        $bundles = Bundle::find($bundle_ids);
        $courses = $bundles->merge($courses);

        //        //$cartItems = \Cart::getContent();
        //        foreach ($cartItems as $row) {
        //            $items1 = [
        //                $row->name,
        //            ];
        //        }
        //       // $itemshere = $cartItems[]->name;
        //        $cartItems1 = implode(" ", $cartItems);
        //        dd($cartItems1);
        try {
            DB::beginTransaction();
            /** @var User $user */

            $user = $request->user();

            /** @var Payment $payment */
            $payment = $user->payments()->create([
                'transactionid' => Pesapal::random_reference(),
                'status' => "NEW",
                'amount' => $cartTotal,
                'businessid' => 'AnyName'

            ]);
            $paymentDetails = array(
                'amount' => $cartTotal,
                'description' => 'Payment for online course(s)', //call this whatever you want
                'type' => "MERCHANT",
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email, // this is required
                'phone_number' => $user->phone,
                'reference' => $payment->transactionid,
                'address' => $user->address,
                'height' => '800px',
            );

            $iframe = Pesapal::makePayment($paymentDetails);

            DB::commit();

            return view('pesapal.make', compact('iframe'));


        } catch (\Exception $exception) {


            DB::rollBack();

            throw  $exception;
        }


    }

}
