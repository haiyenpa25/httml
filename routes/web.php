<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/layouts', function () {
    return view('layouts/layout');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});