<?php

use Illuminate\Support\Facades\Auth;
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
    return view('homepage/homepage');
})->name('home');

Auth::routes([
    'login' => false, // Login routes...

    'register' => false, // Register Routes...

    'reset' => false, // Reset Password Routes...

    'verify' => false, // Email Verification Routes...
]);

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');


Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});
