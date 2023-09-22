<?php


namespace App\Http\Controllers;

use App\Mail\Frontend\AdminOrederMail;
use App\Models\Auth\User;
use App\Models\Bundle;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use Carbon\Carbon;
use Mpesa;
use Illuminate\Http\Request;
use App\Models\MpesaPayments;
use Cache;
use Exception;
use Redirect;
use Response;
use Session;
use URL;
use Validator;
use View;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Cart;
class MpesaPaymentController
{

//    /**
//     * @var PaymentRepository
//     */
//    protected $paymentRepo;
//
//    /**
//     * @var ContactMailer
//     */
//    protected $contactMailer;
//
//    /**
//     * @var PaymentService
//     */
//    protected $paymentService;
//
//    /**
//     * PaymentController constructor.
//     *
//     * @param PaymentRepository $paymentRepo
//     * @param ContactMailer     $contactMailer
//     * @param PaymentService    $paymentService
//     */
//    public function __construct(
//        PaymentRepository $paymentRepo,
//        ContactMailer $contactMailer,
//        PaymentService $paymentService
//    ) {
//        $this->paymentRepo = $paymentRepo;
//        $this->contactMailer = $contactMailer;
//        $this->paymentService = $paymentService;
//    }

    public function index()
    {
        if (Auth::user()->id == 1) {
            $mpesaPayments = MpesaPayments::with(['invoice' => function ($q) {
                $q->with('invoice');
            }])->orderBy('id', 'DESC')->paginate(50);
        } else {
            $mpesaPayments = [];
        }

        return View::make('mpesa.mpesa_payments_view', ['payments' => $mpesaPayments

        ]);
    }

    public function registerUrls()
    {
        $registerUrlsResponse = Mpesa::c2bRegisterUrls();
        \Log::info($registerUrlsResponse);
    }

    public function makePayment($invoice_id)
    {
        $invoice = Invoice::with('user')->with('account')->with('client')->where('id', '=', $invoice_id)->first();
                             
        $n = $invoice->balance;
        $whole = floor($n);      // 1
        $fraction = $n - $whole; // .25
        $roundedValue = round($invoice->balance, 0);
        if (($fraction >= 0.01) && ($fraction < 0.5)) {
            $roundedValue = $roundedValue + 1;
        }

        $data = [
            'task' => null,
            'clientPublicId' => $invoice->client_id,
            'projectPublicId' => $invoice->project_id,
            'invoice_number' => $invoice->invoice_number,
            'invoice_amount' => $invoice->balance,
            'invoice_balance' => $roundedValue,
            'invoice' => $invoice,
            'method' => 'POST',
            'url' => 'mpesaexpresspayment',
            'title' => 'Mpesa Express',
            'timezone' => session('timezone') ? session('timezone') : DEFAULT_TIMEZONE,
            'datetimeFormat' => session('datetimeFormat'),
        ];
        return View::make('mpesa.pay_with_mpesa')->with($data);
    }

    public function mpesaExpress(Request $request)
    {
        $amount = $request->amount;
        $clientPhone = $request->clientPhone;
        $naration = $request->uniqueOrderId;
        $expressResponse = Mpesa::express($amount, $clientPhone, $naration, $naration);
        \Log::info($expressResponse);
        $response = json_decode($expressResponse, true);
        if ($response['ResponseCode'] == 0) {
            //Create the order after sending stkpush
            $coupon = Cart::session(auth()->user()->id)->getConditionsByType('coupon')->first();
            if ($coupon != null) {
                $coupon = Coupon::where('code', '=', $coupon->getName())->first();
            }
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->reference_no = $request->uniqueOrderId;
            $order->amount = Cart::session(auth()->user()->id)->getTotal();
            $order->status = 0;
            $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
            $order->payment_type = 8;
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
            Cart::session(auth()->user()->id)->clear();
            session()->forget('uniqueOrderNumber');
            session()->forget('cartCurrency');
            return redirect(url('user/dashboard'))->with('message', 'Request sent, check your phone and enter PIN to complete');;
        } elseif ($response['errorCode'] == '400.002.02') {
            return redirect()->back()->with('error', 'Invalid amount, contact support@stawitech.com for assistance');
            \Log::error($response);
        } else {

            \Log::error($response);
            return redirect()->back()->with('error', 'Unable to process request,Contact support for assistance.');
        }


    }

    public function validate(Request $request)
    {
        if ($request->TransID != null) {
            $transaction = new MpesaPayments();
            $transaction->TransID = $request->TransID;
            $transaction->TransTime = Carbon::parse($request->TransTime)->format('Y-m-d H:i:s');
            $transaction->TransAmount = $request->TransAmount;
            $transaction->BusinessShortCode = $request->BusinessShortCode;
            $transaction->BillRefNumber = $request->BillRefNumber;
            $transaction->InvoiceNumber = $request->InvoiceNumber;
            $transaction->OrgAccountBalance = $request->OrgAccountBalance;
            $transaction->ThirdPartyTransID = $request->ThirdPartyTransID;
            $transaction->CustomerPhone = $request->MSISDN;
            $transaction->FirstName = $request->FirstName;
            $transaction->MiddleName = $request->MiddleName;
            $transaction->LastName = $request->LastName;
            try {
                $transaction->save();
            } catch (\Exception $e) {
                \Log::info($e->getMessage() . 'Saving payments failed, An error occurred ');
            }

            $order = Order::where('reference_no', $request->BillRefNumber)->first();
            if ($order !== null && $request->TransAmount >= $order->amount) {
                $order->status = 1;
                $order->payment_type = 8;
                $order->transaction_id = $request->TransID;
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
            }
        } else {
            \Log::info($request);
        }
    }

