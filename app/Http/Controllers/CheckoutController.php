<?php

namespace App\Http\Controllers;

use App\Mail\User\AfterCheckout;
use App\Models\Camp;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Camp $camp)
    {
        if ($camp->isRegisteredOnCamp) {
            $request->session()->flash('error', "You Already Registered on $camp->bootcamp_name camp.");
            return redirect(route('dashboard'));
        }

        $data = [
            'camp' => $camp,
        ];

        return view('user.checkout.checkout-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Camp $camp)
    {
        //jika ingin lebih komples gunakan php artisan make:request
        //kemuadian ganti Request menjadi File yg dibuat misakan Store $request
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email,'.Auth::id().',id',
            'occupation'    => 'required|string',
            'card_number'   => 'required|numeric|digits_between:8,16',
            'expired'       => 'required|date|date_format:Y-m|after_or_equal:'.date('Y-m', time()),
            'cvc'           => 'required|numeric|digits:3'
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

        Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

        return redirect(route('checkout.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function success()
    {
        return view('user.checkout.checkout-success');
    }

    public function invoice(Checkout $checkout)
    {
        return $checkout;
    }
}
