<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        $total = 0;

        // If the cart is empty, redirect back with an error
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Return the checkout view with the cart data
        return view('cart', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        // Here you would handle the payment processing using Stripe or another payment gateway

        // For now, let's just clear the cart and pretend it was successful
        session()->forget('cart');

        return redirect()->route('shop')->with('success', 'Thank you for your purchase!');
    }
}
