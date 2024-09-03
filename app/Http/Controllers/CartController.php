<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
        // Here you would handle the payment processing using Stripe or another payment gateway

        // For now, let's just clear the cart and pretend it was successful
        session()->forget('cart');

        return redirect()->route('shop')->with('success', 'Thank you for your purchase!');
    }
}
