{{-- resources/views/venue/dashboard.blade.php --}}
@extends('layout.headfoot')
@section('title', 'Dashboard Venue')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-slate-700 to-slate-600 text-white py-8 px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">🏟️ Dashboard Venue</h1>
        <p class="text-lg opacity-90">Kelola dan pantau booking lapangan Anda dengan mudah</p>
    </div>

    {{-- Navigation Tabs --}}
    <div class="flex bg-gray-50 border-b-4 border-gray-200">
        <button 
            class="flex-1 py-5 px-6 text-center cursor-pointer font-semibold text-lg transition-all duration-300 border-b-4 border-transparent hover:bg-gray-200 tab-button active"
            data-tab="booking"
        >
            📅 Booking
        </button>
        <button 
            class="flex-1 py-5 px-6 text-center cursor-pointer font-semibold text-lg transition-all duration-300 border-b-4 border-transparent hover:bg-gray-200 tab-button"
            data-tab="history"
        >
            📋 Riwayat Booking
        </button>
    </div>

    {{-- Content --}}
    <div class="p-10">
        {{-- Search Section --}}
        <div class="mb-8">
            <div class="relative max-w-lg mx-auto mb-8">
                <input 
                    type="text" 
                    class="w-full py-4 px-6 pr-14 border-2 border-gray-200 rounded-full text-base outline-none transition-all duration-300 focus:border-green-500 focus:shadow-lg focus:shadow-green-100"
                    placeholder="Cari booking atau venue..."
                    id="searchInput"
                >
                <span class="absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
            </div>

            <div class="flex justify-center gap-4 flex-wrap mb-10">
                <button class="filter-btn active" data-filter="all">Semua Status</button>
                <button class="filter-btn" data-filter="pending">Menunggu Pembayaran</button>
                <button class="filter-btn" data-filter="confirmed">Dikonfirmasi</button>
            </div>
        </div>

        {{-- Booking Content --}}
        <div id="bookingContent" class="tab-content">
            {{-- Empty State --}}
            <div id="emptyState" class="text-center py-20 px-5 text-gray-500">
                <div class="text-8xl mb-8 opacity-30">📋</div>
                <h3 class="text-3xl mb-4 text-gray-600">Belum Ada Booking</h3>
                <p class="text-lg leading-relaxed max-w-md mx-auto mb-8">
                    Lapangan yang Anda booking akan muncul di sini. Mulai booking lapangan favorit Anda sekarang!
                </p>
                <button 
                    class="bg-gradient-to-r from-green-500 to-teal-500 text-white py-4 px-9 rounded-full text-lg font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-300"
                    onclick="showSampleBookings()"
                >
                    ➕ Lihat Contoh Booking
                </button>
            </div>

            {{-- Bookings Grid --}}
            <div id="bookingsGrid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                @php
                $activeBookings = [
                    [
                        'id' => 1,
                        'name' => 'Lapangan Futsal Center',
                        'type' => 'Futsal',
                        'date' => '15 Juni 2025',
                        'time' => '19:00 - 21:00',
                        'status' => 'confirmed',
                        'price' => 'Rp 150.000',
                        'icon' => '⚽'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Court Badminton Elite',
                        'type' => 'Badminton',
                        'date' => '16 Juni 2025',
                        'time' => '08:00 - 10:00',
                        'status' => 'pending',
                        'price' => 'Rp 80.000',
                        'icon' => '🏸'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Lapangan Tenis Indoor',
                        'type' => 'Tenis',
                        'date' => '17 Juni 2025',
                        'time' => '16:00 - 18:00',
                        'status' => 'confirmed',
                        'price' => 'Rp 120.000',
                        'icon' => '🎾'
                    ]
                ];
                @endphp

                @foreach($activeBookings as $booking)
                <div class="booking-card bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 border-2 border-gray-100 hover:-translate-y-2 hover:shadow-xl" data-status="{{ $booking['status'] }}">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white text-5xl">
                        {{ $booking['icon'] }}
                    </div>
                    <div class="p-6">
                        <div class="text-xl font-bold mb-3 text-slate-700">{{ $booking['name'] }}</div>
                        <div class="text-gray-600 mb-4 leading-relaxed">
                            📅 {{ $booking['date'] }}<br>
                            ⏰ {{ $booking['time'] }}<br>
                            💰 {{ $booking['price'] }}
                        </div>
                        <span class="inline-block py-2 px-4 rounded-full text-sm font-semibold mb-5 
                            @if($booking['status'] === 'confirmed') bg-green-100 text-green-800 
                            @elseif($booking['status'] === 'pending') bg-yellow-100 text-yellow-800 
                            @else bg-red-100 text-red-800 @endif">
                            @if($booking['status'] === 'confirmed') ✅ Dikonfirmasi
                            @elseif($booking['status'] === 'pending') ⏳ Menunggu Pembayaran
                            @else ❌ Dibatalkan @endif
                        </span>
                        <div class="flex gap-3">
                            <button class="flex-1 bg-green-500 text-white py-3 px-5 rounded-full font-semibold cursor-pointer transition-all duration-300 hover:bg-green-600 hover:-translate-y-1">
                                Detail
                            </button>
                            <button class="flex-1 bg-transparent text-green-500 border-2 border-green-500 py-3 px-5 rounded-full font-semibold cursor-pointer transition-all duration-300 hover:bg-green-500 hover:text-white">
                                @if($booking['status'] === 'confirmed') Batalkan @else Bayar Sekarang @endif
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- No Results State --}}
            <div id="noResults" class="hidden text-center py-10 text-gray-500">
                <div class="text-5xl mb-5">🔍</div>
                <h3 class="text-xl mb-2">Tidak ada booking aktif</h3>
                <p>Booking yang sedang berlangsung akan muncul di sini</p>
            </div>
        </div>

        {{-- History Content --}}
        <div id="historyContent" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                @php
                $historyBookings = [
                    [
                        'id' => 4,
                        'name' => 'Lapangan Basket Outdoor',
                        'type' => 'Basket',
                        'date' => '10 Juni 2025',
                        'time' => '16:00 - 18:00',
                        'status' => 'completed',
                        'price' => 'Rp 100.000',
                        'icon' => '🏀'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Court Badminton Pro',
                        'type' => 'Badminton',
                        'date' => '8 Juni 2025',
                        'time' => '20:00 - 22:00',
                        'status' => 'cancelled',
                        'price' => 'Rp 90.000',
                        'icon' => '🏸'
                    ],
                    [
                        'id' => 6,
                        'name' => 'Lapangan Futsal Premium',
                        'type' => 'Futsal',
                        'date' => '5 Juni 2025',
                        'time' => '18:00 - 20:00',
                        'status' => 'completed',
                        'price' => 'Rp 180.000',
                        'icon' => '⚽'
                    ]
                ];
                @endphp

                @foreach($historyBookings as $booking)
                <div class="booking-card bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 border-2 border-gray-100 hover:-translate-y-2 hover:shadow-xl" data-status="{{ $booking['status'] }}">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white text-5xl">
                        {{ $booking['icon'] }}
                    </div>
                    <div class="p-6">
                        <div class="text-xl font-bold mb-3 text-slate-700">{{ $booking['name'] }}</div>
                        <div class="text-gray-600 mb-4 leading-relaxed">
                            📅 {{ $booking['date'] }}<br>
                            ⏰ {{ $booking['time'] }}<br>
                            💰 {{ $booking['price'] }}
                        </div>
                        <span class="inline-block py-2 px-4 rounded-full text-sm font-semibold mb-5 
                            @if($booking['status'] === 'completed') bg-green-100 text-green-800 
                            @else bg-red-100 text-red-800 @endif">
                            @if($booking['status'] === 'completed') ✅ Berhasil @else ❌ Dibatalkan @endif
                        </span>
                        <div class="flex gap-3">
                            <button class="flex-1 bg-green-500 text-white py-3 px-5 rounded-full font-semibold cursor-pointer transition-all duration-300 hover:bg-green-600 hover:-translate-y-1">
                                Detail
                            </button>
                            <button class="flex-1 bg-transparent text-green-500 border-2 border-green-500 py-3 px-5 rounded-full font-semibold cursor-pointer transition-all duration-300 hover:bg-green-500 hover:text-white">
                                @if($booking['status'] === 'completed') Booking Lagi @else Lihat Alasan @endif
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- No History Results --}}
            <div id="noHistoryResults" class="hidden text-center py-10 text-gray-500">
                <div class="text-5xl mb-5">📚</div>
                <h3 class="text-xl mb-2">Tidak ada riwayat ditemukan</h3>
                <p>Riwayat booking Anda akan tersimpan di sini</p>
            </div>
        </div>
    </div>
