@extends('layout.headfoot')

@section('title', 'Detail Booking & Pembayaran')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    /* Core simplification: white background, subtle shadows */
    body {
        background-color: #f8f8f8; /* Light gray to provide a subtle break from pure white content */
    }

    .card-simple {
        background-color: #ffffff;
        border-radius: 1rem; /* Adjust as needed, 16px */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Soft, subtle shadow */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card-simple:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Input field simplification */
    .input-simple {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem; /* 8px */
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .input-simple:focus {
        border-color: #3b82f6; /* Blue-500 for focus, can be your primary brand color */
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); /* Soft focus ring */
    }

    /* Button simplification */
    .btn-primary-simple {
        background-color: #3b82f6; /* A clean blue, or your brand's primary color */
        color: #ffffff;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        border: none;
        cursor: pointer;
    }

    .btn-primary-simple:hover {
        background-color: #2563eb; /* Darker blue on hover */
        transform: translateY(-1px);
    }

    .btn-primary-simple:disabled {
        background-color: #cbd5e1; /* Gray-300 for disabled */
        cursor: not-allowed;
    }

    /* Progress bar simplification */
    .progress-step-simple {
        width: 4rem; /* 64px */
        height: 4rem; /* 64px */
        background-color: #e0e0e0;
        color: #6b7280; /* Gray-500 */
        border-radius: 9999px; /* Full circle */
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .progress-step-simple.active {
        background-color: #10b981; /* Emerald-500 */
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); /* Subtle glow */
    }

    .progress-connector-simple {
        height: 4px;
        background-color: #e0e0e0;
        border-radius: 9999px;
        flex-grow: 1;
        margin: 0 1rem;
    }

    .progress-connector-simple.active {
        background-color: #10b981; /* Emerald-500 */
    }

    /* Text colors */
    .text-primary {
        color: #1f2937; /* Gray-900 for main text */
    }

    .text-secondary {
        color: #6b7280; /* Gray-500 for secondary text */
    }

    /* No floating or neon glow animations for simplification */
    .floating-element, .neon-glow, .success-animation {
        animation: none !important;
        box-shadow: none !important;
    }

    /* Specific element adjustments for simpler look */
    .header-section {
        background-color: #ffffff; /* Or keep a very subtle background for depth */
        padding: 2rem 0;
        text-align: center;
    }

    .header-section h1 {
        color: #1f2937; /* Dark text for header */
        font-size: 3rem;
    }

    .header-section p {
        color: #6b7280;
        font-size: 1.125rem;
    }

    .summary-header {
        background-color: #f3f4f6; /* Light gray for header of summary card */
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem;
        display: flex;
        align-items: center;
    }

    .summary-header i {
        color: #3b82f6; /* Blue icon */
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px dashed #e5e7eb;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .total-price-section {
        background-color: #eff6ff; /* Light blue background for total price */
        border-top: 1px solid #dbeafe;
        padding: 1.5rem;
        border-radius: 0 0 1rem 1rem; /* Rounded bottom corners */
    }

    .icon-box {
        background-color: #e0f2fe; /* Very light blue for icons in summary */
        color: #3b82f6;
        width: 3rem;
        height: 3rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

</style>
@endpush

@section('content')
<section class="min-h-screen bg-gray-100 py-16">
    <div class="container mx-auto max-w-7xl px-6" x-data="checkoutPage()">
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Checkout Pemesanan</h1>
            <p class="text-lg text-gray-600">Pastikan semua informasi sudah benar sebelum melanjutkan pembayaran</p>
        </div>  
        

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2">
                <div class="card-simple">
                    <div class="bg-gray-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-800 mb-2">Informasi Pemesan</h2>
                                <p class="text-gray-600">Pastikan data yang Anda masukkan sudah benar</p>
                            </div>
                            <div class="hidden md:block">
                                <div class="icon-box bg-blue-100 text-blue-600">
                                    <i class="bi bi-person-badge text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <form @submit.prevent="submitBooking()" class="space-y-8">
                            <input type="hidden" name="court_id" :value="bookingData.court_id">
                            <input type="hidden" name="booking_date" :value="bookingData.booking_date">
                            <input type="hidden" name="start_time" :value="bookingData.start_time">
                            <input type="hidden" name="end_time" :value="bookingData.end_time">
                            <input type="hidden" name="duration_hours" :value="bookingData.duration_hours">
                            <input type="hidden" name="total_price" :value="bookingData.total_price">

                            <div>
                                <label for="customerName" class="block text-lg font-bold text-gray-800 mb-3">
                                    <i class="bi bi-person-circle text-blue-600 mr-2"></i>
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <input type="text" id="customerName" x-model="customerName"
                                        class="input-simple w-full"
                                        placeholder="Masukkan nama lengkap Anda" required>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                        <i class="bi bi-check-circle text-green-500 text-xl" x-show="customerName.length > 0"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="customerPhone" class="block text-lg font-bold text-gray-800 mb-3">
                                    <i class="bi bi-phone text-blue-600 mr-2"></i>
                                    Nomor Telepon
                                </label>
                                <div class="relative">
                                    <input type="tel" id="customerPhone" x-model="customerPhone"
                                        class="input-simple w-full"
                                        placeholder="Contoh: 08123456789" required>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                        <i class="bi bi-check-circle text-green-500 text-xl" x-show="customerPhone.length > 0"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit"
                                    class="btn-primary-simple w-full text-white font-bold py-4 px-8 rounded-lg text-xl"
                                    :disabled="!customerName || !customerPhone">
                                    <div class="flex items-center justify-center">
                                        <i class="bi bi-rocket-takeoff mr-3 text-2xl"></i>
                                        <span>Lanjutkan ke Pembayaran</span>
                                        <i class="bi bi-arrow-right-circle ml-3 text-2xl"></i>
                                    </div>
                                </button>

                                <div x-show="bookingMessage" class="mt-6 p-4 rounded-lg text-center font-semibold text-lg"
                                     :class="bookingSuccess ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                                    <i class="bi bi-check-circle-fill mr-2" x-show="bookingSuccess"></i>
                                    <i class="bi bi-exclamation-triangle-fill mr-2" x-show="!bookingSuccess"></i>
                                    <span x-text="bookingMessage"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <div class="card-simple">
                        <div class="summary-header">
                            <div class="icon-box bg-blue-100 text-blue-600 mr-4">
                                <i class="bi bi-receipt text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Ringkasan</h3>
                                <p class="text-gray-600">Detail Pemesanan</p>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex items-center space-x-4">
                                    <div class="icon-box bg-blue-200 text-blue-700">
                                        <i class="bi bi-building text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg" x-text="bookingData.court_name"></h4>
                                        <p class="text-gray-600" x-text="bookingData.venue_name"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="summary-item">
                                    <div class="flex items-center text-gray-700">
                                        <i class="bi bi-calendar-date text-blue-500 mr-3 text-xl"></i>
                                        <span class="font-medium">Tanggal</span>
                                    </div>
                                    <span class="text-gray-800 font-bold" x-text="formatDate(bookingData.booking_date)"></span>
                                </div>

                                <div class="summary-item">
                                    <div class="flex items-center text-gray-700">
                                        <i class="bi bi-clock text-blue-500 mr-3 text-xl"></i>
                                        <span class="font-medium">Waktu</span>
                                    </div>
                                    <span class="text-gray-800 font-bold" x-text="formatTimeRange(bookingData.start_time, bookingData.end_time)"></span>
                                </div>

                                <div class="summary-item">
                                    <div class="flex items-center text-gray-700">
                                        <i class="bi bi-hourglass-split text-blue-500 mr-3 text-xl"></i>
                                        <span class="font-medium">Durasi</span>
                                    </div>
                                    <span class="text-gray-800 font-bold" x-text="bookingData.duration_hours + ' jam'"></span>
                                </div>
                            </div>

                            <div class="total-price-section mt-8">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 font-medium mb-1">Total Pembayaran</p>
                                        <p class="text-3xl font-bold text-gray-900">
                                            Rp <span x-text="formatPrice(bookingData.total_price)"></span>
                                        </p>
                                    </div>
                                    <div class="icon-box bg-blue-200 text-blue-700">
                                        <i class="bi bi-currency-dollar text-2xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            total_price: this.bookingData.total_price
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

