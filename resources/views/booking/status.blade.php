@extends('layout.headfoot')

@section('title', 'Status Booking')

@section('content')
<section class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl px-4">

        <!-- Status Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="px-6 py-8 text-center
                @if ($booking->status === 'pending') bg-yellow-500
                @elseif ($booking->status === 'waiting_payment') bg-blue-500
                @elseif ($booking->status === 'completed') bg-green-500
                @elseif ($booking->status === 'cancelled') bg-red-500
                @else bg-gray-500 @endif">

                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    @if ($booking->status === 'pending')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @elseif ($booking->status === 'waiting_payment')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    @elseif ($booking->status === 'completed')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @elseif ($booking->status === 'cancelled')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>

                <h1 class="text-2xl font-bold text-white mb-2">
                    @if ($booking->status === 'pending') Menunggu Pembayaran
                    @elseif ($booking->status === 'waiting_payment') Menunggu Konfirmasi
                    @elseif ($booking->status === 'completed') Booking Berhasil
                    @elseif ($booking->status === 'cancelled') Booking Dibatalkan
                    @else Status Booking @endif
                </h1>
                <p class="text-white/80">ID: {{ $booking->id }}</p>
            </div>

            <div class="px-6 py-4 bg-gray-50 text-center">
                @if ($booking->status === 'pending')
                    <p class="text-gray-700">Silakan pilih metode pembayaran untuk melanjutkan</p>
                @elseif ($booking->status === 'waiting_payment')
                    <p class="text-gray-700">Selesaikan pembayaran sesuai instruksi</p>
                @elseif ($booking->status === 'completed')
                    <p class="text-gray-700">Terima kasih! Silakan datang sesuai jadwal</p>
                @elseif ($booking->status === 'cancelled')
                    <p class="text-gray-700">Booking telah dibatalkan atau kadaluarsa</p>
                @endif
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Booking</h2>

            <div class="space-y-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-1">{{ $booking->court->name }}</h3>
                    <p class="text-blue-700 text-sm">{{ $booking->court->venue->name ?? 'N/A' }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Tanggal</label>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMM Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Waktu</label>
                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Nama Pemesan</label>
                        <p class="font-semibold text-gray-900">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">No. Telepon</label>
                        <p class="font-semibold text-gray-900">{{ $booking->customer_phone }}</p>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <label class="text-sm text-green-700">Total Pembayaran</label>
                    <p class="text-2xl font-bold text-green-900">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        @if ($booking->payment)
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pembayaran</h2>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Status</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if ($booking->payment->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif ($booking->payment->status === 'paid') bg-green-100 text-green-800
                        @elseif ($booking->payment->status === 'failed' || $booking->payment->status === 'expired') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $booking->payment->status)) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Metode</span>
                    <span class="font-semibold text-gray-900">{{ $booking->payment->payment_method }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah</span>
                    <span class="font-semibold text-gray-900">Rp{{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                </div>

                @if ($booking->payment->payment_code)
                <div class="bg-blue-50 rounded-lg p-3">
                    <label class="text-sm text-blue-700">Kode Pembayaran</label>
                    <p class="text-lg font-mono text-blue-900">{{ $booking->payment->payment_code }}</p>
                </div>
                @endif

                @if ($booking->payment->expires_at)
                <div class="bg-red-50 rounded-lg p-3">
                    <label class="text-sm text-red-700">Batas Waktu</label>
                    <p class="font-semibold text-red-900">{{ \Carbon\Carbon::parse($booking->payment->expires_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                </div>
                @endif

                @if ($booking->payment->paid_at)
                <div class="bg-green-50 rounded-lg p-3">
                    <label class="text-sm text-green-700">Dibayar pada</label>
                    <p class="font-semibold text-green-900">{{ \Carbon\Carbon::parse($booking->payment->paid_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @if ($booking->status === 'pending')
                <a href="{{ route('payment.page', ['booking_id' => $booking->id]) }}"
                   class="px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition-colors text-center">
                    Pilih Metode Pembayaran
                </a>
            @elseif ($booking->status === 'waiting_payment' && $booking->payment)
                <a href="{{ route('payment.instructions', ['payment_id' => $booking->payment->id]) }}"
                   class="px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition-colors text-center">
                    Lihat Instruksi Pembayaran
                </a>
            @endif

            <a href="{{ route('home') }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors text-center">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
