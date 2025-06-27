<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/venue', function () {
    return view('venue.venue');
});
Route::get('/venue_mendaftar', function () {
    return view('venue.venue_mendaftar');
});

Route::get('/sparring', function () {
    return view('sparring.sparring');
});

Route::get('/home', function () {
    return view('homepage.home');
});

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
