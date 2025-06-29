<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class BookingController extends Controller
{
    public function processBooking(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i:s',
            'duration_hours' => 'required|integer|min:1|max:4', // Misalnya maks 4 jam
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $court = Court::findOrFail($request->court_id);
        $bookingDate = Carbon::parse($request->booking_date);
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addHours($request->duration_hours);

        // Pastikan waktu selesai tidak melebihi jam tutup venue atau 23:00 (contoh)
        // Jika venue 24 jam, ini mungkin tidak perlu terlalu ketat
        $venueOpeningHoursEnd = Carbon::parse('23:00:00'); // Contoh jam tutup
        if ($endTime->greaterThan($venueOpeningHoursEnd) && $bookingDate->isSameDay(Carbon::today())) {
             return response()->json(['message' => 'Waktu booking melebihi jam operasional venue.'], 400);
        }

        // Hitung total harga
        $totalPrice = $court->base_price_per_hour * $request->duration_hours;

        // Cek ketersediaan slot secara real-time sebelum booking
        // Ini adalah bagian penting untuk mencegah double booking
        $isBooked = Booking::where('court_id', $court->id)
            ->whereDate('booking_date', $bookingDate)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime->format('H:i:s'))
                      ->where('end_time', '>', $startTime->format('H:i:s'));
                });
            })
            ->exists();

        if ($isBooked) {
            return response()->json(['message' => 'Slot waktu ini sudah dibooking. Silakan pilih slot lain.'], 409); // Conflict
        }

        DB::beginTransaction(); // Mulai transaksi database
        try {
            $booking = Booking::create([
                'user_id' => auth()->id(), // Akan null jika user tidak login
                'court_id' => $court->id,
                'booking_date' => $bookingDate->toDateString(),
                'start_time' => $startTime->toTimeString(),
                'end_time' => $endTime->toTimeString(),
                'duration_hours' => $request->duration_hours,
                'total_price' => $totalPrice,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'status' => 'pending', // Atau 'confirmed' jika pembayaran langsung
            ]);

            DB::commit(); // Commit transaksi
            return response()->json([
                'message' => 'Booking berhasil dibuat!',
                'booking' => $booking,
                'redirect_url' => route('payment.page', ['booking_id' => $booking->id]) // Arahkan ke halaman pembayaran
            ], 201); // Created
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika ada error
            return response()->json(['message' => 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage()], 500);
        }
    }

    // Anda bisa tambahkan method untuk menampilkan halaman pembayaran,
    // mengupdate status booking setelah pembayaran, dll.
    public function showPaymentPage($booking_id)
    {
        $booking = Booking::with('court.venue')->findOrFail($booking_id);
        return view('booking.booking', compact('booking'));
    }
}