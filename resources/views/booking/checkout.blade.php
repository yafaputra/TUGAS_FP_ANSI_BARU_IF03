@extends('layout.headfoot')

@section('title', 'Detail Booking & Pembayaran')

@section('content')
<section class="bg-gray-50 py-8">
    <div class="container mx-auto max-w-3xl px-6" x-data="checkoutPage()">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-green-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white text-center">Lengkapi Detail Booking</h1>
            </div>

            <div class="p-8">
                {{-- Ringkasan Booking --}}
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 mb-6 border p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">Lapangan:</p>
                        <p class="ms-2 font-bold" x-text="bookingData.court_name"></p>
                    </div>
                    <div>
                        <p class="font-medium">Venue:</p>
                        <p class="ms-2" x-text="bookingData.venue_name"></p>
                    </div>
                    <div>
                        <p class="font-medium">Tanggal:</p>
                        <p class="ms-2" x-text="formatDate(bookingData.booking_date)"></p>
                    </div>
                    <div>
                        <p class="font-medium">Waktu:</p>
                        <p class="ms-2" x-text="formatTimeRange(bookingData.start_time, bookingData.end_time)"></p>
                    </div>
                    <div>
                        <p class="font-medium">Durasi:</p>
                        <p class="ms-2" x-text="bookingData.duration_hours + ' jam'"></p>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Total Harga:</p>
                        <p class="ms-2 text-xl font-extrabold text-emerald-600" x-text="formatPrice(bookingData.total_price)"></p>
                    </div>
                </div>

                <hr class="my-8 border-gray-200">

                {{-- Form Detail Pemesan --}}
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pemesan</h2>
                <form @submit.prevent="submitBooking()">
                    <input type="hidden" name="court_id" :value="bookingData.court_id">
                    <input type="hidden" name="booking_date" :value="bookingData.booking_date">
                    <input type="hidden" name="start_time" :value="bookingData.start_time">
                    <input type="hidden" name="end_time" :value="bookingData.end_time">
                    <input type="hidden" name="duration_hours" :value="bookingData.duration_hours">
                    <input type="hidden" name="total_price" :value="bookingData.total_price">

                    <div class="mb-4">
                        <label for="customerName" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="customerName" x-model="customerName"
                            class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                            placeholder="Masukkan nama Anda" required>
                    </div>

                    <div class="mb-4">
                        <label for="customerPhone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="tel" id="customerPhone" x-model="customerPhone"
                            class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50"
                            placeholder="Cth: 08123456789" required>
                    </div>

                    {{-- Metode Pembayaran akan dipindahkan ke halaman terpisah --}}
                    {{-- <div class="mb-4">
                        <label for="paymentMethod" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                        <select id="paymentMethod" x-model="paymentMethod"
                            class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50" required>
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
                    </div> --}}

                    <button type="submit" class="btn btn-success w-full font-bold py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-lg flex items-center justify-center transition-colors"
                        :disabled="!customerName || !customerPhone"> {{-- Menghapus !paymentMethod dari disabled --}}
                        <i class="bi bi-wallet-fill me-2"></i>Lanjutkan ke Pembayaran
                    </button>
                    <p x-show="bookingMessage" x-text="bookingMessage" :class="bookingSuccess ? 'text-green-600' : 'text-red-600'" class="mt-3 text-center"></p>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    function checkoutPage() {
        return {
            bookingData: @json($bookingData ?? []),
            customerName: '',
            customerPhone: '',
            // paymentMethod: '', // <--- Hapus ini
            bookingMessage: '',
            bookingSuccess: false,

            init() {
                @auth
                    this.customerName = '{{ Auth::user()->profil->full_name ?? Auth::user()->name ?? '' }}';
                    this.customerPhone = '{{ Auth::user()->profil->phone_number ?? '' }}';
                @endauth
            },

            formatDate(dateString) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            },

            formatTimeRange(startTime, endTime) {
                return `${startTime.substring(0, 5)} - ${endTime.substring(0, 5)}`;
            },

            formatPrice(price) {
                return new Intl.NumberFormat('id-ID').format(price || 0);
            },

            async submitBooking() {
                this.bookingMessage = 'Memproses booking...';
                this.bookingSuccess = false;

                try {
                    const response = await fetch('{{ route('booking.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            court_id: this.bookingData.court_id,
                            booking_date: this.bookingData.booking_date,
                            start_time: this.bookingData.start_time,
                            end_time: this.bookingData.end_time,
                            duration_hours: this.bookingData.duration_hours,
                            customer_name: this.customerName,
                            customer_phone: this.customerPhone,
                            total_price: this.bookingData.total_price,
                            // payment_method: this.paymentMethod // <--- Hapus ini
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.bookingMessage = data.message;
                        this.bookingSuccess = true;

                        if (data.redirect_url) {
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 1500);
                        }
                    } else {
                        this.bookingMessage = data.message || 'Booking gagal. Silakan coba lagi.';
                        this.bookingSuccess = false;
                    }
                } catch (error) {
                    console.error('Error during booking:', error);
                    this.bookingMessage = 'Terjadi kesalahan sistem. Mohon coba lagi nanti.';
                    this.bookingSuccess = false;
                }
            }
        }
    }
</script>
@endpush
@endsection