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
            'checkout'  => Checkouts::with('camps')->whereUserId(Auth::id()),
        ];
        // $checkout = Checkouts::with('camps')->where('user_id', Auth::id());
        return view('user.dashboard', $data);
    }
}
