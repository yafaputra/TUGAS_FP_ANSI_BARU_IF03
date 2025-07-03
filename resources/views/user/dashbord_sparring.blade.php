@extends('layout.headfoot')
@section('title', 'Dashboard Sparring')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 p-6">
        <h1 class="text-3xl font-bold text-green-600 mb-2">Dashboard Sparring</h1>
        <p class="text-gray-600">Selamat datang, Danu Saputra! Kelola sparring dan lihat riwayat pertandingan Anda.</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex bg-gray-50 border-b border-gray-200">
        <button class="px-6 py-4 text-sm font-medium text-gray-700 border-b-2 border-transparent hover:text-green-600 hover:border-green-300 tab-button active" data-tab="sparring">
            Sparring Mendatang
        </button>
        <button class="px-6 py-4 text-sm font-medium text-gray-700 border-b-2 border-transparent hover:text-green-600 hover:border-green-300 tab-button" data-tab="history">
            Riwayat Sparring
        </button>
    </div>

    <div class="p-6">
        <!-- Search Section -->
        <div class="mb-6">
            <div class="relative max-w-md">
                <input type="text" class="w-full py-2 px-4 pr-10 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Cari sparring disini [ENTER]" id="searchInput">
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">🔍</span>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex gap-2 mb-6 flex-wrap" id="filterButtons">
            <!-- Filter buttons will be populated by JavaScript -->
        </div>

        <!-- Sparring Content -->
        <div id="sparringContent">
            <!-- Empty State -->
            <div class="text-center py-16 text-gray-500" id="emptyState">
                <div class="text-6xl mb-4 opacity-30">⚽</div>
                <h3 class="text-xl mb-2 text-gray-600">Belum Ada Sparring</h3>
                <p class="text-sm text-gray-500 mb-6">Sparring yang Anda ikuti akan muncul di sini.</p>
                <button class="bg-green-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-green-700 transition-colors" id="showSparringBtn">
                    ➕ Lihat Sparring Tersedia
                </button>
            </div>

            <!-- Sparring List -->
            <div class="space-y-4" id="sparringGrid" style="display: none;">
                <!-- Cards will be populated by JavaScript -->
            </div>
        </div>

        <!-- History Content -->
        <div id="historyContent" class="hidden">
            <div class="space-y-4" id="historyGrid">
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
            teamName: "Jakarta Timur FC",
            initials: "JT",
            category: "Sepak Bola",
            level: "Level Putih I",
            rating: "4.88",
            date: "05 Jul 2025",
            time: "20:00",
            location: "Utama, Stadion Inguk Klender",
            cost: "Rp 400.000",
            dp: "Rp 200.000",
            playerCount: "11 vs 11",
            phone: "+6281227026268",
            organizer: "Jakarta Timur FC",
            color: "#3498db",
            status: "available"
        },
        {
            id: 2,
            teamName: "Petakilan FC",
            initials: "PF",
            category: "Futsal",
            level: "Level Perak II",
            rating: "4.79",
            date: "05 Jul 2025",
            time: "20:00",
            location: "Lap B atau G. Halim Futsal & Badminton",
            cost: "Rp 170.000",
            dp: "Rp 0",
            playerCount: "5 vs 5",
            phone: "+6281227026268",
            organizer: "Petakilan FC",
            color: "#e74c3c",
            status: "joined"
        },
        {
            id: 3,
            teamName: "Sucks Ballers",
            initials: "SB",
            category: "Futsal",
            level: "Level Putih I",
            rating: "4.75",
            date: "06 Jul 2025",
            time: "18:50",
            location: "Lapangan Biru, Magnet Arena New",
            cost: "Rp 125.000",
            dp: "Rp 0",
            playerCount: "5 vs 5",
            phone: "+6281227026268",
            organizer: "Sucks Ballers",
            color: "#34495e",
            status: "joined"
        },
        {
            id: 4,
            teamName: "Matador FC",
            initials: "MF",
            category: "Mini Soccer",
            level: "Level Putih I",
            rating: "4.60",
            date: "07 Jul 2025",
            time: "08:00",
            location: "Mini soccer, de King&D30 Arena",
            cost: "TBD",
            dp: "TBD",
            playerCount: "7 vs 7",
            phone: "+6281227026268",
            organizer: "Matador FC",
            color: "#1abc9c",
            status: "available"
        }
    ];

    const historySparring = [
        {
            id: 5,
            teamName: "Champions United",
            initials: "CU",
            category: "Futsal",
            level: "Level Perak I",
            rating: "4.85",
            date: "01 Jul 2025",
            time: "19:00",
            location: "Arena Futsal Premium",
            cost: "Rp 180.000",
            dp: "Rp 50.000",
            playerCount: "5 vs 5",
            phone: "+6281227026268",
            organizer: "Champions United",
            color: "#9b59b6",
            status: "completed",
            result: "Menang 3-2"
        },
        {
            id: 6,
            teamName: "Street Fighters FC",
            initials: "SF",
            category: "Sepak Bola",
            level: "Level Putih II",
            rating: "4.20",
            date: "28 Jun 2025",
            time: "16:00",
            location: "Lapangan Rumput Sintetis",
            cost: "Rp 300.000",
            dp: "Rp 150.000",
            playerCount: "11 vs 11",
            phone: "+6281227026268",
            organizer: "Street Fighters FC",
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
    function getStatusClass(status) {
        const classes = {
            'available': 'bg-blue-100 text-blue-800',
            'joined': 'bg-green-100 text-green-800',
            'completed': 'bg-green-100 text-green-800',
            'cancelled': 'bg-red-100 text-red-800'
        };
        return classes[status] || 'bg-gray-100 text-gray-800';
    }

    function getStatusText(status) {
        const texts = {
            'available': 'Tersedia',
            'joined': 'Sudah Gabung',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan'
        };
        return texts[status] || status;
    }

    function filterData(data, category, search) {
        let filtered = category === 'all' ? data : data.filter(s => s.category === category);
        
        if (search.trim()) {
            const searchLower = search.toLowerCase();
            filtered = filtered.filter(s => 
                s.teamName.toLowerCase().includes(searchLower) ||
                s.category.toLowerCase().includes(searchLower) ||
                s.location.toLowerCase().includes(searchLower) ||
                s.level.toLowerCase().includes(searchLower) ||
                s.organizer.toLowerCase().includes(searchLower)
            );
        }
        
        return filtered;
    }

    function createSparringCard(sparring, isHistory = false) {
        const cardHtml = `
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">${sparring.teamName}</h3>
                            <span class="px-2 py-1 rounded text-xs font-medium ${getStatusClass(sparring.status)}">
                                ${getStatusText(sparring.status)}
                            </span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">
                                ${sparring.level}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Penyelenggara:</strong> ${sparring.organizer}</p>
                            <p><strong>Telepon:</strong> ${sparring.phone}</p>
                            <p><strong>Kategori:</strong> ${sparring.category} (${sparring.playerCount})</p>
                            <p><strong>Lokasi:</strong> ${sparring.location}</p>
                            <p><strong>Jadwal:</strong> ${sparring.date} • ${sparring.time}</p>
                            ${isHistory && sparring.result ? `<p><strong>Hasil:</strong> ${sparring.result}</p>` : ''}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-green-600 mb-1">${sparring.cost}</div>
                        ${sparring.dp !== "TBD" && sparring.dp !== "Rp 0" ? `<div class="text-sm text-gray-500">DP: ${sparring.dp}</div>` : ''}
                        <div class="flex items-center text-sm text-yellow-600 mt-1">
                            <span>⭐ ${sparring.rating}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button class="bg-green-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-green-700 transition-colors" onclick="viewDetail(${sparring.id})">
                        Detail
                    </button>
                    ${!isHistory ? `
                        ${sparring.status === 'available' ? `
                            <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-blue-700 transition-colors" onclick="joinSparring(${sparring.id})">
                                Gabung Sparring
                            </button>
                        ` : sparring.status === 'joined' ? `
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-medium hover:bg-gray-50 transition-colors" onclick="leaveSparring(${sparring.id})">
                                Keluar Sparring
                            </button>
                            <button class="border border-blue-600 text-blue-600 px-4 py-2 rounded text-sm font-medium hover:bg-blue-50 transition-colors" onclick="viewTeamDetails(${sparring.id})">
                                Lihat Tim
                            </button>
                        ` : ''}
                    ` : `
                        ${sparring.status === 'completed' ? `
                            <button class="border border-green-600 text-green-600 px-4 py-2 rounded text-sm font-medium hover:bg-green-50 transition-colors" onclick="sparringAgain(${sparring.id})">
                                Sparring Lagi
                            </button>
                        ` : `
                            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm font-medium hover:bg-gray-50 transition-colors" onclick="viewResult(${sparring.id})">
                                Lihat Detail
                            </button>
                        `}
                    `}
                </div>
            </div>
        `;
        return cardHtml;
    }

    function renderFilterButtons() {
        const filters = currentTab === 'sparring' ? sparringFilters : historyFilters;
        const filterButtonsHtml = filters.map(filter => `
            <button class="px-4 py-2 text-sm font-medium rounded border transition-colors filter-btn ${currentFilter === filter.value ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'}" data-filter="${filter.value}">
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
                document.getElementById('emptyState').style.display = 'block';
                document.getElementById('sparringGrid').style.display = 'none';
            } else {
                document.getElementById('emptyState').style.display = 'none';
                document.getElementById('sparringGrid').style.display = 'block';
                
                const filtered = filterData(activeSparring, currentFilter, searchInput);
                
                if (filtered.length === 0) {
                    document.getElementById('sparringGrid').innerHTML = `
                        <div class="text-center py-10 text-gray-500">
                            <div class="text-4xl mb-4">🔍</div>
                            <h3 class="text-lg mb-2">Tidak ada sparring ditemukan</h3>
                            <p class="text-sm">Coba ubah filter atau kata kunci pencarian</p>
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
                    <div class="text-center py-10 text-gray-500">
                        <div class="text-4xl mb-4">📚</div>
                        <h3 class="text-lg mb-2">Tidak ada riwayat ditemukan</h3>
                        <p class="text-sm">Riwayat sparring Anda akan tersimpan di sini</p>
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
                b.classList.remove('active', 'text-green-600', 'border-green-600');
                b.classList.add('text-gray-700', 'border-transparent');
            });
            this.classList.add('active', 'text-green-600', 'border-green-600');
            this.classList.remove('text-gray-700', 'border-transparent');
            
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
        alert('Detail untuk sparring ID: ' + id);
    };

    window.joinSparring = function(id) {
        console.log('Join sparring:', id);
        // Update status locally for demo
        const sparring = activeSparring.find(s => s.id === id);
        if (sparring) {
            sparring.status = 'joined';
            renderContent();
        }
        alert('Berhasil bergabung dengan sparring ID: ' + id);
    };

    window.leaveSparring = function(id) {
        if (confirm('Apakah Anda yakin ingin keluar dari sparring ini?')) {
            console.log('Leave sparring:', id);
            const sparring = activeSparring.find(s => s.id === id);
            if (sparring) {
                sparring.status = 'available';
                renderContent();
            }
            alert('Anda telah keluar dari sparring ID: ' + id);
        }
    };

    window.viewTeamDetails = function(id) {
        console.log('View team details for sparring:', id);
        alert('Lihat detail tim untuk sparring ID: ' + id);
    };

    window.sparringAgain = function(id) {
        console.log('Sparring again:', id);
        alert('Sparring lagi untuk ID: ' + id);
    };

    window.viewResult = function(id) {
        console.log('View result for sparring:', id);
        alert('Lihat detail hasil untuk sparring ID: ' + id);
    };

    window.viewResult = function(id) {
        console.log('View result for booking:', id);
        alert('Lihat detail untuk booking ID: ' + id);
    };

    // Initialize with active tab styling
    document.querySelector('.tab-button.active').classList.add('text-green-600', 'border-green-600');
    document.querySelector('.tab-button.active').classList.remove('text-gray-700', 'border-transparent');
    
    // Initialize
    renderContent();
});
</script>

<style>
.tab-button.active {
    border-bottom-color: #16a34a !important;
    color: #16a34a !important;
}
</style>
@endpush
@endsection