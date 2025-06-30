<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // Import model Booking
use App\Models\ProfilUser; // Import model ProfilUser
use Carbon\Carbon; // For date and time manipulation

class UserDashboardController extends Controller
{
    /**
     * Display the user's dashboard with booking information.
     */
    public function index()
    {
        $user = Auth::user();

        // Retrieve the user's profile
        $profilUser = $user->profil;

        // If the user doesn't have a profile, redirect them to create one
        if (!$profilUser) {
            return redirect()->route('profil.index')->with('warning', 'Mohon lengkapi profil Anda terlebih dahulu untuk melihat dashboard.');
        }

        // --- Fetching Data for the Dashboard ---

        // All bookings for the current user's profile
        // Eager load 'court' and its 'venue' to display relevant details
        $allUserBookings = Booking::where('profils_user_id', $profilUser->id)
                                ->orderBy('booking_date', 'desc')
                                ->orderBy('start_time', 'desc')
                                ->with('court.venue')
                                ->get();

        // Filter for Active/Upcoming Bookings (Your "Booking" tab)
        // Bookings that are in the future or current day AND not cancelled/failed
        $activeBookings = $allUserBookings->filter(function($booking) {
            $bookingDate = Carbon::parse($booking->booking_date, 'Asia/Jakarta');
            return $bookingDate->isSameDay(Carbon::today('Asia/Jakarta')) || $bookingDate->isAfter(Carbon::today('Asia/Jakarta'))
                   && !in_array($booking->status, ['cancelled', 'failed']);
        });

        // Filter for History Bookings (Your "Riwayat Booking" tab)
        // Bookings that are in the past OR have a status of cancelled/failed/completed
        $historyBookings = $allUserBookings->filter(function($booking) {
            $bookingDate = Carbon::parse($booking->booking_date, 'Asia/Jakarta');
            return $bookingDate->isBefore(Carbon::today('Asia/Jakarta'))
                   || in_array($booking->status, ['cancelled', 'failed', 'completed']);
        });

        // Transaction Status Summary
        // These counts reflect the data you want to show in the "Status Transaksi Anda" card
        $transactionStatus = [
            'pending_payment' => Booking::where('profils_user_id', $profilUser->id)->where('status', 'pending')->count(),
            'awaiting_confirmation' => Booking::where('profils_user_id', $profilUser->id)->where('status', 'awaiting_confirmation')->count(),
            'completed' => Booking::where('profils_user_id', $profilUser->id)->where('status', 'completed')->count(),
            'cancelled' => Booking::where('profils_user_id', $profilUser->id)->where('status', 'cancelled')->count(),
            'total_bookings' => $allUserBookings->count(), // Total count for summary if needed
        ];

        // Sample Notifications (replace with actual notification logic later)
        $recentNotifications = [
            ['message' => 'Booking lapangan futsal tanggal 29 Juli 2025 jam 19:00 telah dikonfirmasi.', 'time' => '1 jam yang lalu', 'type' => 'success'],
            ['message' => 'Pembayaran Anda untuk booking tanggal 28 Juli 2025 jam 10:00 sudah terverifikasi.', 'time' => '3 jam yang lalu', 'type' => 'info'],
            ['message' => 'Lapangan badminton 3 akan dibersihkan pada tanggal 1 Agustus 2025. Mohon periksa kembali jadwal Anda.', 'time' => '1 hari yang lalu', 'type' => 'warning'],
        ];


        // Pass all data to the dashboard view
        return view('user.dashbord_venue', compact(
            'user',
            'profilUser',
            'activeBookings',
            'historyBookings',
            'transactionStatus',
            'recentNotifications'
        ));
    }

    // You don't need a separate history method if index() handles both tabs via JS.
    // If you plan to have a dedicated history page with more details, then keep it.
}