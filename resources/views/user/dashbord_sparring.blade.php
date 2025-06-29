@extends('layout.headfoot')
@section('title', 'Dashboard Sparring')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white p-8 text-center">
        <h1 class="text-4xl font-bold mb-3">⚽ Dashboard Sparring</h1>
        <p class="text-xl opacity-90">Kelola dan pantau sparring tim Anda dengan mudah</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex bg-gray-50 border-b-4 border-gray-200">
        <button class="flex-1 p-5 text-center cursor-pointer font-semibold text-lg transition-all duration-300 border-b-4 border-transparent hover:bg-gray-200 tab-button active" data-tab="sparring">
            ⚽ Sparring Aktif
        </button>
        <button class="flex-1 p-5 text-center cursor-pointer font-semibold text-lg transition-all duration-300 border-b-4 border-transparent hover:bg-gray-200 tab-button" data-tab="history">
            📋 Riwayat Sparring
        </button>
    </div>

    <div class="p-10">
        <!-- Search Section -->
        <div class="mb-8">
            <div class="relative max-w-lg mx-auto mb-8">
                <input type="text" class="w-full py-4 px-5 pr-12 border-2 border-gray-200 rounded-full text-base outline-none transition-all duration-300 focus:border-green-500 focus:ring-4 focus:ring-green-100" placeholder="Cari tim atau lokasi..." id="searchInput">
                <span class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-500">🔍</span>
            </div>

            <div class="flex justify-center gap-4 flex-wrap mb-10" id="filterButtons">
                <!-- Filter buttons will be populated by JavaScript -->
            </div>
        </div>

        <!-- Sparring Content -->
        <div id="sparringContent">
            <!-- Empty State -->
            <div class="text-center py-20 text-gray-500" id="emptyState">
                <div class="text-8xl mb-8 opacity-30">⚽</div>
                <h3 class="text-3xl mb-4 text-gray-600">Belum Ada Sparring</h3>
                <p class="text-xl leading-relaxed max-w-md mx-auto mb-8">Sparring yang Anda ikuti akan muncul di sini. Mulai gabung sparring sekarang!</p>
                <button class="bg-gradient-to-r from-green-600 to-green-500 text-white py-4 px-9 rounded-full text-xl font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-green-300" id="showSparringBtn">
                    ➕ Lihat Sparring Tersedia
                </button>
            </div>

            <!-- Sparring Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mt-8 hidden" id="sparringGrid">
                <!-- Cards will be populated by JavaScript -->
            </div>
        </div>

        <!-- History Content -->
        <div id="historyContent" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mt-8" id="historyGrid">
                <!-- History cards will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data
    const activeSparring = [
        {
            id: 1,
            name: "Jakarta Timur Football Community",
            initials: "JT",
            category: "Sepak Bola",
            level: "Level Putih I",
            rating: "4.88",
            date: "05 Jun 2025",
            time: "20:00",
            location: "Utama, Stadion Inguk Klender",
            cost: "Rp 400.000",
            dp: "Rp 200.000",
            color: "#3498db",
            status: "available"
        },
        {
            id: 2,
            name: "Petakilan FC",
            initials: "PF",
            category: "Futsal",
            level: "Level Perak II",
            rating: "4.79",
            date: "05 Jun 2025",
            time: "20:00",
            location: "Lap B atau G. Halim Futsal & Badminton",
            cost: "Rp 170.000",
            dp: "Rp 0",
            color: "#e74c3c",
            status: "available"
        },
        {
            id: 3,
            name: "Sucks Ballers",
            initials: "SB",
            category: "Futsal",
            level: "Level Putih I",
            rating: "4.75",
            date: "06 Jun 2025",
            time: "18:50",
            location: "Lapangan Biru, Magnet Arena New",
            cost: "Rp 125.000",
            dp: "Rp 0",
            color: "#34495e",
            status: "joined"
        },
        {
            id: 4,
            name: "Matador FC",
            initials: "MF",
            category: "Mini Soccer",
            level: "Level Putih I",
            rating: "4.60",
            date: "07 Jun 2025",
            time: "08:00",
            location: "Mini soccer, de King&D30 Arena (Futsal and Mini Soccer)",
            cost: "TBD",
            dp: "TBD",
            color: "#1abc9c",
            status: "available"
        },
        {
            id: 5,
            name: "SPONTAN CHUY FC",
            initials: "SC",
            category: "Mini Soccer",
            level: "Level Putih I",
            rating: "5.00",
            date: "07 Jun 2025",
            time: "15:30",
            location: "lap. Fuerza Arena",
            cost: "TBD",
            dp: "TBD",
            color: "#2c3e50",
            status: "available"
        },
        {
            id: 6,
            name: "Southawla KSB",
            initials: "SK",
            category: "Mini Soccer",
            level: "Level Putih I",
            rating: "4.50",
            date: "07 Jun 2025",
            time: "16:00",
            location: "Lapangan A, Jonas Mini Soccer",
            cost: "TBD",
            dp: "TBD",
            color: "#27ae60",
            status: "available"
        }
    ];

    const historySparring = [
        {
            id: 7,
            name: "Champions United",
            initials: "CU",
            category: "Futsal",
            level: "Level Perak I",
            rating: "4.85",
            date: "01 Jun 2025",
            time: "19:00",
            location: "Arena Futsal Premium",
            cost: "Rp 180.000",
            dp: "Rp 50.000",
            color: "#9b59b6",
            status: "completed"
        },
        {
            id: 8,
            name: "Street Fighters FC",
            initials: "SF",
            category: "Sepak Bola",
            level: "Level Putih II",
            rating: "4.20",
            date: "28 Mei 2025",
            time: "16:00",
            location: "Lapangan Rumput Sintetis",
            cost: "Rp 300.000",
            dp: "Rp 150.000",
            color: "#e67e22",
            status: "cancelled"
        }
    ];

    const sparringFilters = [
        { value: 'all', label: 'Semua Kategori' },
        { value: 'Futsal', label: 'Futsal' },
        { value: 'Sepak Bola', label: 'Sepak Bola' },
        { value: 'Mini Soccer', label: 'Mini Soccer' }
    ];

    const historyFilters = [
        { value: 'all', label: 'Semua Status' },
        { value: 'completed', label: 'Selesai' },
        { value: 'cancelled', label: 'Dibatalkan' }
    ];

    // State
    let currentTab = 'sparring';
    let currentFilter = 'all';
    let searchInput = '';
    let showSparringGrid = false;

    // Helper functions
    function getLevelClass(level) {
        if (level.includes('Putih')) return 'bg-yellow-100 text-yellow-800';
        if (level.includes('Perak')) return 'bg-blue-100 text-blue-800';
        if (level.includes('Emas')) return 'bg-yellow-100 text-yellow-800';
        return 'bg-yellow-100 text-yellow-800';
    }

    function getStatusClass(status) {
        const classes = {
            'completed': 'bg-green-100 text-green-800',
            'cancelled': 'bg-red-100 text-red-800',
            'joined': 'bg-blue-100 text-blue-800'
        };
        return classes[status] || 'bg-gray-100 text-gray-800';
    }

    function getStatusText(status) {
        const texts = {
            'completed': '✅ Selesai',
            'cancelled': '❌ Dibatalkan',
            'joined': '✅ Bergabung'
        };
        return texts[status] || 'Tersedia';
    }

    function filterData(data, category, search) {
        let filtered = category === 'all' ? data : data.filter(s => s.category === category);
        
        if (search.trim()) {
            const searchLower = search.toLowerCase();
            filtered = filtered.filter(s => 
                s.name.toLowerCase().includes(searchLower) ||
                s.category.toLowerCase().includes(searchLower) ||
                s.location.toLowerCase().includes(searchLower) ||
                s.level.toLowerCase().includes(searchLower)
            );
        }
        
        return filtered;
    }

    function createSparringCard(sparring, isHistory = false) {
        const cardHtml = `
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg border-2 border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                <div class="flex items-center p-5 bg-gray-50">
                    <div class="w-15 h-15 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4 flex-shrink-0" style="background-color: ${sparring.color}">
                        ${sparring.initials}
                    </div>
                    <div class="flex-1">
                        <div class="text-xl font-bold mb-1 text-gray-800">${sparring.name}</div>
                        <div class="text-gray-500 text-sm mb-2">${sparring.category}</div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-2xl text-xs font-semibold ${getLevelClass(sparring.level)}">
                                ${sparring.level}
                            </span>
                            <span class="text-sm text-yellow-500 font-semibold">⭐ ${sparring.rating}</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 pb-3">
                    <div class="flex items-center mb-2 text-gray-500">
                        <span class="mr-2 w-5">📅</span>
                        <span>${sparring.date}</span>
                    </div>
                    <div class="flex items-center mb-2 text-gray-500">
                        <span class="mr-2 w-5">⏰</span>
                        <span>${sparring.time}</span>
                    </div>
                    <div class="flex items-center mb-2 text-gray-500">
                        <span class="mr-2 w-5">📍</span>
                        <span>${sparring.location}</span>
                    </div>
                </div>

                ${!isHistory ? `
                    <div class="flex justify-between px-5 pb-4">
                        <div class="flex flex-col items-center">
                            <span class="text-xs text-gray-500 mb-1">Biaya:</span>
                            <span class="font-semibold text-green-600">${sparring.cost}</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-xs text-gray-500 mb-1">DP:</span>
                            <span class="font-semibold text-green-600">${sparring.dp}</span>
                        </div>
                    </div>
                ` : `
                    <div class="px-5 pb-4 text-center">
                        <span class="px-4 py-2 rounded-2xl text-sm font-semibold ${getStatusClass(sparring.status)}">
                            ${getStatusText(sparring.status)}
                        </span>
                    </div>
                `}

                <div class="flex gap-3 px-5 pb-5">
                    <button class="flex-1 py-3 px-5 bg-blue-500 text-white rounded-3xl font-semibold cursor-pointer transition-all duration-300 hover:bg-blue-600 hover:-translate-y-1" onclick="viewDetail(${sparring.id})">
                        Detail
                    </button>
                    ${!isHistory ? `
                        <button class="flex-1 py-3 px-5 ${sparring.status === 'joined' ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600 hover:-translate-y-1'} text-white rounded-3xl font-semibold transition-all duration-300" ${sparring.status === 'joined' ? 'disabled' : `onclick="joinSparring(${sparring.id})"`}>
                            ${sparring.status === 'joined' ? 'Sudah Gabung' : 'Gabung'}
                        </button>
                    ` : `
                        <button class="flex-1 py-3 px-5 bg-transparent text-green-600 border-2 border-green-600 rounded-3xl font-semibold transition-all duration-300 hover:bg-green-600 hover:text-white" onclick="handleHistoryAction(${sparring.id}, '${sparring.status}')">
                            ${sparring.status === 'completed' ? 'Sparring Lagi' : 'Lihat Hasil'}
                        </button>
                    `}
                </div>
            </div>
        `;
        return cardHtml;
    }

    function renderFilterButtons() {
        const filters = currentTab === 'sparring' ? sparringFilters : historyFilters;
        const filterButtonsHtml = filters.map(filter => `
            <button class="py-3 px-6 border-2 border-gray-200 bg-white rounded-3xl font-semibold cursor-pointer transition-all duration-300 text-sm hover:border-green-500 hover:-translate-y-1 filter-btn ${currentFilter === filter.value ? 'bg-green-500 text-white border-green-500' : ''}" data-filter="${filter.value}">
                ${filter.label}
            </button>
        `).join('');
        
        document.getElementById('filterButtons').innerHTML = filterButtonsHtml;
        
        // Add event listeners to filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentFilter = this.dataset.filter;
                renderContent();
            });
        });
    }

    function renderContent() {
        renderFilterButtons();
        
        if (currentTab === 'sparring') {
            document.getElementById('sparringContent').classList.remove('hidden');
            document.getElementById('historyContent').classList.add('hidden');
            
            if (!showSparringGrid) {
                document.getElementById('emptyState').classList.remove('hidden');
                document.getElementById('sparringGrid').classList.add('hidden');
            } else {
                document.getElementById('emptyState').classList.add('hidden');
                document.getElementById('sparringGrid').classList.remove('hidden');
                
                const filtered = filterData(activeSparring, currentFilter, searchInput);
                
                if (filtered.length === 0) {
                    document.getElementById('sparringGrid').innerHTML = `
                        <div class="col-span-full text-center py-10 text-gray-500">
                            <div class="text-5xl mb-5">🔍</div>
                            <h3 class="text-2xl mb-3">Tidak ada sparring aktif</h3>
                            <p>Sparring yang tersedia akan muncul di sini</p>
                        </div>
                    `;
                } else {
                    document.getElementById('sparringGrid').innerHTML = filtered.map(sparring => 
                        createSparringCard(sparring, false)
                    ).join('');
                }
            }
        } else {
            document.getElementById('sparringContent').classList.add('hidden');
            document.getElementById('historyContent').classList.remove('hidden');
            
            const filtered = filterData(historySparring, currentFilter, searchInput);
            
            if (filtered.length === 0) {
                document.getElementById('historyGrid').innerHTML = `
                    <div class="col-span-full text-center py-10 text-gray-500">
                        <div class="text-5xl mb-5">📚</div>
                        <h3 class="text-2xl mb-3">Tidak ada riwayat ditemukan</h3>
                        <p>Riwayat sparring Anda akan tersimpan di sini</p>
                    </div>
                `;
            } else {
                document.getElementById('historyGrid').innerHTML = filtered.map(sparring => 
                    createSparringCard(sparring, true)
                ).join('');
            }
        }
    }

    // Event listeners
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.addEventListener('click', function() {
            currentTab = this.dataset.tab;
            currentFilter = 'all';
            searchInput = '';
            document.getElementById('searchInput').value = '';
            
            // Update active tab
            document.querySelectorAll('.tab-button').forEach(b => {
                b.classList.remove('active', 'bg-white', 'border-green-500', 'text-green-500');
            });
            this.classList.add('active', 'bg-white', 'border-green-500', 'text-green-500');
            
            if (currentTab === 'history') {
                showSparringGrid = true;
            }
            
            renderContent();
        });
    });

    document.getElementById('showSparringBtn').addEventListener('click', function() {
        showSparringGrid = true;
        renderContent();
    });

    document.getElementById('searchInput').addEventListener('input', function() {
        searchInput = this.value;
        renderContent();
    });

    // Global functions for button clicks
    window.viewDetail = function(id) {
        console.log('View detail for sparring:', id);
        // Add your detail view logic here
        alert('Detail untuk sparring ID: ' + id);
    };

    window.joinSparring = function(id) {
        console.log('Join sparring:', id);
        // Update status locally
        const sparring = activeSparring.find(s => s.id === id);
        if (sparring) {
            sparring.status = 'joined';
            renderContent();
        }
        alert('Berhasil bergabung dengan sparring ID: ' + id);
    };

    window.handleHistoryAction = function(id, status) {
        if (status === 'completed') {
            console.log('Sparring again:', id);
            alert('Sparring lagi untuk ID: ' + id);
        } else {
            console.log('View result for sparring:', id);
            alert('Lihat hasil untuk sparring ID: ' + id);
        }
    };

    // Initialize
    renderContent();
});
</script>
@endpush
@endsection