<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Session as FlashSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        Log::info("Inside payment checkout process method");
        Log::info("Checkout method called");
        Log::info("Request data: " . json_encode($request->all()));
        try {
            // Set the Stripe secret key
            Stripe::setApiKey(config('services.stripe.secret'));

            Log::info("Stripe API Key: " . substr(config('services.stripe.secret'), 0, 8) . '...');

            // Get cart items from session
            $cartItems = session('cart', []);

            if (empty($cartItems)) {
                return back()->with('error', 'Your cart is empty. Please add items before proceeding to checkout.');
            }

            // Prepare line items for Stripe
            $lineItems = [];
            foreach ($cartItems as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => intval($item['price'] * 100), // Convert to cents
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            // Create the Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ]);

            // Redirect to Stripe Checkout Page
            return redirect($session->url, 303);
        } catch (\Exception $e) {
            Log::error('Stripe error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your payment. Please try again.');
        }
    }

    public function success()
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            session()->flash('error', 'User not authenticated. Please log in.');
            return redirect('/login');
        }

        // Get cart items from session
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            session()->flash('error', 'Your cart is empty. Unable to process the order.');
            return redirect('/');
        }

        // Calculate total
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cartItems));

        // Create order object
        $order = [
            'user_email' => $user->email,
            'user_name' => $user->name,
            'items' => $cartItems,
            'total' => $total,
            'order_date' => now()->toDateTimeString(),
        ];

        // Send invoice email
        Log::info('Attempting to send email to: ' . $user->email);
        Mail::to($user->email)->send(new InvoiceMail($order));
        Log::info('Email sent successfully');

        // Clear the cart after successful payment
        session()->forget('cart');

        FlashSession::flash('success', 'Payment successful! Your order has been placed.');
        return redirect('/');
    }

    public function cancel()
    {
        FlashSession::flash('error', 'Payment canceled. Your cart items have been retained.');
        return redirect('/cart');
    }
}