</div>

<style>
.filter-btn {
    @apply py-3 px-6 border-2 border-gray-200 bg-white rounded-full font-semibold cursor-pointer transition-all duration-300 text-sm hover:border-green-500 hover:-translate-y-1;
}

.filter-btn.active {
    @apply bg-green-500 text-white border-green-500;
}

.tab-button.active {
    @apply bg-white border-green-500 text-green-500;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    
    let currentTab = 'booking';
    let currentFilter = 'all';

    // Tab switching
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tab = this.dataset.tab;
            switchTab(tab);
        });
    });

    // Filter switching
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            setFilter(filter);
            filterBookings();
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        filterBookings();
    });

    function switchTab(tab) {
        currentTab = tab;
        currentFilter = 'all';
        
        // Update tab buttons
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.tab === tab) {
                btn.classList.add('active');
            }
        });

        // Update tab contents
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });
        
        document.getElementById(tab + 'Content').classList.remove('hidden');

        // Update filter buttons for history tab
        updateFilterButtons(tab);
        
        // Reset search
        searchInput.value = '';
        
        // Reset filter
        setFilter('all');
        filterBookings();
    }

    function updateFilterButtons(tab) {
        const filterContainer = filterButtons[0].parentElement;
        filterContainer.innerHTML = '';
        
        if (tab === 'booking') {
            const filters = [
                { value: 'all', label: 'Semua Status' },
                { value: 'pending', label: 'Menunggu Pembayaran' },
                { value: 'confirmed', label: 'Dikonfirmasi' }
            ];
            
            filters.forEach(filter => {
                const button = createFilterButton(filter.value, filter.label);
                filterContainer.appendChild(button);
            });
        } else {
            const filters = [
                { value: 'all', label: 'Semua Status' },
                { value: 'completed', label: 'Berhasil' },
                { value: 'cancelled', label: 'Dibatalkan' }
            ];
            
            filters.forEach(filter => {
                const button = createFilterButton(filter.value, filter.label);
                filterContainer.appendChild(button);
            });
        }
    }

    function createFilterButton(value, label) {
        const button = document.createElement('button');
        button.className = 'filter-btn';
        button.dataset.filter = value;
        button.textContent = label;
        
        if (value === 'all') {
            button.classList.add('active');
        }
        
        button.addEventListener('click', function() {
            setFilter(value);
            filterBookings();
        });
        
        return button;
    }

    function setFilter(filter) {
        currentFilter = filter;
        
        // Update filter button states
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.filter === filter) {
                btn.classList.add('active');
            }
        });
    }

    function filterBookings() {
        const searchTerm = searchInput.value.toLowerCase();
        const cards = document.querySelectorAll('.booking-card');
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

        // Show/hide no results state
        const noResultsElement = currentTab === 'booking' ? 
            document.getElementById('noResults') : 
            document.getElementById('noHistoryResults');
            
        if (visibleCount === 0) {
            noResultsElement.classList.remove('hidden');
        } else {
            noResultsElement.classList.add('hidden');
        }
    }

    // Show sample bookings function
    window.showSampleBookings = function() {
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('bookingsGrid').classList.remove('hidden');
    };
});
</script>
@endsection