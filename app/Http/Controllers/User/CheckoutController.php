<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\User\AfterCheckout;
use App\Models\Camp;
use App\Models\Checkout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Str;
use Midtrans;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index()
    {
    }

    public function create(Request $request, Camp $camp)
    {
        if ($camp->isRegisteredOnCamp) {
            $request->session()->flash('error', "You Already Registered on $camp->bootcamp_name camp.");
            return redirect(route('user.dashboard'));
        }

        $data = [
            'camp' => $camp,
        ];

        return view('user.checkout.checkout-create', $data);
    }

    public function store(Request $request, Camp $camp)
    {
        //jika ingin lebih komples gunakan php artisan make:request
        //kemuadian ganti Request menjadi File yg dibuat misakan Store $request
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email,'.Auth::id().',id',
            'occupation'    => 'required|string',
            'phone'         => 'required|number',
            'address'       => 'required|string',

        ]);

        $store = $request->all();
        $store['user_id'] = Auth::id();
        $store['camp_id'] = $camp->id;

        $user = Auth::user();
        $user->email = $store['email'];
        $user->name = $store['name'];
        $user->occupation = $store['occupation'];
        $user->save();

        $checkout = Checkout::create($store);
        $this->getSnapRedirect($checkout);

        Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

        return redirect(route('checkout.success'));
    }

    public function destroy($id)
    {
        //
    }

    public function success()
    {
        return view('user.checkout.checkout-success');
    }

    public function getSnapRedirect(Checkout $checkout)
    {
        $order_id = $checkout->id.'-'. Str::random(5);
        $checkout->midtrans_booking_code = $order_id;

        $transaction_details = [
            'order_id'      => $order_id,
            'gross_amount'  => $checkout->camp->price * 1000,
        ];

        $items_details[] = [
            'id'        => $checkout->id,
            'price'     => $checkout->camp->price * 1000,
            'quantity'  => 1,
            'name'      => 'Payment for { $checkout->camp->bootcamp_name }',
        ];

        $user_data = [
            'first_name'    => $checkout->user->name,
            'last_name'     => '',
            'address'       => $checkout->user->address,
            'city'          => '',
            'postal_code'   => '',
            'phone'         => $checkout->user->phone,
            'country_code'  => 'IDN'
        ];

        $customer_details = [
            'first_name'        => $checkout->user->name,
            'last_name'         => '',
            'email'             => $checkout->user->email,
            'phone'             => $checkout->user->phone,
            'billing_address'   => $user_data,
            'shipping_address'  => $user_data,
        ];

        $midtrans_params = [
            'transaction_details'   => $transaction_details,
            'customer_details'      => $customer_details,
            'item_details'          => $items_details,
        ];

        try {
            $payment_url = \Midtrans\Snap::createTransaction($midtrans_params)->redirect_url;
            $checkout->midtrans_url = $payment_url;
            $checkout->save();

            return $payment_url;
        } catch (Exception $e) {
            return false;
        }
    }

    public function midtransCallback(Request $request)
    {
        $notif = new Midtrans\Notification();

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $checkout_id =  explode('-', $notif->order_id);
        $checkout = Checkout::find($checkout_id);

        if($transaction_status == 'capture') {
            if($fraud == 'challenge') {
                $checkout->payment_status = 'pending';
            } else if($fraud == 'accept') {
                $checkout->payment_status = 'paid';
            }
        } elseif ($transaction_status == 'cancel') {
            if($fraud == 'challenge') {
                $checkout->payment_status = 'failed';
            } else if($fraud == 'accept') {
                $checkout->payment_status = 'failed';
            }
        } else if($transaction_status == 'deny') {
            $checkout->payment_status = 'failed';
        } else if($transaction_status == 'settlement') {
            $checkout->payment_status = 'paid';
        } else if($transaction_status == 'pending') {
            $checkout->payment_status = 'pending';
        } else if($transaction_status == 'expire') {
            $checkout->payment_status = 'failed';
        }

        $checkout->save();

        return view('user.checkout.checkout-success');
    }
}
