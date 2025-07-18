<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use App\Models\ProfilUser;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman form checkout booking.
     */
    public function showCheckoutForm(Request $request)
    {
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

        $court = Court::with('venue')->findOrFail($request->court_id);

        $bookingData = [
            'court_id' => $request->court_id,
            'court_name' => $court->name,
            'venue_name' => $court->venue->name ?? 'N/A',
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_hours' => $request->duration_hours,
            'total_price' => $request->total_price,
            'customer_name' => $profilUser->full_name ?? $user->name,
            'customer_phone' => $profilUser->phone_number ?? '',
        ];

        return view('booking.checkout', compact('bookingData'));
    }

    /**
     * Memproses booking dari form checkout.
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

        try {
            // Parse with proper timezone handling
            $bookingDate = Carbon::createFromFormat('Y-m-d', $request->booking_date, 'Asia/Jakarta');
            $startTime = Carbon::createFromFormat('H:i:s', $request->start_time, 'Asia/Jakarta');
            $endTime = Carbon::createFromFormat('H:i:s', $request->end_time, 'Asia/Jakarta');

            $fullRequestStartTime = $bookingDate->copy()->setTime(
                $startTime->hour,
                $startTime->minute,
                $startTime->second
            );

            $fullRequestEndTime = $bookingDate->copy()->setTime(
                $endTime->hour,
                $endTime->minute,
                $endTime->second
            );

            $now = Carbon::now('Asia/Jakarta');

            if ($bookingDate->isToday() && $fullRequestStartTime->lt($now)) {
                return response()->json(['message' => 'Slot waktu yang Anda pilih sudah lewat waktu saat ini. Silakan pilih jadwal lain.'], 400);
            }

            $isBooked = Booking::where('court_id', $request->court_id)
                ->whereDate('booking_date', $bookingDate->toDateString())
                ->where(function ($query) use ($fullRequestStartTime, $fullRequestEndTime) {
                    $query->where('start_time', '<', $fullRequestEndTime->format('H:i:s'))
                        ->where('end_time', '>', $fullRequestStartTime->format('H:i:s'));
                })
                ->whereNotIn('status', ['cancelled', 'failed'])
                ->exists();

            if ($isBooked) {
                return response()->json(['message' => 'Beberapa slot waktu yang Anda pilih sudah tidak tersedia atau tumpang tindih dengan booking lain. Silakan periksa kembali jadwal.'], 409);
            }

            $booking = new Booking();
            $booking->profils_user_id = $profilUser->id;
            $booking->court_id = $request->court_id;
            $booking->booking_date = $bookingDate->toDateString();
            $booking->start_time = $startTime->toTimeString();
            $booking->end_time = $endTime->toTimeString();
            $booking->duration_hours = $request->duration_hours;
            $booking->customer_name = $request->customer_name;
            $booking->customer_phone = $request->customer_phone;
            $booking->total_price = $request->total_price;
            $booking->status = 'pending';
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
     * Menampilkan halaman pembayaran.
     */
    public function showPaymentPage($booking_id)
    {
        $booking = Booking::with('court.venue', 'profilsUser.user', 'payment')->findOrFail($booking_id);

        if (Auth::id() !== $booking->profilsUser->user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman pembayaran ini.');
        }

        if (in_array($booking->status, ['completed', 'cancelled', 'failed'])) {
            return redirect()->route('dashboard')->with('info', 'Booking ini sudah tidak memerlukan pembayaran.');
        }

        if ($booking->payment && $booking->payment->status !== 'failed' && $booking->payment->status !== 'expired') {
            return redirect()->route('payment.instructions', ['payment_id' => $booking->payment->id])
                             ->with('info', 'Anda sudah memilih metode pembayaran untuk booking ini. Silakan selesaikan pembayaran.');
        }

        return view('booking.payment', compact('booking'));
    }

    /**
     * Memproses pemilihan metode pembayaran.
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

        if ($booking->payment && $booking->payment->status !== 'failed' && $booking->payment->status !== 'expired') {
            return response()->json([
                'message' => 'Metode pembayaran sudah dipilih untuk booking ini.',
                'redirect_url' => route('payment.instructions', ['payment_id' => $booking->payment->id])
            ], 400);
        }

        try {
            $accountName = "Futsal Arena Jaya";
            $accountNumber = "";
            $paymentCode = null;

            switch ($request->payment_method) {
                case 'BCA':
                    $accountNumber = "0987-6543-2109-8765";
                    break;
                case 'BRI':
                    $accountNumber = "1234-5678-9012-3456";
                    break;
                case 'Mandiri':
                    $accountNumber = "7890-1234-5678-9012";
                    break;
                case 'BSI':
                    $accountNumber = "5678-9012-3456-7890";
                    break;
                case 'DANA':
                    $accountName = "Futsal A.J.";
                    $paymentCode = "DANA" . $booking->id . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 'OVO':
                    $accountName = "Futsal A.J.";
                    $paymentCode = "OVO" . $booking->id . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 'ShopeePay':
                    $accountName = "Futsal A.J.";
                    $paymentCode = "SPAY" . $booking->id . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    break;
                case 'GoPay':
                    $accountName = "Futsal A.J.";
                    $paymentCode = "GPAY" . $booking->id . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    break;
            }

            if ($booking->payment) {
                $payment = $booking->payment;
                $payment->update([
                    'amount' => $booking->total_price,
                    'payment_method' => $request->payment_method,
                    'status' => 'pending',
                    'account_name' => $accountName,
                    'account_number' => $accountNumber,
                    'payment_code' => $paymentCode,
                    'expires_at' => Carbon::now('Asia/Jakarta')->addHours(24),
                    'paid_at' => null,
                ]);
            } else {
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'profils_user_id' => $booking->profils_user_id,
                    'amount' => $booking->total_price,
                    'payment_method' => $request->payment_method,
                    'status' => 'pending',
                    'account_name' => $accountName,
                    'account_number' => $accountNumber,
                    'payment_code' => $paymentCode,
                    'expires_at' => Carbon::now('Asia/Jakarta')->addHours(24),
                    'paid_at' => null,
                ]);
            }

            $booking->status = 'waiting_payment';
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

        if (Auth::id() !== $payment->profilsUser->user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman instruksi pembayaran ini.');
        }

        try {
            // Parse with proper error handling
            $bookingDate = Carbon::parse($payment->booking->booking_date, 'Asia/Jakarta');
            $startTime = Carbon::parse($payment->booking->start_time, 'Asia/Jakarta');

            $bookingDateTime = $bookingDate->copy()->setTime(
                $startTime->hour,
                $startTime->minute,
                $startTime->second
            );

            $now = Carbon::now('Asia/Jakarta');

            // Calculate payment deadline (10 minutes before booking time)
            $paymentDeadline = $bookingDateTime->copy()->subMinutes(10);

            // If booking is within 10 minutes, set deadline to now + 10 minutes
            if ($now->diffInMinutes($bookingDateTime, false) < 10) {
                $paymentDeadline = $now->copy()->addMinutes(10);
            }

            // If booking time has passed
            if ($bookingDateTime->isPast()) {
                $paymentDeadline = $bookingDateTime;
            }

            return view('booking.payment_instructions', [
                'payment' => $payment,
                'paymentDeadline' => $paymentDeadline,
                'bookingDateTime' => $bookingDateTime
            ]);

        } catch (\Exception $e) {
            Log::error('Error in showPaymentInstructions: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan dalam memproses waktu booking. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman status booking.
     */
    public function showBookingStatus($booking_id)
    {
        $booking = Booking::with(['court.venue', 'profilsUser', 'payment'])->findOrFail($booking_id);

        if (Auth::id() !== $booking->profilsUser->user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('booking.status', compact('booking'));
    }

    /**
     * Membatalkan booking.
     */
    public function cancelBooking(Request $request, Booking $booking)
    {
        if (!Auth::check() || Auth::id() !== $booking->profilsUser->user_id) {
            return response()->json(['success' => false, 'message' => 'Tindakan tidak sah.'], 403);
        }

        if (in_array($booking->status, ['completed', 'cancelled', 'failed'])) {
            return response()->json(['success' => false, 'message' => 'Booking tidak dapat dibatalkan dari status ' . $booking->status . '.'], 400);
        }

        try {
            $booking->status = 'cancelled';
            $booking->save();

            if ($booking->payment) {
                $booking->payment->update(['status' => 'failed', 'paid_at' => null]);
            } else {
                Payment::create([
                    'booking_id' => $booking->id,
                    'profils_user_id' => $booking->profils_user_id,
                    'amount' => $booking->total_price,
                    'payment_method' => 'N/A (Canceled by User)',
                    'status' => 'failed',
                    'expires_at' => null,
                    'paid_at' => null,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Booking berhasil dibatalkan.']);
        } catch (\Exception $e) {
            Log::error('Failed to cancel booking ' . $booking->id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat membatalkan booking.'], 500);
        }
    }

    /**
     * Menyelesaikan booking.
     */
    public function completeBooking(Request $request, Booking $booking)
    {
        if (!Auth::check() || Auth::id() !== $booking->profilsUser->user_id) {
            return response()->json(['success' => false, 'message' => 'Tindakan tidak sah.'], 403);
        }

        if (in_array($booking->status, ['completed', 'cancelled', 'failed'])) {
            return response()->json(['success' => false, 'message' => 'Booking tidak dapat diselesaikan dari status ' . $booking->status . '.'], 400);
        }

        try {
            if ($booking->status !== 'awaiting_confirmation') {
                $booking->status = 'awaiting_confirmation';
                $booking->save();
                return response()->json(['success' => true, 'message' => 'Permintaan penyelesaian booking telah dikirim. Admin akan memverifikasi.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Booking sudah menunggu konfirmasi penyelesaian.']);
            }

        } catch (\Exception $e) {
            Log::error('Failed to complete booking ' . $booking->id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyelesaikan booking.'], 500);
        }
    }

    /**
     * Dashboard pengguna.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $profilUser = $user->profil;

        if (!$profilUser) {
            return redirect()->route('profil.index')->with('warning', 'Mohon lengkapi profil Anda terlebih dahulu.');
        }

        $activeBookings = Booking::where('profils_user_id', $profilUser->id)
                                 ->whereIn('status', ['pending', 'awaiting_confirmation', 'waiting_payment'])
                                 ->orderBy('booking_date', 'asc')
                                 ->orderBy('start_time', 'asc')
                                 ->get();

        $historyBookings = Booking::where('profils_user_id', $profilUser->id)
                                  ->whereIn('status', ['completed', 'cancelled', 'failed'])
                                  ->orderBy('booking_date', 'desc')
                                  ->orderBy('start_time', 'desc')
                                  ->get();

        return view('dashboard-pengguna', compact('user', 'profilUser', 'activeBookings', 'historyBookings'));
    }
}
