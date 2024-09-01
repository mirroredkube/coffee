<?php

use Illuminate\Support\Facades\Route;

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
