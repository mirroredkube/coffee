<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Charge;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Initialize cart if not present in session
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'image' => $product->image
            ];
        }

        // Save the cart back to the session
        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'cartCount' => count($cart)]);
        } else {
            return redirect()->back()->with('success', 'Product added to cart!');
        }
    }

    public function index()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        $total = 0;

        // If the cart is empty, redirect back with an error
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Return the checkout view with the cart data
        return view('cart', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        // Set Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            // Create the charge on Stripe's servers
            $charge = Charge::create([
                'amount' => $total * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken, // Token from Stripe.js
                'description' => 'Order payment',
            ]);

            // Clear the cart
            session()->forget('cart');

            return redirect()->route('shop')->with('success', 'Payment successful! Thank you for your purchase!');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Payment failed! ' . $e->getMessage());
        }
    }
}
