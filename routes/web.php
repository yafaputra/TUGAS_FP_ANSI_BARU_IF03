<?php

use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\SparringController; // Jika Anda masih menggunakannya
use App\Http\Controllers\VenueController; // Gunakan ini saja
use App\Http\Controllers\BookingController; // Untuk booking
use App\Http\Controllers\EventController; // Untuk event
use App\Http\Controllers\Auth\RegisteredUserController;
=======
use App\Http\Controllers\SparringController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserDashboardController; // Make sure this is imported!
// No need for VenueOwnerDashboardController if this is the only dashboard type
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985

Route::get('/', function () {
    return view('homepage.home');
});

Route::get('/home', function () {
    return view('homepage.home');
<<<<<<< HEAD
})->name('home');  // Tambahkan ->name('home') di sini
=======
})->name('home');
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985

// --- User Dashboard Route (This is the one you are using) ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/venue', [UserDashboardController::class, 'index'])->name('venue.dashboard');
    // If you had a separate 'user.dashboard' route before, you can remove or redirect it.
});

// Other existing routes remain the same:
Route::get('/dashboard/sparring', function () {
    return view('user.dashbord_sparring');
})->name('sparring.dashboard');

// --- Rute Booking Checkout BARU ---
Route::middleware('auth')->group(function () {
    Route::get('/booking/payment/{booking_id}', [BookingController::class, 'showPaymentPage'])->name('payment.page');
    Route::post('/payment/process', [BookingController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/instructions/{payment_id}', [BookingController::class, 'showPaymentInstructions'])->name('payment.instructions'); // New route for instructions
    Route::get('/booking/status/{booking_id}', [BookingController::class, 'showBookingStatus'])->name('booking.status'); // General booking statu
    // Rute GET untuk menampilkan form checkout
    Route::get('/booking/checkout', [BookingController::class, 'showCheckoutForm'])->name('booking.checkout.show');
    // Rute POST untuk memproses booking (ini adalah pengganti dari route('bookings.store') yang lama)
    Route::post('/booking/process', [BookingController::class, 'processBookingFromCheckout'])->name('booking.process');
});

Route::get('/booking/payment/{booking_id}', [BookingController::class, 'showPaymentPage'])->name('payment.page');

<<<<<<< HEAD
// Route untuk menampilkan form edit profil (GET request)
=======
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985
Route::get('/profile', [ProfilController::class, 'edit'])
    ->name('profil.index')
    ->middleware('auth');

Route::post('/profile', [ProfilController::class, 'update'])
    ->name('profil.update')
    ->middleware('auth');

require __DIR__.'/auth.php';

Route::get('/sparring', [SparringController::class, 'index'])->name('sparring.index');
Route::get('/sparring/search', [SparringController::class, 'search'])->name('sparring.search');

Route::get('/venue', [VenueController::class, 'index'])->name('venue.index');
Route::get('/venue/search', [VenueController::class, 'search'])->name('venue.search');

Route::get('/venues/{id}', [VenueController::class, 'show'])->name('venue.show');

<<<<<<< HEAD
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
=======
Route::post('/venues/{id}/availability', [VenueController::class, 'getCourtAvailability'])->name('venue.get-availability');

Route::post('/bookings', [BookingController::class, 'processBooking'])->name('bookings.store');

>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

<<<<<<< HEAD
Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
=======
Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);


>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985
