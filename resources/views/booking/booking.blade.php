@extends('layout.headfoot')

@section('title', 'Pembayaran Booking')

@section('content')
<div class="container mx-auto max-w-2xl px-6 py-12">
    <div class="bg-white rounded-lg shadow-xl p-8 border border-emerald-200">
        <h1 class="text-3xl font-bold text-emerald-700 mb-6 text-center">Konfirmasi & Pembayaran</h1>

        <div class="mb-8 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Detail Booking Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                <div>
                    <p><strong>Venue:</strong> {{ $booking->court->venue->name }}</p>
                    <p><strong>Lapangan:</strong> {{ $booking->court->name }}</p>
                    <p><strong>Jenis:</strong> {{ $booking->court->type }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                    <p><strong>Durasi:</strong> {{ $booking->duration_hours }} Jam</p>
                    <p><strong>Nama Pemesan:</strong> {{ $booking->customer_name }}</p>
                    <p><strong>No. Telepon:</strong> {{ $booking->customer_phone }}</p>
                </div>
            </div>
        </div>

        <div class="text-center mb-8">
            <p class="text-2xl font-bold text-emerald-800">Total Pembayaran: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
        </div>

        <div class="payment-methods">
            <h2 class="text-xl font-semibold text-gray-800 mb-3 text-center">Pilih Metode Pembayaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-6 rounded-lg shadow flex items-center justify-center gap-3">
                    <i class="bi bi-wallet text-2xl"></i> Pembayaran Online 
                </button>
                <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-lg shadow flex items-center justify-center gap-3">
                    <i class="bi bi-bank text-2xl"></i> Transfer Bank Manual
                </button>
            </div>
            <p class="text-center text-gray-500 text-sm mt-4">Anda akan diarahkan ke halaman pembayaran setelah memilih metode.</p>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('venues.show', $booking->court->venue->id) }}" class="text-emerald-600 hover:text-emerald-800 text-sm">Kembali ke halaman venue</a>
        </div>
    </div>
</div>
@endsection