<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use App\Models\ProfilUser;
use App\Models\VenueMendaftar;
use App\Models\Payment; // Import model Payment
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Pastikan Log diimport

class BookingController extends Controller
{
    /**
     * Menampilkan halaman form checkout booking.
     */
    public function showCheckoutForm(Request $request)
    {
        // Validasi data yang dikirim dari halaman venue_mendaftar
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'duration_hours' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $profilUser = $user->profil;

        if (!$profilUser) {
            return redirect()->route('profil.index')->with('warning', 'Mohon lengkapi profil Anda terlebih dahulu.');
        }

        $court = Court::with('venue')->findOrFail($request->court_id); // Load relasi venue

        // Persiapkan data untuk dikirim ke view checkout
        $bookingData = [
            'court_id' => $request->court_id,
            'court_name' => $court->name,
            'venue_name' => $court->venue->name ?? 'N/A',
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_hours' => $request->duration_hours,
            'total_price' => $request->total_price,
            'customer_name' => $profilUser->full_name ?? $user->name, // Ambil dari profil/user
            'customer_phone' => $profilUser->phone_number ?? '', // Ambil dari profil
        ];

        return view('booking.checkout', compact('bookingData'));
    }


    /**
     * Memproses booking dari form checkout (setelah user mengisi detail).
     */
    public function processBookingFromCheckout(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'duration_hours' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'total_price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $profilUser = $user->profil;

        if (!$user || !$profilUser) {
            return response()->json(['message' => 'Anda harus login dan memiliki profil lengkap untuk membuat booking.'], 401);
        }

        $court = Court::findOrFail($request->court_id);

        $bookingDate = Carbon::parse($request->booking_date, 'Asia/Jakarta');
        $requestStartTime = Carbon::parse($request->start_time, 'Asia/Jakarta');
        $requestEndTime = Carbon::parse($request->end_time, 'Asia/Jakarta');

        $fullRequestStartTime = $bookingDate->copy()->setTimeFromTimeString($requestStartTime->toTimeString());
        $fullRequestEndTime = $bookingDate->copy()->setTimeFromTimeString($requestEndTime->toTimeString());

        $now = Carbon::now('Asia/Jakarta');

        // Cek jika rentang slot yang dipilih sudah lewat waktu saat ini (untuk hari ini)
        if ($bookingDate->isToday() && $fullRequestStartTime->lt($now)) {
             return response()->json(['message' => 'Slot waktu yang Anda pilih sudah lewat waktu saat ini. Silakan pilih jadwal lain.'], 400);
        }

        // Cek tumpang tindih untuk rentang waktu booking yang diminta
        $isBooked = Booking::where('court_id', $request->court_id)
            ->whereDate('booking_date', $bookingDate->toDateString())
            ->where(function ($query) use ($fullRequestStartTime, $fullRequestEndTime) {
                $query->where('start_time', '<', $fullRequestEndTime->format('H:i:s'))
                      ->where('end_time', '>', $fullRequestStartTime->format('H:i:s'));
            })
            ->exists();

        if ($isBooked) {
            return response()->json(['message' => 'Beberapa slot waktu yang Anda pilih sudah tidak tersedia atau tumpang tindih dengan booking lain. Silakan periksa kembali jadwal.'], 409);
        }

        try {
            $booking = new Booking();
            $booking->profils_user_id = $profilUser->id;
            $booking->court_id = $request->court_id;
            $booking->booking_date = $bookingDate->toDateString();
            $booking->start_time = $fullRequestStartTime->toTimeString();
            $booking->end_time = $fullRequestEndTime->toTimeString();
            $booking->duration_hours = $request->duration_hours;
            $booking->customer_name = $request->customer_name;
            $booking->customer_phone = $request->customer_phone;
            $booking->total_price = $request->total_price;
            $booking->status = 'pending'; // Status awal: pending, sebelum memilih metode pembayaran
            $booking->save();

            return response()->json([
                'message' => 'Booking berhasil dibuat. Silakan lanjutkan ke pembayaran.',
                'booking_id' => $booking->id,
                'redirect_url' => route('payment.page', ['booking_id' => $booking->id])
            ], 200);

        } catch (\Exception $e) {
            Log::error('Booking failed: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan sistem. Mohon coba lagi nanti.'], 500);
        }
    }

    /**
     * Menampilkan halaman pemilihan metode pembayaran.
     */
    public function showPaymentPage($booking_id)
    {
        $booking = Booking::with('court.venue')->findOrFail($booking_id);

        if (Auth::id() !== $booking->profilsUser->user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman pembayaran ini.');
        }

        // Cek jika sudah ada record pembayaran untuk booking ini
        // Jika ada, redirect ke halaman instruksi pembayaran yang sudah ada
        if ($booking->payment) {
            return redirect()->route('payment.instructions', ['payment_id' => $booking->payment->id])
                             ->with('info', 'Anda sudah memilih metode pembayaran untuk booking ini. Silakan selesaikan pembayaran.');
        }

        return view('booking.payment', compact('booking'));
    }

    /**
     * Memproses pemilihan metode pembayaran dan membuat record Payment (Simulasi Manual).
     * Ini adalah metode yang akan dipanggil dari form pemilihan metode pembayaran.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|string|in:BRI,BCA,Mandiri,BSI,DANA,OVO,ShopeePay,GoPay',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if (Auth::id() !== $booking->profilsUser->user->id) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk memproses pembayaran ini.'], 403);
        }

        // Mencegah pembuatan record pembayaran ganda untuk satu booking
        if ($booking->payment) {
            return response()->json([
                'message' => 'Metode pembayaran sudah dipilih untuk booking ini.',
                'redirect_url' => route('payment.instructions', ['payment_id' => $booking->payment->id])
            ], 400);
        }

        try {
            // Data simulasi untuk nama rekening dan nomor rekening/telepon
            // Sesuaikan "Futsal Arena Jaya" atau nama entitas Anda
            $accountName = "Futsal Arena Jaya"; 
            $accountNumber = "";
            $paymentCode = null; // Ini bisa digunakan untuk Virtual Account ID atau QRIS String jika suatu saat Anda butuh integrasi

            switch ($request->payment_method) {
                case 'BRI':
                    $accountNumber = "1234-5678-9012-3456"; // Contoh nomor rekening BRI
                    break;
                case 'BCA':
                    $accountNumber = "0987-6543-2109-8765"; // Contoh nomor rekening BCA
                    break;
                case 'Mandiri':
                    $accountNumber = "7890-1234-5678-9012"; // Contoh nomor rekening Mandiri
                    break;
                case 'BSI':
                    $accountNumber = "5678-9012-3456-7890"; // Contoh nomor rekening BSI
                    break;
                case 'DANA':
                    $accountName = "Futsal A.J."; // Nama penerima di DANA (singkatan jika nama terlalu panjang)
                    $accountNumber = "081234567890"; // Contoh nomor telepon DANA
                    break;
                case 'OVO':
                    $accountName = "Futsal A.J."; // Nama penerima di OVO
                    $accountNumber = "087654321098"; // Contoh nomor telepon OVO
                    break;
                case 'ShopeePay':
                    $accountName = "Futsal A.J."; // Nama penerima di ShopeePay
                    $accountNumber = "089012345678"; // Contoh nomor telepon ShopeePay
                    break;
                case 'GoPay':
                    $accountName = "Futsal A.J."; // Nama penerima di GoPay
                    $accountNumber = "081098765432"; // Contoh nomor telepon GoPay
                    break;
            }

            // Buat record pembayaran baru di tabel `payments`
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'profils_user_id' => $booking->profils_user_id,
                'amount' => $booking->total_price,
                'payment_method' => $request->payment_method,
                'status' => 'pending', // Status pembayaran awal: pending
                'account_name' => $accountName,
                'account_number' => $accountNumber,
                'payment_code' => $paymentCode, // Akan null untuk transfer bank, bisa diisi untuk VA/QRIS
                'expires_at' => Carbon::now('Asia/Jakarta')->addHours(24), // Pembayaran kadaluarsa dalam 24 jam
            ]);

            // Perbarui status booking di tabel `bookings` untuk mencerminkan bahwa pembayaran sedang menunggu
            $booking->status = 'waiting_payment'; // Status booking berubah menjadi 'waiting_payment'
            $booking->payment_method = $request->payment_method; // Simpan metode pembayaran juga di booking untuk referensi cepat
            $booking->save();

            return response()->json([
                'message' => 'Metode pembayaran berhasil dipilih. Silakan lanjutkan untuk melihat instruksi pembayaran.',
                'payment_id' => $payment->id,
                'redirect_url' => route('payment.instructions', ['payment_id' => $payment->id])
            ], 200);

        } catch (\Exception $e) {
            Log::error('Payment creation failed for booking ' . $request->booking_id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan sistem saat membuat pembayaran. Mohon coba lagi nanti.'], 500);
        }
    }

    /**
     * Menampilkan halaman instruksi pembayaran.
     */
    public function showPaymentInstructions($payment_id)
    {
        $payment = Payment::with('booking.court.venue', 'booking.profilsUser.user')->findOrFail($payment_id);

        // Security: Pastikan pembayaran ini milik user yang sedang login
        if (Auth::id() !== $payment->profilsUser->user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman instruksi pembayaran ini.');
        }

        return view('booking.payment_instructions', compact('payment'));
    }

    /**
     * Menampilkan halaman status booking.
     * Ini bisa menjadi halaman status umum untuk semua booking pengguna.
     */
    public function showBookingStatus($booking_id)
    {
        $booking = Booking::with(['court.venue', 'profilsUser', 'payment'])->findOrFail($booking_id);

        if (Auth::id() !== $booking->profilsUser->user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('booking.status', compact('booking'));
    }
}