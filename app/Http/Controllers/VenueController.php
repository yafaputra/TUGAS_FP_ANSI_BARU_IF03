<?php

namespace App\Http\Controllers;
use App\Models\Venue;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Court;
use App\Models\VenueMendaftar;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        return view('venue.venue', compact('venues'));
    }

    public function search(Request $request)
    {
        $query = Venue::query();

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
        // Pastikan model Venue diimpor di bagian atas file
        $venue = VenueMendaftar::with('courts')->findOrFail($id);

        // Ambil data untuk tanggal default (hari ini)
        $selectedDate = Carbon::today();
        // Memanggil metode private untuk mendapatkan slot yang tersedia
        $availableSlots = $this->getAvailableSlotsForDate($venue, $selectedDate);

        // Siapkan data tanggal untuk date selector (7 hari ke depan)
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $dates[] = [
                'date' => $date->format('d M'),
                'day' => $date->translatedFormat('D'), // Untuk nama hari (Sab, Min, Sen)
                'full_date' => $date->toDateString(), // Untuk dikirim ke backend (YYYY-MM-DD)
                'active' => ($i === 0), // Set hari ini sebagai aktif default
            ];
        }

        // Pastikan view yang benar dipanggil, yaitu 'venues.show'
        // Ini akan mengarah ke resources/views/venues/show.blade.php
        return view('venue.venue_mendaftar', compact('venue', 'dates', 'availableSlots'));
    }

    /**
     * Fungsi private untuk mendapatkan slot waktu yang tersedia berdasarkan tanggal yang dipilih (digunakan untuk AJAX).
     */
    private function getAvailableSlotsForDate(VenueMendaftar $venue, Carbon $date)
    {
        $courts = $venue->courts;
        $allCourtSlots = [];

        foreach ($courts as $court) {
            $bookedSlots = $court->bookings()
                ->whereDate('booking_date', $date)
                ->get(['start_time', 'end_time'])
                ->map(function ($booking) {
                    return [
                        'start' => Carbon::parse($booking->start_time)->format('H:i'),
                        'end' => Carbon::parse($booking->end_time)->format('H:i'),
                    ];
                })
                ->toArray();

            $dailySlots = [];
            // Contoh jam buka dari 09:00 sampai 23:00 (Anda bisa menyesuaikan ini)
            for ($hour = 9; $hour < 23; $hour++) {
                $startTime = Carbon::parse(sprintf('%02d:00', $hour));
                $endTime = Carbon::parse(sprintf('%02d:00', $hour + 1));
                $slotTime = $startTime->format('H:i') . ' - ' . $endTime->format('H:i');
                $isAvailable = true;
                $price = $court->base_price_per_hour; // Harga dasar per jam

                // Cek apakah slot ini sudah dibooking atau tumpang tindih
                foreach ($bookedSlots as $booked) {
                    $bookedStart = Carbon::parse($booked['start']);
                    $bookedEnd = Carbon::parse($booked['end']);

                    // Logika tumpang tindih: (start_slot < end_booking) DAN (end_slot > start_booking)
                    if ($startTime->lt($bookedEnd) && $endTime->gt($bookedStart)) {
                        $isAvailable = false;
                        $price = 'Booked';
                        break;
                    }
                }
                $dailySlots[] = [
                    'time' => $slotTime,
                    'price' => $price == 'Booked' ? $price : 'Rp' . number_format($price, 0, ',', '.'),
                    'available' => $isAvailable,
                    'raw_price' => $price, // Untuk perhitungan nanti di frontend
                    'start_time_raw' => $startTime->format('H:i:s'), // Waktu mulai murni (HH:MM:SS)
                    'end_time_raw' => $endTime->format('H:i:s'), // Waktu selesai murni (HH:MM:SS)
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