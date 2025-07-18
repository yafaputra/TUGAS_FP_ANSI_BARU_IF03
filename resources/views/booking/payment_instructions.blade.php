@extends('layout.headfoot')

@section('title', 'Instruksi Pembayaran')

@section('content')
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <div class="container mx-auto max-w-4xl px-6">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-6">
                <div class="flex items-center justify-center">
                    <div class="bg-white/20 rounded-xl p-3 mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Instruksi Pembayaran</h1>
                </div>
            </div>

            <div class="p-6">
                @php
                    $bookingDate = \Carbon\Carbon::parse($payment->booking->booking_date)->format('Y-m-d');
                    $startTime = \Carbon\Carbon::parse($payment->booking->start_time)->format('H:i:s');
                    $bookingDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate . ' ' . $startTime, 'Asia/Jakarta');

                    // Calculate payment deadline (10 minutes before booking time)
                    $paymentDeadline = $bookingDateTime->copy()->subMinutes(10);

                    // If deadline is in past (for last-minute bookings), set to now + 10 minutes
                    if ($paymentDeadline->isPast()) {
                        $paymentDeadline = now('Asia/Jakarta')->addMinutes(10);
                    }
                @endphp

                <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-lg font-semibold text-gray-800">Batas Waktu Pembayaran</p>
        </div>
        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Penting
        </span>
    </div>
    <div class="bg-white rounded-lg p-4 mb-3 border border-red-100">
        @if($bookingDateTime->isPast())
            <p class="text-red-600 text-xl font-bold text-center">Waktu booking sudah lewat</p>
        @else
            <p class="text-red-600 text-xl font-bold text-center">
                {{ $paymentDeadline->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
            </p>
            <div id="countdown" class="text-red-500 text-lg font-bold mt-2 text-center"></div>
        @endif
    </div>
    <p class="text-sm text-gray-600 text-center">
        Booking Anda: {{ $bookingDateTime->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB
    </p>
</div>


                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Detail Transaksi
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                            <p class="text-xl font-bold text-green-800">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-sm text-gray-600 mb-1">Kode Booking</p>
                            <p class="text-xl font-bold text-blue-800">#{{ str_pad($payment->booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                            <p class="text-sm text-gray-600 mb-1">Status Pembayaran</p>
                            <p class="text-xl font-bold text-purple-800 capitalize">{{ $payment->status }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Detail Pembayaran
                    </h2>

                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Metode: {{ $payment->payment_method }}
                        </h3>

                        <div class="space-y-4">
                            @if ($payment->account_name)
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Nama Rekening</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-gray-800 text-lg">{{ $payment->account_name }}</p>
                                    <button onclick="copyToClipboard('{{ $payment->account_name }}')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            </div>
                            @endif

                            @if ($payment->account_number)
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Nomor Rekening</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-gray-800 text-lg">{{ $payment->account_number }}</p>
                                    <button onclick="copyToClipboard('{{ $payment->account_number }}')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            </div>
                            @endif

                            @if ($payment->payment_code)
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Kode Pembayaran</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-gray-800 text-lg">{{ $payment->payment_code }}</p>
                                    <button onclick="copyToClipboard('{{ $payment->payment_code }}')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            </div>
                            @endif

                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Jumlah Transfer</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-gray-800 text-lg">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    <button onclick="copyToClipboard('{{ number_format($payment->amount, 0, '', '') }}')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Langkah Pembayaran
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 mt-1 flex-shrink-0">1</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Transfer sesuai jumlah pembayaran</p>
                                    <p class="text-gray-600 mt-1">Transfer tepat <strong>Rp{{ number_format($payment->amount, 0, ',', '.') }}</strong> ke rekening tujuan di atas.</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 mt-1 flex-shrink-0">2</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Gunakan nama sesuai booking</p>
                                    <p class="text-gray-600 mt-1">Pastikan nama pengirim sesuai dengan nama pemesan: <strong>{{ $payment->booking->customer_name }}</strong>.</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 mt-1 flex-shrink-0">3</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Simpan bukti transfer</p>
                                    <p class="text-gray-600 mt-1">Simpan screenshot/slip transfer sebagai bukti pembayaran.</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 mt-1 flex-shrink-0">4</div>
                                <div>
                                    <p class="font-semibold text-gray-800">Tunggu konfirmasi</p>
                                    <p class="text-gray-600 mt-1">Status booking akan diperbarui otomatis setelah pembayaran diverifikasi (biasanya dalam 1-5 menit).</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-blue-800 font-medium">Penting!</p>
                                    <p class="text-blue-700 text-sm mt-1">
                                        Pembayaran harus dilakukan sebelum batas waktu yang ditentukan (10 menit sebelum waktu booking). Jika sudah melewati batas waktu, booking Anda akan otomatis dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('booking.status', ['booking_id' => $payment->booking->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg text-center transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Lihat Status Booking
                    </a>
                    <a href="{{ route('home') }}" class="bg-white hover:bg-gray-50 text-gray-800 font-medium py-3 px-6 rounded-lg text-center transition-colors border border-gray-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="copyMessage" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50 flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span>Berhasil disalin!</span>
</div>

@push('scripts')
<script>
    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const messageElement = document.getElementById('copyMessage');
            messageElement.classList.remove('translate-x-full');
            messageElement.classList.add('translate-x-0');

            setTimeout(() => {
                messageElement.classList.remove('translate-x-0');
                messageElement.classList.add('translate-x-full');
            }, 2000);
        }).catch(err => {
            console.error('Could not copy text: ', err);
        });
    }

    // Countdown timer
    // Countdown timer
// Countdown timer
function startCountdown() {
    const paymentDeadlineStr = '{{ $paymentDeadline->format("Y-m-d H:i:s") }}';
    const bookingDateTimeStr = '{{ $bookingDateTime->format("Y-m-d H:i:s") }}';

    // Parse dengan timezone Asia/Jakarta
    const paymentDeadline = new Date(paymentDeadlineStr + ' GMT+0700');
    const bookingDateTime = new Date(bookingDateTimeStr + ' GMT+0700');
    const now = new Date();

    // Jika waktu booking sudah lewat
    if (bookingDateTime < now) {
        document.getElementById('countdown').innerHTML =
            '<span class="text-red-600 font-bold">Waktu booking sudah lewat</span>';
        return;
    }

    const timer = setInterval(() => {
        const now = new Date();
        const timeLeft = paymentDeadline - now;

        // Jika waktu pembayaran sudah lewat
        if (timeLeft <= 0) {
            clearInterval(timer);
            document.getElementById('countdown').innerHTML =
                '<span class="text-red-600 font-bold">Waktu pembayaran telah habis</span>';
            return;
        }

        const hours = Math.floor(timeLeft / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        let countdownText = '';
        if (hours > 0) countdownText += `${hours} jam `;
        countdownText += `${minutes} menit ${seconds} detik`;

        const countdownElement = document.getElementById('countdown');

        // Warna berbeda berdasarkan waktu tersisa
        if (timeLeft < 5 * 60 * 1000) { // Kurang dari 5 menit
            countdownElement.className = 'text-red-600 text-lg font-bold mt-2 animate-pulse text-center';
        } else if (timeLeft < 30 * 60 * 1000) { // Kurang dari 30 menit
            countdownElement.className = 'text-orange-500 text-lg font-bold mt-2 text-center';
        } else {
            countdownElement.className = 'text-blue-600 text-lg font-bold mt-2 text-center';
        }

        countdownElement.innerHTML = countdownText;
    }, 1000);
}

// Jalankan countdown saat halaman dimuat
document.addEventListener('DOMContentLoaded', startCountdown);
    // Start the countdown when page loads
    document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endpush
@endsection
