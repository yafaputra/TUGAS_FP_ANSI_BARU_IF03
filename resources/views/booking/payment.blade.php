{{-- PAYMENT METHOD SELECTION PAGE --}}
@extends('layout.headfoot')

@section('title', 'Pilih Metode Pembayaran')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: #f3f4f6;
        min-height: 100vh;
    }

    .main-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .payment-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .header h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .header p {
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .content {
        padding: 2rem;
    }

    .booking-summary {
        background: #f8fafc;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid #667eea;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .summary-row:last-child {
        margin-bottom: 0;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .summary-label {
        color: #64748b;
        font-size: 0.9rem;
    }

    .summary-value {
        color: #1e293b;
        font-weight: 500;
    }

    .total-amount {
        color: #059669;
        font-size: 1.3rem;
        font-weight: 700;
    }

    .payment-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .payment-option {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        position: relative;
        display: flex; /* Added for centering logo */
        justify-content: center; /* Added for centering logo */
        align-items: center; /* Added for centering logo */
        min-height: 80px; /* Ensure consistent height for logo-only display */
    }

    .payment-option:hover {
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .payment-option.selected {
        border-color: #059669;
        background: #f0fdf4;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
    }

    .payment-option img {
        width: 60px; /* Increased size for logo-only display */
        height: 60px; /* Increased size for logo-only display */
        object-fit: contain;
        margin-bottom: 0; /* Removed margin as name is gone */
    }

    .payment-option .name {
        display: none; /* Hide the name */
    }

    .payment-option .icon {
        font-size: 2.5rem; /* Increased size for icon-only display */
        margin-bottom: 0; /* Removed margin as name is gone */
        color: #64748b;
    }

    .payment-option.selected .icon {
        color: #059669;
    }

    .confirm-btn {
        width: 100%;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .confirm-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
    }

    .confirm-btn:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .message {
        margin-top: 1rem;
        padding: 0.75rem;
        border-radius: 6px;
        text-align: center;
        font-weight: 500;
    }

    .message.success {
        background: #f0fdf4;
        color: #059669;
        border: 1px solid #bbf7d0;
    }

    .message.error {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .main-container {
            margin: 1rem auto;
        }
        
        .content {
            padding: 1.5rem;
        }
        
        .payment-options {
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); /* Adjusted for smaller screens */
        }
        .payment-option img {
            width: 50px; /* Adjusted for smaller screens */
            height: 50px; /* Adjusted for smaller screens */
        }
        .payment-option .icon {
            font-size: 2rem; /* Adjusted for smaller screens */
        }
    }
</style>
@endpush

@section('content')
<div class="main-container" x-data="paymentPage()">
    <div class="payment-card">
        <div class="header">
            <h1>Pilih Metode Pembayaran</h1>
            <p>Selesaikan pembayaran untuk konfirmasi booking</p>
        </div>

        <div class="content">
            <div class="booking-summary">
                <div class="summary-row">
                    <span class="summary-label">Lapangan</span>
                    <span class="summary-value">{{ $booking->court->name }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Tanggal</span>
                    <span class="summary-value">{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMM Y') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Waktu</span>
                    <span class="summary-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Durasi</span>
                    <span class="summary-value">{{ $booking->duration_hours }} jam</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Total Pembayaran</span>
                    <span class="summary-value total-amount">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <form @submit.prevent="processPayment()">
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <div class="payment-section">
                    <div class="section-title">
                        <i class="bi bi-bank"></i>
                        Transfer Bank
                    </div>
                    <div class="payment-options">
                        <template x-for="bank in banks" :key="bank.value">
                            <div class="payment-option"
                                :class="{ 'selected': paymentMethod === bank.value }"
                                @click="paymentMethod = bank.value">
                                <img :src="bank.logo" :alt="bank.name">
                                {{-- The 'name' div is intentionally removed to only show the logo --}}
                            </div>
                        </template>
                    </div>
                </div>

                <div class="payment-section">
                    <div class="section-title">
                        <i class="bi bi-wallet"></i>
                        E-Wallet
                    </div>
                    <div class="payment-options">
                        <template x-for="ewallet in ewallets" :key="ewallet.value">
                            <div class="payment-option"
                                :class="{ 'selected': paymentMethod === ewallet.value }"
                                @click="paymentMethod = ewallet.value">
                                <img :src="ewallet.logo" :alt="ewallet.name">
                                {{-- The 'name' div is intentionally removed to only show the logo --}}
                            </div>
                        </template>
                    </div>
                </div>

                <button type="submit" class="confirm-btn" :disabled="!paymentMethod || processingPayment">
                    <i class="bi bi-check-circle-fill" x-show="!processingPayment"></i>
                    <i class="bi bi-arrow-clockwise" x-show="processingPayment" style="animation: spin 1s linear infinite;"></i>
                    <span x-show="!processingPayment">Konfirmasi Pembayaran</span>
                    <span x-show="processingPayment">Memproses...</span>
                </button>

                <div x-show="paymentMessage" 
                    x-text="paymentMessage"
                    :class="paymentSuccess ? 'message success' : 'message error'">
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    function paymentPage() {
        return {
            bookingId: {{ $booking->id }},
            paymentMethod: '',
            paymentMessage: '',
            paymentSuccess: false,
            processingPayment: false,

            banks: [
                { 
                    value: 'BCA', 
                    name: 'BCA', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg'
                },
                { 
                    value: 'BRI', 
                    name: 'BRI', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg'
                },
                { 
                    value: 'Mandiri', 
                    name: 'Mandiri', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg'
                },
                { 
                    value: 'BNI', 
                    name: 'BNI', 
                    logo: 'https://upload.wikimedia.org/wikipedia/en/2/27/BNI_logo.svg'
                }
            ],

            ewallets: [
                { 
                    value: 'OVO', 
                    name: 'OVO', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg'
                },
                { 
                    value: 'DANA', 
                    name: 'DANA', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg'
                },
                { 
                    value: 'GoPay', 
                    name: 'GoPay', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg'
                },
                { 
                    value: 'ShopeePay', 
                    name: 'ShopeePay', 
                    logo: 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg'
                }
            ],

            async processPayment() {
                if (!this.paymentMethod) {
                    this.paymentMessage = 'Silakan pilih metode pembayaran terlebih dahulu.';
                    this.paymentSuccess = false;
                    return;
                }

                this.processingPayment = true;
                this.paymentMessage = '';

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
                } finally {
                    this.processingPayment = false;
                }
            }
        };
    }
</script>
@endpush
@endsection

