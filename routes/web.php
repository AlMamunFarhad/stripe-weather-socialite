<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SocialAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stripe', [StripeController::class, 'makePayment']);
Route::get('auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback']);


