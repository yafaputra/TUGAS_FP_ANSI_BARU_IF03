<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparringController; // Jika Anda masih menggunakannya
use App\Http\Controllers\VenueController; // Gunakan ini saja
use App\Http\Controllers\BookingController; // Untuk booking
use App\Http\Controllers\EventController; // Untuk event
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('homepage.home');
});

Route::get('/home', function () {
    return view('homepage.home');
})->name('home');  // Tambahkan ->name('home') di sini

// web.php
Route::get('/dashboard/venue', function () {
    return view('user.dashbord_venue');
})->name('venue.dashboard');

Route::get('/dashboard/sparring', function () {
    return view('user.dashbord_sparring');
})->name('sparring.dashboard');

Route::get('/booking/payment/{booking_id}', [BookingController::class, 'showPaymentPage'])->name('payment.page');

// Route untuk menampilkan form edit profil (GET request)
Route::get('/profile', [ProfilController::class, 'edit'])
    ->name('profil.index')
    ->middleware('auth');

// Route untuk mengupdate profil (POST request)
Route::post('/profile', [ProfilController::class, 'update'])
    ->name('profil.update')
    ->middleware('auth');
    
require __DIR__.'/auth.php';

// Rute untuk Sparring (jika ada)
Route::get('/sparring', [SparringController::class, 'index'])->name('sparring.index');
Route::get('/sparring/search', [SparringController::class, 'search'])->name('sparring.search');

// Rute untuk daftar venue
Route::get('/venue', [VenueController::class, 'index'])->name('venue.index');
// Rute untuk pencarian venue
Route::get('/venue/search', [VenueController::class, 'search'])->name('venue.search');
// Rute untuk detail venue (menggantikan venue_mendaftar)
// Nama rute harusnya 'venues.show' untuk konsistensi dengan pola resource
Route::get('/venues/{id}', [VenueController::class, 'show'])->name('venue.show');

// ===== EVENT ROUTES =====
// Rute untuk daftar event
Route::get('/event', [EventController::class, 'event'])->name('event.event');

// Rute untuk detail event
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Rute untuk registrasi event (POST request)
Route::post('/events/{event}/register', [EventController::class, 'register'])
    ->name('events.register');

// Optional: Rute untuk pencarian event jika diperlukan
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');

// ===== END EVENT ROUTES =====

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Untuk login, jika belum ada
Route::get('/login', function () {
    return view('auth.login'); // Pastikan ini mengarah ke view login Anda
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);