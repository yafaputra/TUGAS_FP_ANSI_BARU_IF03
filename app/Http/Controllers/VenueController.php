<?php

namespace App\Http\Controllers;

use App\Models\Venue; // Sesuaikan dengan model utama venue Anda jika bukan VenueMendaftar
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Court;
use App\Models\Booking;
use App\Models\VenueMendaftar; // Pastikan ini sesuai dengan model yang Anda gunakan

// Asumsi Anda menggunakan VenueMendaftar sebagai model untuk detail venue.
// Jika Anda hanya punya model Venue, ganti semua 'VenueMendaftar' menjadi 'Venue'.
class VenueController extends Controller
{
    public function index()
    {
        // Pastikan ini menggunakan model Venue atau VenueMendaftar yang benar
        $venues = Venue::all();
        return view('venue.venue', compact('venues'));
    }

    public function search(Request $request)
    {
        $query = Venue::query(); // Sesuaikan modelnya

        if ($request->has('venue')) {
            $query->where('name', 'like', '%' . $request->venue . '%');
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('sport')) {
            $query->whereJsonContains('categories', $request->sport);
        }

        $venues = $query->get();

        return view('venue.venue', compact('venues'));
    }

    /**
     * Menampilkan detail satu venue berdasarkan ID.
     */
    public function show($id)
    {
        $venue = VenueMendaftar::with('courts')->findOrFail($id);

        // Ambil tanggal hari ini berdasarkan zona waktu aplikasi (Asia/Jakarta)
        $selectedDate = Carbon::today('Asia/Jakarta');

        // Memanggil metode private untuk mendapatkan slot yang tersedia
        $availableSlots = $this->getSlotsForVenueAndDate($venue, $selectedDate);

        // Siapkan data tanggal untuk date selector (7 hari ke depan)
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today('Asia/Jakarta')->addDays($i); // Pastikan ini juga pakai zona waktu
            $dates[] = [
                'date' => $date->format('d M'),
                'day' => $date->translatedFormat('D'),
                'full_date' => $date->toDateString(),
                'active' => ($i === 0), // Hari ini akan aktif secara default
            ];
        }

        return view('venue.venue_mendaftar', compact('venue', 'dates', 'availableSlots'));
    }

    /**
     * Fungsi publik untuk API (digunakan oleh AJAX) untuk mendapatkan slot waktu yang tersedia.
     */
    public function getCourtAvailability(Request $request, $venue_id)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $venue = VenueMendaftar::with('courts')->findOrFail($venue_id);
        // Pastikan tanggal yang diparse juga berada di zona waktu yang benar
        $date = Carbon::parse($request->date, 'Asia/Jakarta');

        $availableSlots = $this->getSlotsForVenueAndDate($venue, $date);

        return response()->json($availableSlots);
    }

    /**
     * Fungsi private untuk mendapatkan slot waktu yang tersedia berdasarkan tanggal yang dipilih.
     */
    private function getSlotsForVenueAndDate(VenueMendaftar $venue, Carbon $date)
    {
        $courts = $venue->courts;
        $allCourtSlots = [];
        // Dapatkan waktu saat ini di zona waktu aplikasi (Asia/Jakarta)
        $now = Carbon::now('Asia/Jakarta');

        foreach ($courts as $court) {
            $bookedSlots = Booking::where('court_id', $court->id)
                ->whereDate('booking_date', $date)
                ->get(['start_time', 'end_time'])
                ->map(function ($booking) use ($date) {
                    // Pastikan kita membuat objek Carbon penuh dengan tanggal dan waktu
                    // dan atur zona waktunya agar konsisten
                    $start = Carbon::parse($date->toDateString() . ' ' . $booking->start_time, 'Asia/Jakarta');
                    $end = Carbon::parse($date->toDateString() . ' ' . $booking->end_time, 'Asia/Jakarta');
                    return ['start' => $start, 'end' => $end];
                })
                ->toArray();

            $dailySlots = [];
            // Contoh jam buka dari 09:00 sampai 23:00 (sesuaikan ini)
            // Anda bisa mendapatkan jam buka dari $venue->opening_hours jika formatnya konsisten
            for ($hour = 9; $hour < 23; $hour++) {
                // Buat Carbon object untuk slot dengan tanggal dan zona waktu yang benar
                $slotStartTime = $date->copy()->setTime($hour, 0, 0)->setTimezone('Asia/Jakarta');
                $slotEndTime = $date->copy()->setTime($hour + 1, 0, 0)->setTimezone('Asia/Jakarta');
                $slotTimeDisplay = $slotStartTime->format('H:i') . ' - ' . $slotEndTime->format('H:i');
                $isAvailable = true;
                $price = $court->base_price_per_hour;

                // 1. Cek apakah slot sudah lewat waktu saat ini (hanya untuk hari ini)
                // Pastikan kedua sisi perbandingan memiliki zona waktu yang sama
                if ($date->isToday() && $slotStartTime->lt($now)) {
                    $isAvailable = false;
                    $price = 'Lewat Waktu';
                } else {
                    // 2. Cek apakah slot ini sudah dibooking atau tumpang tindih
                    foreach ($bookedSlots as $booked) {
                        // Perbandingan harus dilakukan antara Carbon object yang memiliki zona waktu yang sama
                        if ($slotStartTime->lt($booked['end']) && $slotEndTime->gt($booked['start'])) {
                            $isAvailable = false;
                            $price = 'Booked';
                            break;
                        }
                    }
                }

                $dailySlots[] = [
                    'time' => $slotTimeDisplay,
                    'price' => $isAvailable ? 'Rp' . number_format($price, 0, ',', '.') : $price,
                    'available' => $isAvailable,
                    'raw_price' => $isAvailable ? $price : 0,
                    'start_time_raw' => $slotStartTime->toTimeString(), // Hanya waktu
                    'end_time_raw' => $slotEndTime->toTimeString(),     // Hanya waktu
                ];
            }

            $allCourtSlots[] = [
                'court_id' => $court->id,
                'court_name' => $court->name,
                'court_type' => $court->type,
                'surface_type' => $court->surface_type,
                'description' => $court->description,
                'image_url' => $court->image_url,
                'slots' => $dailySlots,
            ];
        }

        return $allCourtSlots;
    }
}