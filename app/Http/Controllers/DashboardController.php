<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'checkout'  => Checkout::with('camp')->whereUserId(Auth::id())->get(),
        ];
        // $checkout = Checkouts::with('camps')->whereUsersId(Auth::id())->get();
        // $checkout = Checkouts::with('camps')->where('user_id', Auth::id())->get();
        // return $checkout;
        return view('user.dashboard', $data);
    }
}
