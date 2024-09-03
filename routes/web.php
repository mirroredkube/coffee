<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/hello', function () {
    $name = 'Coffee Lovers';
    return view('hello', ['name' => $name]);
}); */

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/partner', function () {
    return view('partner');
});

Route::get('/contact', function () {
    return view('contact');
});

// Login Page Route
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/login', function () {
    if (Auth::check()) {
        // Redirect to the intended page if it exists, or default to the homepage ("/")
        return redirect()->intended('/')->with('status', 'You\'re already logged in!');
    }
    return view('login');
})->name('login');

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/partner', [PartnerController::class, 'show'])->name('partner.show');
Route::post('/partner', [PartnerController::class, 'submit'])->name('partner.submit');

// Define the route for the shop page
Route::get('/shop', [ShopController::class, 'index']);

// Google Auth
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
