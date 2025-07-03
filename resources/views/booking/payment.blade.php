@extends('layout.headfoot')

@section('title', 'Pilih Metode Pembayaran')

@section('content')
<section class="bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl px-6" x-data="paymentPage()">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white text-center">Pilih Metode Pembayaran</h1>
            </div>

            <div class="p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Booking Anda</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 mb-6 border p-4 rounded-lg bg-gray-50">
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
                </div>

                <hr class="my-8 border-gray-200">

                <h2 class="text-xl font-semibold text-gray-800 mb-4">Metode Pembayaran</h2>
                <form @submit.prevent="processPayment()">
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div class="mb-4">
                        <label for="paymentMethod" class="block text-sm font-medium text-gray-700 mb-1">Pilih Metode Pembayaran</label>
                        <select id="paymentMethod" x-model="paymentMethod"
                            class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <optgroup label="Transfer Bank">
                                <option value="BRI">Bank BRI</option>
                                <option value="BCA">Bank BCA</option>
                                <option value="Mandiri">Bank Mandiri</option>
                                <option value="BSI">Bank BSI</option>
                            </optgroup>
                            <optgroup label="E-Wallet">
                                <option value="DANA">DANA</option>
                                <option value="OVO">OVO</option>
                                <option value="ShopeePay">ShopeePay</option>
                                <option value="GoPay">GoPay</option>
                            </optgroup>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-full font-bold py-3 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-lg flex items-center justify-center transition-colors"
                        :disabled="!paymentMethod">
                        <i class="bi bi-credit-card-fill me-2"></i>Konfirmasi Pembayaran
                    </button>
                    <p x-show="paymentMessage" x-text="paymentMessage" :class="paymentSuccess ? 'text-green-600' : 'text-red-600'" class="mt-3 text-center"></p>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    function paymentPage() {
        return {
            bookingId: {{ $booking->id }},
            paymentMethod: '',
            paymentMessage: '',
            paymentSuccess: false,

            async processPayment() {
                this.paymentMessage = 'Memproses pembayaran...';
                this.paymentSuccess = false;

                try {
                    const response = await fetch('{{ route('payment.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            booking_id: this.bookingId,
                            payment_method: this.paymentMethod
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.paymentMessage = data.message;
                        this.paymentSuccess = true;
                        // Redirect to the new payment instructions page
                        if (data.redirect_url) {
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 1500);
                        }
                    } else {
                        this.paymentMessage = data.message || 'Pembayaran gagal. Silakan coba lagi.';
                        this.paymentSuccess = false;
                    }
                } catch (error) {
                    console.error('Error during payment processing:', error);
                    this.paymentMessage = 'Terjadi kesalahan sistem. Mohon coba lagi nanti.';
                    this.paymentSuccess = false;
                }
            }
        }
    }
</script>
@endpush
@endsection


