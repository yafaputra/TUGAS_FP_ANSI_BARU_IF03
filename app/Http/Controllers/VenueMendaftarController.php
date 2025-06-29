<?php

namespace App\Http\Controllers;

use App\Models\VenueMendaftar;
use Illuminate\Http\Request;

class VenueMendaftarController extends Controller
{ 
    public function show($id)
    {
        $venue = Venue::with('courts')->findOrFail($id);

        // Ambil data untuk tanggal default (hari ini)
        $selectedDate = Carbon::today();
        $availableSlots = $this->getAvailableSlotsForDate($venue, $selectedDate);

        // Siapkan data tanggal untuk date selector (7 hari ke depan)
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $dates[] = [
                'date' => $date->format('d M'),
                'day' => $date->translatedFormat('D'), // Untuk nama hari (Sat, Sun, Mon)
                'full_date' => $date->toDateString(), // Untuk dikirim ke backend
                'active' => ($i === 0), // Set hari ini sebagai aktif default
            ];
        }

        return view('venue.show', compact('venue', 'dates', 'availableSlots'));
    }

    // Fungsi untuk mendapatkan slot waktu berdasarkan tanggal yang dipilih (AJAX)
    public function getCourtAvailability(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $venue = Venue::findOrFail($request->venue_id);
        $selectedDate = Carbon::parse($request->date);

        $availableSlots = $this->getAvailableSlotsForDate($venue, $selectedDate);

        return response()->json($availableSlots);
    }

    private function getAvailableSlotsForDate(Venue $venue, Carbon $date)
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
            // Contoh jam buka dari 09:00 sampai 23:00
            for ($hour = 9; $hour < 23; $hour++) {
                $startTime = Carbon::parse(sprintf('%02d:00', $hour));
                $endTime = Carbon::parse(sprintf('%02d:00', $hour + 1));
                $slotTime = $startTime->format('H:i') . ' - ' . $endTime->format('H:i');
                $isAvailable = true;
                $price = $court->base_price_per_hour; // Default price

                // Cek apakah slot ini sudah dibooking
                foreach ($bookedSlots as $booked) {
                    $bookedStart = Carbon::parse($booked['start']);
                    $bookedEnd = Carbon::parse($booked['end']);

                    // Jika ada tumpang tindih waktu
                    if ($startTime->between($bookedStart, $bookedEnd->copy()->subSecond()) ||
                        $endTime->copy()->subSecond()->between($bookedStart, $bookedEnd->copy()->subSecond()) ||
                        ($bookedStart->greaterThanOrEqualTo($startTime) && $bookedEnd->lessThanOrEqualTo($endTime))) {
                        $isAvailable = false;
                        $price = 'Booked';
                        break;
                    }
                }
                $dailySlots[] = [
                    'time' => $slotTime,
                    'price' => $price == 'Booked' ? $price : 'Rp' . number_format($price, 0, ',', '.'),
                    'available' => $isAvailable,
                    'raw_price' => $price, // Untuk perhitungan nanti
                    'start_time_raw' => $startTime->format('H:i:s'), // Waktu mulai murni
                    'end_time_raw' => $endTime->format('H:i:s'), // Waktu selesai murni
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