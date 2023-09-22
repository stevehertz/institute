<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Pesapal;
use App\Payment;
use Cart;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    private function makeOrder()
    {
        $coupon = Cart::session(auth()->user()->id)->getConditionsByType('coupon')->first();
        if ($coupon != null) {
            $coupon = Coupon::where('code', '=', $coupon->getName())->first();
        }
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = str_random(8);
        $order->amount = Cart::session(auth()->user()->id)->getTotal();
        $order->status = 1;
        $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
        $order->payment_type = 1;
        $order->save();
        foreach (Cart::session(auth()->user()->id)->getContent() as $cartItem) {
            if ($cartItem->attributes->type == 'bundle') {
                $type = Bundle::class;
            } else {
                $type = Course::class;
            }
            $order->items()->create([
                'item_id' => $cartItem->id,
                'item_type' => $type,
                'price' => $cartItem->price
            ]);
        }
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        return $order;
    }

    public function paymentSuccess(Request $request)
    {

        /**
         * Order statuses
         * COMPLETED
         * PENDING
         * INVALID
         * FAILED
         **/

        //Create the order
        $order = $this->makeOrder();
        
        //proceed to check the status of the payment
        $status = null;
        $trackingid = \request('tracking_id');
        $ref = \request('merchant_reference');
        $payments = Payment::where('transactionid', $ref)->first();

        if ($payments instanceof Payment) {
            $payments->tracking_id = $trackingid;
            $payments->status = 'PENDING';
            $payments->save();

            //Initiate orders here

            $order->payment_type = 1;
            $order->transaction_id = $ref;
            $order->status = 0;
            $order->save();
            $paymentstatus = $payments->status;
        }
        //where do you want the use to be redirected after making payment
        //set the route name here
        Cart::session(auth()->user()->id)->clear();
        session()->forget('cartCurrency');
        return redirect()->to('user/dashboard');
    }

    public function confirm()
    {
        $trackingid = request()->get('pesapal_transaction_tracking_id');
        $merchant_reference = request()->get('pesapal_merchant_reference');
        $pesapal_notification_type = request()->get('pesapal_notification_type');

        $this->checkpaymentstatus($trackingid, $merchant_reference, $pesapal_notification_type);
    }

    public function checkpaymentstatus($trackingid, $merchant_reference, $pesapal_notification_type)
    {
        $status = Pesapal::getMerchantStatus($merchant_reference);
        $payments = Payment::where('tracking_id', $trackingid)->first();
        $payments->status = $status;
        $payments->payment_method = "PESAPAL";
        $payments->save();

        $order = Order::where('transaction_id', $merchant_reference)->first();
        if ($payments->status == 'COMPLETED') {
            $order->status = 1;
            $order->payment_type = 1;
            $order->transaction_id = $merchant_reference;
            $order->save();
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->courses as $course) {
                        $course->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);

        } elseif ($payments->status = 'PENDING') {
            $order->payment_type = 1;
            $order->transaction_id = $merchant_reference;
            $order->status = 0;
            $order->save();

           // Cart::session(auth()->user()->id)->clear();
            return redirect()->route('cart.index')->withErrors(['msg', 'Your payment is pending confirmation']);;

        } elseif ($payments->status = 'FAILED') {
            $order->payment_type = 1;
            $order->status = 2;
            $order->save();

            return redirect()->route('cart.index')->withErrors(['msg', 'Payment failed']);
        } elseif ($payments->status = 'INVALID') {
            $order->status = 3;
            $order->save();
            return redirect()->route('cart.index')->withErrors(['msg', 'We are unable to process your payment request']);
        }

        /*******
         *
         *
         * if the $status  == COMPLETE the payment is sucessfull
         *
         */

        return "SUCCESS";
    }

}
