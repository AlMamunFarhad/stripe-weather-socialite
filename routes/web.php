<?php

use App\Http\Controllers\PracticeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SocialAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stripe', [StripeController::class, 'makePayment']);
Route::get('auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback']);
Route::get('/practice', [PracticeController::class, 'praceticeMethod'])->name('pracetice');


