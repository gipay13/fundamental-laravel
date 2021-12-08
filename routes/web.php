<?php

use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\HomeController;
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

Route::middleware('auth')->group(function () {
    Route::middleware(['ensure.user.role:user'])->group(function () {
        Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('ensure.user.role:user');
        Route::post('checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::get('payment/success', [UserController::class, 'midtransCallback']);
        Route::post('payment/success', [UserController::class, 'midtransCallback']);
    });

    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('ensure.user.role:user')->group(function() {
        Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
    });

    Route::prefix('admin/dashboard')->namespace('Admin')->name('admin.')->middleware('ensure.user.role:admin')->group(function() {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::post('checkout/{checkout}', [AdminDashboard::class, 'update'])->name('checkout.update');
    });
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
