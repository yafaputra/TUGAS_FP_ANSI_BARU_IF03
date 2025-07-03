@extends('layout.headfoot')

@section('title', 'Instruksi Pembayaran')

@section('content')
<section class="bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl px-6">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white text-center">Instruksi Pembayaran</h1>
            </div>

            <div class="p-8">
                <div class="mb-6 text-center">
                    <p class="text-lg text-gray-800 font-semibold mb-2">Mohon segera selesaikan pembayaran Anda sebelum:</p>
                    <p class="text-red-600 text-2xl font-bold">{{ \Carbon\Carbon::parse($payment->expires_at)->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                    <p class="text-gray-600 mt-2">Agar booking Anda tidak dibatalkan secara otomatis.</p>
                </div>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Transaksi Pembayaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 mb-6 border p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">Nomor Booking:</p>
                        <p class="ms-2 font-bold">{{ $payment->booking->id }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Total Pembayaran:</p>
                        <p class="ms-2 text-xl font-extrabold text-emerald-600">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="font-medium">Status Pembayaran:</p>
                        <p class="ms-2 font-bold">{{ ucfirst($payment->status) }}</p>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Rekening/Akun Pembayaran</h2>

                <div class="border border-blue-300 rounded-lg p-6 bg-blue-50 mb-6"> {{-- Tambahan border dan background untuk bagian ini --}}
                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Metode Pembayaran:</p>
                        <p class="ms-2 text-2xl font-extrabold text-blue-800">{{ $payment->payment_method }}</p>
                    </div>

                    @if ($payment->account_name)
                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Nama Rekening/Akun:</p>
                        <p class="ms-2 text-xl font-bold text-gray-900">{{ $payment->account_name }}</p>
                        <button onclick="copyToClipboard('{{ $payment->account_name }}')" class="text-blue-500 hover:underline text-sm mt-1">Salin Nama Akun</button>
                    </div>
                    @endif

                    @if ($payment->account_number)
                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Nomor Rekening/Telepon Tujuan:</p>
                        <p class="ms-2 text-xl font-bold text-gray-900">{{ $payment->account_number }}</p>
                        <button onclick="copyToClipboard('{{ $payment->account_number }}')" class="text-blue-500 hover:underline text-sm mt-1">Salin Nomor</button>
                    </div>
                    @endif

                    @if ($payment->payment_code) {{-- Ini opsional, mungkin hanya untuk VA atau kode tertentu --}}
                    <div>
                        <p class="font-medium text-gray-700">Kode Pembayaran (opsional):</p>
                        <p class="ms-2 text-xl font-bold text-gray-900">{{ $payment->payment_code }}</p>
                        <button onclick="copyToClipboard('{{ $payment->payment_code }}')" class="text-blue-500 hover:underline text-sm mt-1">Salin Kode</button>
                    </div>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mt-8 mb-4">Langkah Selanjutnya:</h3>
                <ol class="list-decimal list-inside text-gray-700 space-y-2">
                    <li>Transfer sejumlah <span class="font-bold text-emerald-600">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span> ke detail akun di atas.</li>
                    <li>Pastikan nama pengirim transfer sesuai dengan <span class="font-bold">{{ $payment->booking->customer_name }}</span> agar proses verifikasi lebih cepat.</li>
                    <li>Setelah melakukan pembayaran, status booking akan diperbarui secara otomatis setelah verifikasi (maks. 1x24 jam).</li>
                    <li>Anda bisa melihat status booking kapan saja di halaman riwayat booking Anda.</li>
                </ol>

                <div class="mt-8 text-center">
                    <a href="{{ route('booking.status', ['booking_id' => $payment->booking->id]) }}" class="btn btn-primary py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">Lihat Status Booking Saya</a>
                    <a href="{{ route('home') }}" class="btn btn-secondary py-2 px-4 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg ml-4">Kembali ke Beranda</a>
                </div>
                <p id="copyMessage" class="mt-3 text-center text-sm text-green-600 hidden">Disalin!</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const messageElement = document.getElementById('copyMessage');
            messageElement.classList.remove('hidden');
            setTimeout(() => {
                messageElement.classList.add('hidden');
            }, 2000);
        }).catch(err => {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush
@endsection