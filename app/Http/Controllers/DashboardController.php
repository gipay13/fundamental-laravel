<?php

namespace App\Http\Controllers;

use App\Models\Checkouts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'checkout'  => Checkouts::with('camps')->whereUsersId(Auth::id())->get(),
        ];
        // $checkout = Checkouts::with('camps')->whereUsersId(Auth::id())->get();
        // $checkout = Checkouts::with('camps')->where('user_id', Auth::id())->get();
        // return $checkout;
        return view('user.dashboard', $data);
    }
}