    public function confirm(Request $request)
    {

        \Log::info($request->getContent());
        if ($request->TransID != null) {

            $transaction = new MpesaPayments();
            $transaction->TransID = $request->TransID;
            $transaction->TransTime = Carbon::parse($request->TransTime)->format('Y-m-d H:i:s');
            $transaction->TransAmount = $request->TransAmount;
            $transaction->BusinessShortCode = $request->BusinessShortCode;
            $transaction->BillRefNumber = $request->BillRefNumber;
            $transaction->InvoiceNumber = $request->InvoiceNumber;
            $transaction->OrgAccountBalance = $request->OrgAccountBalance;
            $transaction->ThirdPartyTransID = $request->ThirdPartyTransID;
            $transaction->CustomerPhone = $request->MSISDN;
            $transaction->FirstName = $request->FirstName;
            $transaction->MiddleName = $request->MiddleName;
            $transaction->LastName = $request->LastName;
            try {
                $transaction->save();
            } catch (\Exception $e) {
                \Log::info($e->getMessage() . 'Saving payments failed, An error occurred ');
            }
            try {
                $order = Order::where('reference_no', $request->BillRefNumber)->first();
                if ($order !== null && $request->TransAmount >= $order->amount) {
                    $order->status = 1;
                    $order->payment_type = 1;
                    $order->transaction_id = $request->TransID;
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


                }
            } catch (\Exception $e) {
                \Log::error($e->getMessage() . '  -Updating order failed, An error occurred ');
            }

        } else {
            \Log::info($request);
        }
    }

    public function checkBalance()
    {
        $balanceResponse = Mpesa::check_balance();
        \Log::info($balanceResponse);

    }

    public function checkBalanceTimedOut(Request $request)
    {
        \Log::info($request);

    }

    private static function getViewModel($task = false)
    {


        return [
            'clients' => Client::withActiveOrSelected($task ? $task->client_id : false)->with('contacts')->orderBy('name')->get(),
            'account' => $task->account,
            'projects' => Project::withActiveOrSelected($task ? $task->project_id : false)->with('client.contacts')->orderBy('name')->get(),
        ];
    }

    private function checkTimezone()
    {
        if (!Auth::user()->account->timezone) {
            $link = link_to('/settings/localization?focus=timezone_id', trans('texts.click_here'), ['target' => '_blank']);
            Session::now('warning', trans('texts.timezone_unset', ['link' => $link]));
        }
    }

    public function makeMpesaOrder(Request $request)
    {
        $paymentRecordStatus = $this->checkMpesaRecord($request->uniqueOrderId);
        $coupon = Cart::session(auth()->user()->id)->getConditionsByType('coupon')->first();
        if ($coupon != null) {
            $coupon = Coupon::where('code', '=', $coupon->getName())->first();
        }
        $order = new Order();
        $order->status = 0;
        if ($paymentRecordStatus !==null && $paymentRecordStatus->TransAmount == Cart::session(auth()->user()->id)->getTotal()) {
            $order->status = 1;
            $order->user_id = auth()->user()->id;
            $order->reference_no = $request->uniqueOrderId;
            $order->amount = Cart::session(auth()->user()->id)->getTotal();
            $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
            $order->payment_type = 8;
            $order->save();
            //Getting and Adding items
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
        } else {
            $order->status = 0;
            $order->user_id = auth()->user()->id;
            $order->reference_no = $request->uniqueOrderId;
            $order->amount = Cart::session(auth()->user()->id)->getTotal();
            $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
            $order->payment_type = 8;
            $order->save();
            //Getting and Adding items
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
        }
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        Cart::session(auth()->user()->id)->clear();
        session()->forget('uniqueOrderNumber');
        session()->forget('cartCurrency');
        return redirect(url('user/dashboard'));
    }

    public function checkMpesaRecord($orderNumber)
    {
        $mpesaPayment = MpesaPayments::where('BillRefNumber', '=', $orderNumber)->first();
        return $mpesaPayment;
    }

    private function adminOrderMail($order)
    {
        if (config('access.users.order_mail')) {
            $content = [];
            $items = [];
            $counter = 0;
            foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
                $counter++;
                array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
            }

            $content['items'] = $items;
            $content['total'] = number_format(Cart::session(auth()->user()->id)->getTotal(), 2);
            $content['reference_no'] = $order->reference_no;

            $admins = User::role('administrator')->get();
            foreach ($admins as $admin) {
                \Mail::to($admin->email)->send(new AdminOrederMail($content, $admin));
            }
        }
    }
}
