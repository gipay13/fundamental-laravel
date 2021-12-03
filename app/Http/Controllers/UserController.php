<?php

namespace App\Http\Controllers;

use App\Mail\User\AfterRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.user.login');
    }

    public function google_signin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handle_google_provider_callback()
    {
        $callback = Socialite::driver('google')->stateless()->user();

        $data = [
            'name'  => $callback->getName(),
            'email'  => $callback->getEmail(),
            'image'  => $callback->getAvatar(),
            'email_verified_at'  => date('Y-m-d H:i:s', time()),
        ];

        // $user = User::firstOrCreate(['email' => $data['email']], $data);
        $user = User::whereEmail($data['email'])->first();

        if(!$user) {
            $store_user = User::create($data);
            Mail::to($store_user->email)->send(new AfterRegister($store_user));
        }
        Auth::login($user, true);

        return redirect(route('home'));
    }
}
