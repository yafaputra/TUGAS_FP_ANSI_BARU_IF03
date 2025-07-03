@extends('layout.headfoot')
@section('title', 'Dashboard Pengguna') {{-- Change title to reflect it's a user dashboard --}}

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg">
    {{-- Include any necessary styles or scripts --}}
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-green-700 mb-2">Dashboard Pengguna</h1>
        <p class="text-gray-600">Selamat datang, {{ $profilUser->full_name ?? $user->name }}! Kelola pemesanan dan lihat riwayat Anda.</p>
    </div>

    {{-- Navigation Tabs --}}
    <div class="mb-6">
        <div class="flex border-b-2 border-green-200">
            <button
                class="tab-button py-3 px-1 border-b-2 font-medium text-base focus:outline-none transition-colors duration-200 mr-8"
                data-tab="booking"
            >
                Booking Mendatang
            </button>
            <button
                class="tab-button py-3 px-1 border-b-2 font-medium text-base focus:outline-none transition-colors duration-200 text-gray-500 border-transparent hover:text-green-700 hover:border-green-300"
                data-tab="history"
            >
                Riwayat Booking
            </button>
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

    {{-- Filter Buttons (dinamis berdasarkan tab) --}}
    <div class="mb-8" id="filterButtonsContainer">
        {{-- Tombol filter akan di-generate oleh JavaScript --}}
    </div>

    {{-- Content Area --}}
    <div class="content-area">
        {{-- Active Bookings Content --}}
        <div id="bookingContent" class="tab-content">
            @if($activeBookings->isEmpty())
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
                        <div class="booking-card bg-white border border-green-200 rounded-lg p-5 shadow-sm hover:shadow-lg transition-shadow duration-200" data-status="{{ $booking->status }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 mr-3">{{ $booking->court->name ?? 'N/A' }}</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($booking->status === 'completed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'awaiting_confirmation') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    {{-- Display customer_name and customer_phone for verification/info --}}
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-person-fill text-green-500 me-1"></i>Nama Pemesan: {{ $booking->customer_name }}</p>
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-telephone-fill text-green-500 me-1"></i>Telepon: {{ $booking->customer_phone }}</p>
                                    
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-geo-alt-fill text-green-500 mr-1"></i>{{ $booking->court->venue->name ?? 'N/A' }} ({{ $booking->court->venue->city ?? 'N/A' }})</p>
                                    <p class="text-sm text-gray-700 mb-1 flex items-center"><i class="bi bi-calendar-check text-green-500 mr-1"></i>{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }} • <i class="bi bi-clock text-green-500 mr-1 ml-2"></i>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                                    <p class="text-base font-bold text-green-800 mt-2">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500 mt-2">Metode Pembayaran: <span class="font-semibold text-gray-700">{{ $booking->payment_method }}</span></p>
                                </div>
                                <div class="flex flex-col space-y-2 ml-4">
                                    <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                        Detail
                                    </button>
                                    @if($booking->status == 'pending')
                                        <a href="{{ route('payment.page', $booking->id) }}" class="border border-blue-500 text-blue-700 px-4 py-2 rounded text-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                    <button class="border border-red-500 text-red-700 px-4 py-2 rounded text-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200" onclick="confirmCancel({{ $booking->id }})">
                                        Batalkan
                                    </button>
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

        {{-- History Bookings Content --}}
        <div id="historyContent" class="tab-content hidden">
            @if($historyBookings->isEmpty())
                <div id="emptyStateHistory" class="text-center py-16 border border-gray-200 rounded-lg bg-white shadow-sm">
                    <div class="max-w-sm mx-auto">
                        <div class="mb-6">
                            <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada riwayat booking</h3>
                        <p class="text-gray-600 text-base leading-relaxed mb-6">
                            Riwayat semua booking lapangan kamu akan muncul di sini.
                        </p>
                    </div>
                </div>
                <div id="historyGrid" class="hidden"></div>
            @else
                <div id="emptyStateHistory" class="hidden"></div>
                <div id="historyGrid">
                    <div class="space-y-4">
                        @foreach($historyBookings as $booking)
                        <div class="booking-card bg-white border border-green-200 rounded-lg p-5 shadow-sm hover:shadow-lg transition-shadow duration-200" data-status="{{ $booking->status }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 mr-3">{{ $booking->court->name ?? 'N/A' }}</h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($booking->status === 'completed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'cancelled' || $booking->status === 'failed') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->status) }}
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
                                    <button class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                        Detail
                                    </button>
                                    {{-- You might add a "Book Again" button here --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            {{-- No History Results --}}
            <div id="noResultsHistory" class="hidden text-center py-12 border border-gray-200 rounded-lg bg-white shadow-sm">
                <div class="text-green-400 mb-4">
                    <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada riwayat booking yang cocok</h3>
                <p class="text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
            </div>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    const filterButtonsContainer = document.getElementById('filterButtonsContainer');
    const searchInput = document.getElementById('searchInput');

    let currentTab = 'booking';
    let currentFilter = 'all';

    // Initial setup
    switchTab(currentTab);

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
                { value: 'completed', label: 'Berhasil' },
                { value: 'cancelled', label: 'Dibatalkan' }
                // Add 'awaiting_confirmation' if relevant
            ];
        } else { // history tab
            filters = [
                { value: 'all', label: 'Semua Status' },
                { value: 'completed', label: 'Selesai' },
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

        const emptyStateElement = currentTab === 'booking' ?
            document.getElementById('emptyStateBooking') :
            document.getElementById('emptyStateHistory');
        
        const noResultsElement = currentTab === 'booking' ?
            document.getElementById('noResultsBooking') :
            document.getElementById('noResultsHistory');

        const gridElement = currentTab === 'booking' ?
            document.getElementById('bookingsGrid') :
            document.getElementById('historyGrid');

        const totalBookingsForCurrentTab = document.querySelectorAll(`#${currentTab}Content .booking-card`).length;

        if (totalBookingsForCurrentTab === 0) {
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

    // Function for updating booking status (AJAX call)
    // This function will be called from the buttons in the active bookings list
    window.updateBookingStatus = function(bookingId, newStatus) {
        if (!confirm(`Apakah Anda yakin ingin mengubah status booking ini menjadi ${newStatus.toUpperCase()}?`)) {
            return;
        }

        fetch(`/bookings/${bookingId}/status`, { // Make sure this route exists in routes/web.php
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload(); // Reload to reflect changes
            } else {
                alert(data.message || 'Gagal memperbarui status booking.');
            }
        })
        .catch(error => {
            console.error('Error updating booking status:', error);
            alert('Terjadi kesalahan saat memperbarui status booking.');
        });
    };
});
</script>
@endsection


