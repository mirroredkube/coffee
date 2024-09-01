<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    $name = 'Coffee Lovers';
    return view('hello', ['name' => $name]);
});
