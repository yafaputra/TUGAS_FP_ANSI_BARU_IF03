@extends('layout.headfoot')

@section('title', 'Status Pembayaran Booking Anda')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12">
    <div class="container mx-auto max-w-4xl px-6">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100 mb-8">
            <div class="relative px-8 py-8 text-center
                @if ($booking->status === 'pending') bg-gradient-to-r from-yellow-400 to-orange-500
                @elseif ($booking->status === 'waiting_payment') bg-gradient-to-r from-blue-500 to-cyan-600
                @elseif ($booking->status === 'completed') bg-gradient-to-r from-green-500 to-emerald-600
                @elseif ($booking->status === 'cancelled') bg-gradient-to-r from-red-500 to-rose-600
                @else bg-gradient-to-r from-gray-500 to-slate-600 @endif">

                <div class="flex justify-center mb-4">
                    @if ($booking->status === 'pending')
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @elseif ($booking->status === 'waiting_payment')
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    @elseif ($booking->status === 'completed')
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @elseif ($booking->status === 'cancelled')
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @else
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <h1 class="text-3xl font-bold text-white mb-2">Status Pembayaran Booking Anda</h1>
                <p class="text-white/90 text-lg">ID Booking: <span class="font-semibold">{{ $booking->id }}</span></p>

                <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 bg-white/10 rounded-full translate-x-12 translate-y-12"></div>
            </div>

            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white">
                <div class="text-center">
                    @if ($booking->status === 'pending')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium mb-4">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Menunggu Pembayaran
                        </div>
                        <p class="text-gray-700 text-lg font-medium mb-2">Booking berhasil dibuat! Silakan pilih metode pembayaran.</p>
                        <p class="text-gray-600 text-sm">
                            <a href="{{ route('payment.page', ['booking_id' => $booking->id]) }}" class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition-colors">
                                Lanjutkan ke pembayaran →
                            </a>
                        </p>
                    @elseif ($booking->status === 'waiting_payment')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium mb-4">
                            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menunggu Konfirmasi Pembayaran
                        </div>
                        <p class="text-gray-700 text-lg font-medium mb-2">Mohon selesaikan pembayaran sesuai instruksi.</p>
                        @if ($booking->payment)
                            <div class="bg-blue-50 rounded-lg p-4 mt-4">
                                <p class="text-blue-800 font-medium">Metode: {{ $booking->payment->payment_method }}</p>
                                <p class="text-blue-600 text-sm mt-1">Berakhir: {{ \Carbon\Carbon::parse($booking->payment->expires_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                            </div>
                        @endif
                    @elseif ($booking->status === 'completed')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-medium mb-4">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Berhasil Dikonfirmasi
                        </div>
                        <p class="text-gray-700 text-lg font-medium mb-2">Booking berhasil! Terima kasih telah melakukan pemesanan.</p>
                        <p class="text-gray-600 text-sm">Silakan datang sesuai jadwal yang telah ditentukan</p>
                    @elseif ($booking->status === 'cancelled')
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-medium mb-4">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Dibatalkan
                        </div>
                        <p class="text-gray-700 text-lg font-medium mb-2">Booking telah dibatalkan</p>
                        <p class="text-gray-600 text-sm">Mohon maaf, booking ini telah dibatalkan atau kadaluarsa</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Detail Booking
                    </h2>
                </div>

                <div class="p-6 space-y-4">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="font-semibold text-blue-900">{{ $booking->court->name }}</h3>
                        </div>
                        <p class="text-blue-700 text-sm">{{ $booking->court->venue->name ?? 'N/A' }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-green-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-green-800 font-medium text-sm">Tanggal</span>
                            </div>
                            <p class="text-green-900 font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMM Y') }}</p>
                        </div>

                        <div class="bg-orange-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-orange-800 font-medium text-sm">Waktu</span>
                            </div>
                            <p class="text-orange-900 font-semibold">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                            <p class="text-orange-700 text-sm">{{ $booking->duration_hours }} jam</p>
                        </div>
                    </div>

                    <div class="bg-purple-50 rounded-xl p-4">
                        <h4 class="font-semibold text-purple-900 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Pemesan
                        </h4>
                        <div class="space-y-2">
                            <p class="text-purple-800"><span class="font-medium">Nama:</span> {{ $booking->customer_name }}</p>
                            <p class="text-purple-800"><span class="font-medium">Telepon:</span> {{ $booking->customer_phone }}</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-emerald-400 to-green-500 rounded-xl p-4 text-center">
                        <p class="text-white text-sm font-medium mb-1">Total Pembayaran</p>
                        <p class="text-white text-2xl font-bold">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            @if ($booking->payment)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Detail Pembayaran
                    </h2>
                </div>

                <div class="p-6 space-y-4">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                            @if ($booking->payment->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif ($booking->payment->status === 'paid') bg-green-100 text-green-800
                            @elseif ($booking->payment->status === 'failed' || $booking->payment->status === 'expired') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $booking->payment->status)) }}
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Metode Pembayaran</p>
                                <p class="text-gray-900 font-semibold">{{ $booking->payment->payment_method }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-600 text-sm">ID Transaksi</p>
                                <p class="text-gray-900 font-mono text-sm">{{ $booking->payment->id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4">
                        <p class="text-green-700 text-sm font-medium">Jumlah Pembayaran</p>
                        <p class="text-green-900 text-xl font-bold">Rp{{ number_format($booking->payment->amount, 0, ',', '.') }}</p>
                    </div>

                    <div class="space-y-3">
                        @if ($booking->payment->account_name)
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">Nama Akun</span>
                            <span class="text-gray-900 font-medium">{{ $booking->payment->account_name }}</span>
                        </div>
                        @endif

                        @if ($booking->payment->account_number)
                        <div class="flex justify-between">
                            <span class="text-gray-600 text-sm">No. Rekening</span>
                            <span class="text-gray-900 font-mono">{{ $booking->payment->account_number }}</span>
                        </div>
                        @endif

                        @if ($booking->payment->payment_code)
                        <div class="bg-blue-50 rounded-lg p-3">
                            <p class="text-blue-700 text-sm font-medium">Kode Pembayaran</p>
                            <p class="text-blue-900 font-mono text-lg">{{ $booking->payment->payment_code }}</p>
                        </div>
                        @endif

                        @if ($booking->payment->expires_at)
                        <div class="bg-red-50 rounded-lg p-3">
                            <p class="text-red-700 text-sm font-medium">Kadaluarsa</p>
                            <p class="text-red-900 font-semibold">{{ \Carbon\Carbon::parse($booking->payment->expires_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                        </div>
                        @endif

                        @if ($booking->payment->paid_at)
                        <div class="bg-green-50 rounded-lg p-3">
                            <p class="text-green-700 text-sm font-medium">Dibayar pada</p>
                            <p class="text-green-900 font-semibold">{{ \Carbon\Carbon::parse($booking->payment->paid_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            @if ($booking->status === 'pending')
                <a href="{{ route('payment.page', ['booking_id' => $booking->id]) }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Pilih Metode Pembayaran
                </a>
            @elseif ($booking->status === 'waiting_payment' && $booking->payment)
                <a href="{{ route('payment.instructions', ['payment_id' => $booking->payment->id]) }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Instruksi Pembayaran
                </a>
            @endif

            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endsection
