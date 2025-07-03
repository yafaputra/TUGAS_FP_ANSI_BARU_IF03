@extends('layout.headfoot')

@section('title', 'Status Booking Anda')

@section('content')
<section class="bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl px-6">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 
                @if ($booking->status === 'pending') bg-yellow-500
                @elseif ($booking->status === 'waiting_payment') bg-blue-500
                @elseif ($booking->status === 'completed') bg-green-600
                @elseif ($booking->status === 'cancelled') bg-red-600
                @else bg-gray-600 @endif">
                <h1 class="text-2xl font-bold text-white text-center">Status Booking Anda</h1>
            </div>

            <div class="p-8">
                <div class="text-center mb-6">
                    @if ($booking->status === 'pending')
                        <p class="text-yellow-700 text-lg font-semibold">Booking Anda berhasil dibuat, mohon segera pilih metode pembayaran.</p>
                        <p class="text-gray-600 text-sm mt-2">Anda dapat memilih metode pembayaran dari halaman sebelumnya atau <a href="{{ route('payment.page', ['booking_id' => $booking->id]) }}" class="text-blue-600 hover:underline font-medium">lanjutkan ke pembayaran di sini</a>.</p>
                    @elseif ($booking->status === 'waiting_payment')
                        <p class="text-blue-700 text-lg font-semibold">Booking Anda sedang menunggu pembayaran.</p>
                        <p class="text-gray-700 mt-2">Mohon selesaikan pembayaran Anda sesuai instruksi.</p>
                        @if ($booking->payment)
                            <p class="text-gray-600 text-sm mt-1">Metode Pembayaran: <span class="font-bold">{{ $booking->payment->payment_method }}</span></p>
                            <p class="text-gray-600 text-sm">Pembayaran berakhir pada: <span class="font-bold">{{ \Carbon\Carbon::parse($booking->payment->expires_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</span></p>
                            <a href="{{ route('payment.instructions', ['payment_id' => $booking->payment->id]) }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Lihat Instruksi Pembayaran
                            </a>
                        @else
                            <p class="text-gray-600 text-sm mt-1">Anda belum memilih metode pembayaran.</p>
                            <a href="{{ route('payment.page', ['booking_id' => $booking->id]) }}" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Pilih Metode Pembayaran
                            </a>
                        @endif
                    @elseif ($booking->status === 'completed')
                        <p class="text-green-700 text-lg font-semibold">Booking Anda berhasil dikonfirmasi!</p>
                        <p class="text-gray-700 mt-2">Terima kasih telah melakukan booking. Detail lapangan Anda:</p>
                    @elseif ($booking->status === 'cancelled')
                        <p class="text-red-700 text-lg font-semibold">Booking Anda telah dibatalkan.</p>
                        <p class="text-gray-700 mt-2">Mohon maaf, booking ini telah dibatalkan atau kadaluarsa.</p>
                    @else
                        <p class="text-gray-700 text-lg font-semibold">Status booking: {{ ucfirst(str_replace('_', ' ', $booking->status)) }}</p>
                    @endif
                </div>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 mb-6 border p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">Booking ID:</p>
                        <p class="ms-2 font-bold">{{ $booking->id }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Lapangan:</p>
                        <p class="ms-2 font-bold">{{ $booking->court->name }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Venue:</p>
                        <p class="ms-2">{{ $booking->court->venue->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Tanggal:</p>
                        <p class="ms-2">{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Waktu:</p>
                        <p class="ms-2">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Durasi:</p>
                        <p class="ms-2">{{ $booking->duration_hours }} jam</p>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Total Harga:</p>
                        <p class="ms-2 text-xl font-extrabold text-emerald-600">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Nama Pemesan:</p>
                        <p class="ms-2">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Nomor Telepon:</p>
                        <p class="ms-2">{{ $booking->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Metode Pembayaran:</p>
                        <p class="ms-2">
                            @if ($booking->payment && $booking->payment->payment_method)
                                {{ $booking->payment->payment_method }}
                            @else
                                Belum dipilih
                            @endif
                        </p>
                    </div>
                </div>

                @if ($booking->payment)
                <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Detail Pembayaran Terakhir</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 mb-6 border p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">ID Transaksi Pembayaran:</p>
                        <p class="ms-2 font-bold">{{ $booking->payment->id }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Metode Pembayaran:</p>
                        <p class="ms-2 font-bold">{{ $booking->payment->payment_method }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Jumlah Pembayaran:</p>
                        <p class="ms-2 font-bold">Rp{{ number_format($booking->payment->amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Status Pembayaran:</p>
                        <p class="ms-2 font-bold 
                            @if ($booking->payment->status === 'pending') text-yellow-600
                            @elseif ($booking->payment->status === 'paid') text-green-600
                            @elseif ($booking->payment->status === 'failed' || $booking->payment->status === 'expired') text-red-600
                            @else text-gray-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $booking->payment->status)) }}
                        </p>
                    </div>
                    @if ($booking->payment->account_name)
                    <div>
                        <p class="font-medium">Nama Akun Tujuan:</p>
                        <p class="ms-2">{{ $booking->payment->account_name }}</p>
                    </div>
                    @endif
                    @if ($booking->payment->account_number)
                    <div>
                        <p class="font-medium">Nomor Rekening/Telepon Tujuan:</p>
                        <p class="ms-2">{{ $booking->payment->account_number }}</p>
                    </div>
                    @endif
                    @if ($booking->payment->payment_code)
                    <div>
                        <p class="font-medium">Kode Pembayaran:</p>
                        <p class="ms-2">{{ $booking->payment->payment_code }}</p>
                    </div>
                    @endif
                    @if ($booking->payment->expires_at)
                    <div>
                        <p class="font-medium">Kadaluarsa Pembayaran:</p>
                        <p class="ms-2">{{ \Carbon\Carbon::parse($booking->payment->expires_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                    </div>
                    @endif
                    @if ($booking->payment->paid_at)
                    <div>qaz
                        <p class="font-medium">Tanggal Dibayar:</p>
                        <p class="ms-2">{{ \Carbon\Carbon::parse($booking->payment->paid_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                    </div>
                    @endif
                </div>
                @endif

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="btn btn-secondary py-2 px-4 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection