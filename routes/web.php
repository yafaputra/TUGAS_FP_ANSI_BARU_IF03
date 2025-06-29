
<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparringController; // Jika Anda masih menggunakannya
use App\Http\Controllers\VenueController; // Gunakan ini saja
use App\Http\Controllers\BookingController; // Untuk booking
use App\Http\Controllers\Auth\RegisteredUserController;



Route::get('/', function () {
    return view('homepage.home');
});

Route::get('/home', function () {
    return view('homepage.home');
})->name('home');  // Tambahkan ->name('home') di sini
// Route::get('/profil', function () {
//     return view('user.profil');
// });

// web.php
Route::get('/dashboard/venue', function () {
    return view('user.dashbord_venue');
})->name('venue.dashboard');

Route::get('/dashboard/sparring', function () {
    return view('user.dashbord_sparring');
})->name('sparring.dashboard');

Route::get('/booking/payment/{booking_id}', [BookingController::class, 'showPaymentPage'])->name('payment.page');


// // Remove duplicate profile route
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
//     // Other authenticated routes...
// });
    // Route untuk menampilkan halaman profil

    
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



// ... (route lain yang mungkin sudah ada)

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

