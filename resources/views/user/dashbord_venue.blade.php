@extends('layout.headfoot')
@section('title', 'Dashboard Pengguna')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-green-700 mb-2">Dashboard Pengguna</h1>
        <p class="text-gray-600">Selamat datang, {{ $profilUser->full_name ?? $user->name }}! Kelola pemesanan dan lihat riwayat Anda.</p>
    </div>

    {{-- Navigation Tabs --}}
    <div class="mb-6">
        <div class="flex border-b-2 border-green-200">
            <button
                class="tab-button py-3 px-1 border-b-2 font-medium text-base focus:outline-none transition-colors duration-200 mr-8 active"
                data-tab="booking"
            >
                Booking Mendatang
            </button>
            {{-- Tambahkan tab untuk riwayat jika ada --}}
            {{-- <button
                class="tab-button py-3 px-1 border-b-2 font-medium text-base focus:outline-none transition-colors duration-200"
                data-tab="history"
            >
                Riwayat Booking
            </button> --}}
        </div>
    </div>

    {{-- Search Section --}}
    <div class="mb-6">
        <div class="relative max-w-sm">
            <input
                type="text"
                class="w-full py-2 px-3 pr-10 border border-green-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                placeholder="Cari booking disini [ENTER]"
                id="searchInput"
            >
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Filter Buttons --}}
    <div class="mb-8 flex space-x-2" id="filterButtonsContainer">
        {{-- Tombol filter akan di-generate oleh JavaScript --}}
    </div>

    {{-- Content Area --}}
    <div class="content-area">
        {{-- Active Bookings Content --}}
        <div id="bookingContent" class="tab-content">
            @if($activeBookings->isEmpty() && request()->input('search') == '' && request()->input('filter') == '')
                <div id="emptyStateBooking" class="text-center py-16 border border-gray-200 rounded-lg bg-white shadow-sm">
                    <div class="max-w-sm mx-auto">
                        <div class="mb-6">
                            <svg class="mx-auto h-24 w-24 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada booking mendatang</h3>
                        <p class="text-gray-600 text-base leading-relaxed mb-6">
                            Booking lapangan yang kamu buat akan muncul di sini.
                        </p>
                        <a href="{{ route('venue.index') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg text-base font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                            Cari Lapangan Sekarang
                        </a>
                    </div>
                </div>
                <div id="bookingsGrid" class="hidden"></div>
            @else
                <div id="emptyStateBooking" class="hidden"></div>
                <div id="bookingsGrid">
                    <div class="space-y-4">
                        @foreach($activeBookings as $booking)
                        <div class="booking-card bg-white border border-green-200 rounded-lg p-5 shadow-sm hover:shadow-lg transition-shadow duration-200"
                             data-status="{{ $booking->status }}"
                             data-booking-id="{{ $booking->id }}"
                             data-booking-date="{{ $booking->booking_date }}"
                             data-end-time="{{ $booking->end_time }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 mr-3">{{ $booking->court->name ?? 'N/A' }}</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($booking->status === 'completed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending' || $booking->status === 'waiting_payment') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'awaiting_confirmation') bg-blue-100 text-blue-800
                                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                            @elseif($booking->status === 'failed') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-person-fill text-green-500 me-1"></i>Nama Pemesan: {{ $booking->customer_name }}</p>
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-telephone-fill text-green-500 me-1"></i>Telepon: {{ $booking->customer_phone }}</p>
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-geo-alt-fill text-green-500 mr-1"></i>{{ $booking->court->venue->name ?? 'N/A' }} ({{ $booking->court->venue->city ?? 'N/A' }})</p>
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-calendar-check text-green-500 mr-1"></i>{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }} • <i class="bi bi-clock text-green-500 mr-1 ml-2"></i>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                                    <p class="text-base font-bold text-green-800 mt-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500 mt-2">Metode Pembayaran: <span class="font-semibold text-gray-700">{{ $booking->payment_method }}</span></p>
                                </div>
                                <div class="flex flex-col space-y-2 ml-4">
                                    {{-- Button Detail - Selalu ada --}}
                                    <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                        Detail
                                    </button>

                                    {{-- Button Bayar Sekarang - Untuk pending/waiting_payment --}}
                                    @if($booking->status == 'pending' || $booking->status == 'waiting_payment')
                                        <a href="{{ route('payment.page', $booking->id) }}" class="border border-blue-500 text-blue-700 px-4 py-2 rounded text-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 text-center">
                                            Bayar Sekarang
                                        </a>
                                    @endif

                                    {{-- Button Selesai - Untuk awaiting_confirmation (Selalu muncul) --}}
                                   {{-- Button Selesai - Muncul jika booking belum selesai, dibatalkan, atau gagal --}}
                                    @if(!in_array($booking->status, ['completed', 'cancelled', 'failed']))
                                        <button class="finish-button bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                                                onclick="confirmComplete({{ $booking->id }})"
                                                style="display: block;">
                                            Selesai
                                        </button>
                                    @endif

                                    {{-- Button Batalkan - Untuk semua status kecuali completed/cancelled/failed --}}
                                    @if(!in_array($booking->status, ['completed', 'cancelled', 'failed']))
                                        <button class="border border-red-500 text-red-700 px-4 py-2 rounded text-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200" onclick="confirmCancel({{ $booking->id }})">
                                            Batalkan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- No Results State for Active Bookings --}}
            <div id="noResultsBooking" class="hidden text-center py-12 border border-gray-200 rounded-lg bg-white shadow-sm">
                <div class="text-green-400 mb-4">
                    <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada booking mendatang yang cocok</h3>
                <p class="text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
            </div>
        </div>
    </div>
