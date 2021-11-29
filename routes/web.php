<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login', [UserController::class, 'index'])->name('login');

Route::get('sign-in-google', [UserController::class, 'google_signin'])->name('google.login.user');

Route::get('auth/google/callback', [UserController::class, 'handle_google_provider_callback'])->name('google.user.callback');

Route::get('checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('success-checkout', function () {
    return view('success-checkout');
})->name('success-checkout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
