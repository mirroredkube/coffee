<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PartnerController;

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

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/partner', [PartnerController::class, 'show'])->name('partner.show');
Route::post('/partner', [PartnerController::class, 'submit'])->name('partner.submit');