</div>

{{-- Cancel Modal --}}
<div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="text-center mb-6">
            <div class="mx-auto w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.19 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Batalkan Booking</h3>
            <p class="text-gray-600 mt-2">Apakah Anda yakin ingin membatalkan booking ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="flex justify-center space-x-4">
            <button id="cancelCancel" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                Batal
            </button>
            <button id="confirmCancel" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200">
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

{{-- Complete Modal --}}
<div id="completeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="text-center mb-6">
            <div class="mx-auto w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Selesaikan Booking</h3>
            <p class="text-gray-600 mt-2">Apakah Anda yakin booking ini sudah selesai? Booking akan ditandai sebagai selesai.</p>
        </div>
        <div class="flex justify-center space-x-4">
            <button id="cancelComplete" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                Batal
            </button>
            <button id="confirmComplete" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200">
                Ya, Selesai
            </button>
        </div>
    </div>
</div>

<style>
.tab-button.active {
    @apply text-green-600 border-green-600;
}

.filter-btn.active {
    @apply bg-green-600 text-white;
}

/* Hapus atau nonaktifkan aturan CSS ini jika tidak relevan lagi */
/* .finish-button.enabled {
    @apply bg-green-600;
}

.finish-button.enabled:hover {
    @apply bg-green-700;
}

.waiting-time-info {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
} */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    const filterButtonsContainer = document.getElementById('filterButtonsContainer');
    const searchInput = document.getElementById('searchInput');

    let currentTab = 'booking'; // Default tab
    let currentFilter = 'all';

    // Initial setup
    switchTab(currentTab);
    // Hapus pemanggilan checkBookingTimes di sini karena tidak perlu lagi
    // checkBookingTimes();

    // Hapus interval untuk checkBookingTimes karena tidak perlu lagi
    // setInterval(checkBookingTimes, 60000);

    // Tab switching
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tab = this.dataset.tab;
            switchTab(tab);
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        filterBookings();
    });

    function switchTab(tab) {
        currentTab = tab;

        tabButtons.forEach(btn => {
            btn.classList.remove('active', 'text-green-600', 'border-green-600');
            btn.classList.add('text-gray-500', 'border-transparent', 'hover:text-green-700', 'hover:border-green-300');

            if (btn.dataset.tab === tab) {
                btn.classList.add('active', 'text-green-600', 'border-green-600');
                btn.classList.remove('text-gray-500', 'border-transparent', 'hover:text-green-700', 'hover:border-green-300');
            }
        });

        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById(tab + 'Content').classList.remove('hidden');

        updateFilterButtons(tab);

        searchInput.value = '';
        setFilter('all');
        filterBookings();
    }

    function updateFilterButtons(tab) {
        filterButtonsContainer.innerHTML = '';

        let filters = [];

        if (tab === 'booking') {
            filters = [
                { value: 'all', label: 'Semua Status' },
                { value: 'pending', label: 'Menunggu Pembayaran' },
                { value: 'waiting_payment', label: 'Menunggu Pembayaran (Lanjut)' },
                { value: 'awaiting_confirmation', label: 'Menunggu Konfirmasi' },
                { value: 'completed', label: 'Berhasil' },
                { value: 'cancelled', label: 'Dibatalkan' },
                { value: 'failed', label: 'Gagal' }
            ];
        }

        filters.forEach((filter, index) => {
            const button = createFilterButton(filter.value, filter.label, index === 0);
            filterButtonsContainer.appendChild(button);
        });
    }

    function createFilterButton(value, label, isActive = false) {
        const button = document.createElement('button');
        button.className = 'filter-btn px-4 py-2 rounded text-sm font-medium transition-colors duration-200 shadow-sm';
        button.dataset.filter = value;
        button.textContent = label;

        if (isActive) {
            button.classList.add('bg-green-600', 'text-white', 'active');
        } else {
            button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-green-100', 'hover:text-green-800');
        }

        button.addEventListener('click', function() {
            setFilter(value);
            filterBookings();
        });

        return button;
    }

    function setFilter(filter) {
        currentFilter = filter;

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-green-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-green-100', 'hover:text-green-800');

            if (btn.dataset.filter === filter) {
                btn.classList.add('active', 'bg-green-600', 'text-white');
                btn.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-green-100', 'hover:text-green-800');
            }
        });
    }

    function filterBookings() {
        const searchTerm = searchInput.value.toLowerCase();
        const cards = document.querySelectorAll(`#${currentTab}Content .booking-card`);
        let visibleCount = 0;

        cards.forEach(card => {
            const status = card.dataset.status;
            const text = card.textContent.toLowerCase();

            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            const matchesSearch = !searchTerm || text.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const emptyStateElement = document.getElementById('emptyStateBooking');
        const noResultsElement = document.getElementById('noResultsBooking');
        const gridElement = document.getElementById('bookingsGrid');

        const totalBookingsLoaded = document.querySelectorAll(`#${currentTab}Content .booking-card`).length;

        if (totalBookingsLoaded === 0) {
            emptyStateElement.classList.remove('hidden');
            gridElement.classList.add('hidden');
            noResultsElement.classList.add('hidden');
        } else if (visibleCount === 0) {
            noResultsElement.classList.remove('hidden');
            emptyStateElement.classList.add('hidden');
            gridElement.classList.remove('hidden');
        } else {
            noResultsElement.classList.add('hidden');
            emptyStateElement.classList.add('hidden');
            gridElement.classList.remove('hidden');
        }
    }

    // Fungsi checkBookingTimes tidak lagi dibutuhkan untuk menampilkan/menyembunyikan tombol 'Selesai'
    // Karena tombol 'Selesai' akan selalu ditampilkan jika statusnya 'awaiting_confirmation'
    // Anda bisa menghapus fungsi ini sepenuhnya jika tidak ada logika lain yang bergantung padanya.
    // function checkBookingTimes() {
    //     // Logika ini dihapus
    // }

    // Cancel booking functionality
    window.confirmCancel = function(bookingId) {
        const modal = document.getElementById('cancelModal');
        modal.classList.remove('hidden');
        modal.dataset.bookingId = bookingId;
    };

    // Complete booking functionality
    window.confirmComplete = function(bookingId) {
        const modal = document.getElementById('completeModal');
        modal.classList.remove('hidden');
        modal.dataset.bookingId = bookingId;
    };

    // Cancel modal event handlers
    document.getElementById('cancelCancel').addEventListener('click', function() {
        document.getElementById('cancelModal').classList.add('hidden');
    });

    document.getElementById('confirmCancel').addEventListener('click', function() {
        const modal = document.getElementById('cancelModal');
        const bookingId = modal.dataset.bookingId;
        modal.classList.add('hidden');
        proceedWithCancel(bookingId);
    });

    // Complete modal event handlers
    document.getElementById('cancelComplete').addEventListener('click', function() {
        document.getElementById('completeModal').classList.add('hidden');
    });

    document.getElementById('confirmComplete').addEventListener('click', function() {
        const modal = document.getElementById('completeModal');
        const bookingId = modal.dataset.bookingId;
        modal.classList.add('hidden');
        proceedWithComplete(bookingId);
    });

    // Cancel booking process
    function proceedWithCancel(bookingId) {
        fetch(`/bookings/${bookingId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: 'cancelled' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBookingCard(bookingId, 'cancelled');
                alert(data.message);
            } else {
                alert(data.message || 'Gagal membatalkan booking.');
            }
        })
        .catch(error => {
            console.error('Error canceling booking:', error);
            alert('Terjadi kesalahan saat membatalkan booking.');
        });
    }

    // Complete booking process
    function proceedWithComplete(bookingId) {
        fetch(`/bookings/${bookingId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: 'completed' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateBookingCard(bookingId, 'completed');
                alert(data.message);
            } else {
                alert(data.message || 'Gagal menyelesaikan booking.');
            }
        })
        .catch(error => {
            console.error('Error completing booking:', error);
            alert('Terjadi kesalahan saat menyelesaikan booking.');
        });
    }

    // Update booking card status dynamically
    function updateBookingCard(bookingId, newStatus) {
        const card = document.querySelector(`.booking-card[data-booking-id="${bookingId}"]`);
        if (!card) return;

        // Update status badge
        const statusBadge = card.querySelector('.inline-flex.items-center');
        if (statusBadge) {
            statusBadge.textContent = newStatus.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
            statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium';
            if (newStatus === 'completed') {
                statusBadge.classList.add('bg-green-100', 'text-green-800');
            } else if (newStatus === 'pending' || newStatus === 'waiting_payment') {
                statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
            } else if (newStatus === 'awaiting_confirmation') {
                statusBadge.classList.add('bg-blue-100', 'text-blue-800');
            } else if (newStatus === 'cancelled' || newStatus === 'failed') {
                statusBadge.classList.add('bg-red-100', 'text-red-800');
            } else {
                statusBadge.classList.add('bg-gray-100', 'text-gray-800');
            }
        }

        // Update card data-status
        card.dataset.status = newStatus;


        // Remove/show action buttons based on new status
        const buttonContainer = card.querySelector('.flex.flex-col.space-y-2');
        if (buttonContainer) {
            // Re-render buttons based on new status
            let buttonsHtml = `
                <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                    Detail
                </button>
            `;

            if (newStatus === 'pending' || newStatus === 'waiting_payment') {
                buttonsHtml += `
                    <a href="/payment/${bookingId}/page" class="border border-blue-500 text-blue-700 px-4 py-2 rounded text-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 text-center">
                        Bayar Sekarang
                    </a>
                `;
            } else if (newStatus === 'awaiting_confirmation') {
                // Tombol "Selesai" selalu ditampilkan jika statusnya "awaiting_confirmation"
                buttonsHtml += `
                    <button class="finish-button bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200" onclick="confirmComplete(${bookingId})">
                        Selesai
                    </button>
                `;
            }

            if (!['completed', 'cancelled', 'failed'].includes(newStatus)) {
                buttonsHtml += `
                    <button class="border border-red-500 text-red-700 px-4 py-2 rounded text-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200" onclick="confirmCancel(${bookingId})">
                        Batalkan
                    </button>
                `;
            }
            buttonContainer.innerHTML = buttonsHtml;
        }

        // Re-apply filters to show/hide cards as needed
        filterBookings();
    }

    // Close modals when clicking outside
    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    document.getElementById('completeModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>
@endsection
