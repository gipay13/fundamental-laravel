<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Checkouts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutsController extends Controller
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
    public function create(Request $request, Camps $camps)
    {
        if ($camps->isRegisteredOnCamp) {
            $request->session()->flash('error', "You Already Registered on $camps->bootcamps_name camp.");
            return redirect(route('dashboard'));
        }

        $data = [
            'camps' => $camps,
        ];

        return view('user.checkout.checkout-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Camps $camps)
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
        return $request->all();
        // $store = $request->all();
        // $store['users_id'] = Auth::id();
        // $store['camps_id'] = $camps->id;

        // $user = Auth::user();
        // $user->email = $store['email'];
        // $user->name = $store['name'];
        // $user->occupation = $store['occupation'];
        // $user->save();

        // $checkout = Checkouts::create($store);

        // return redirect(route('checkout.success'));
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
}
