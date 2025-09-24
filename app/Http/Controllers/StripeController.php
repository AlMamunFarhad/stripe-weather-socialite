<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{

public function makePayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => 1000, // 10.00 USD
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        return view('stripe', [
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

}
