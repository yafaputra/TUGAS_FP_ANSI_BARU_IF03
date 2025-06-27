@extends('layout.headfoot')

@section('title', 'Cari Lawan Sparring')

@section('content')
<body class="bg-gray-100 font-sans">
    <div class="hero-section bg-gradient-to-br from-green-500 to-green-600 py-16 px-5 text-center relative overflow-hidden">
        <div class="hero-content relative z-10 max-w-6xl mx-auto">
            <h1 class="hero-title text-white text-4xl font-bold mb-8 drop-shadow-md">CARI LAWAN SPARRING</h1>
        </div>
    </div>
    <div class="container mx-auto px-5 max-w-6xl">
        <div class="bg-white p-8 -mt-8 mx-5 mb-8 rounded-xl shadow-xl relative z-20">
            <div class="flex flex-wrap gap-4 items-center">
                <input type="text" class="flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-500 transition-colors" placeholder="Find Sparring Opponents">
                <input type="text" class="flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-500 transition-colors" placeholder="Pilih kota">
                <input type="text" class="flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-500 transition-colors" placeholder="Pilih Cabang Olahraga">
                <button class="bg-gray-50 border-2 border-gray-200 p-2 rounded-lg hover:bg-gray-100 transition-colors" onclick="openFilters()">⚙️</button>
                <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-8 py-3 rounded-lg font-bold cursor-pointer shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all" onclick="searchOpponents()">Cari Lawan</button>
            </div>
        </div>

        <div class="text-gray-600 text-sm my-5">
            Menampilkan <strong class="font-semibold">30 sparring terbuka</strong>
        </div>

        <div class="text-gray-600 text-sm text-right mb-5">
            Urutkan berdasarkan : <strong class="font-semibold">Waktu dan Tanggal</strong>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            <!-- Sepak Bola Card -->
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-lg">JT</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Jakarta Timur Football Community</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">Sepak Bola</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level Putih I</span>
                            <span class="text-yellow-400">⭐ 4.88</span>
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>05 Jun 2025 • 20:00</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>Utama, Stadion Inguk Klender</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">Biaya • 400.000 | Dp • 200.000</div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring()">Gabung</button>
                </div>
            </div>

            <!-- Futsal Card -->
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-red-500 to-red-700 flex items-center justify-center text-white font-bold text-lg">PF</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Petakilan FC</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">Futsal</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level Perak II</span>
                            <span class="text-yellow-400">⭐ 4.79</span>
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>05 Jun 2025 • 20:00</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>Lap B atau G, Halim Futsal &amp; Badminton</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">Biaya • 170.000 | Dp • 0</div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring()">Gabung</button>
                </div>
            </div>

            <!-- Futsal Card 2 -->
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-600 to-gray-700 flex items-center justify-center text-white font-bold text-lg">SB</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Sucks Ballers</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">Futsal</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level Putih I</span>
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>06 Jun 2025 • 18:50</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>Lapangan Biru, Magnet Arena New</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">Biaya • 125.000 | Dp • 0</div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring()">Gabung</button>
                </div>
            </div>

            <!-- Mini Soccer Card -->
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-cyan-500 to-cyan-700 flex items-center justify-center text-white font-bold text-lg">MF</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Matador FC</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">Mini Soccer</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level Putih I</span>
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>07 Jun 2025 • 08:00</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>Mini soccer, de King&amp;D30 Arena (Futsal and Mini Soccer)</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">Biaya • TBD</div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring()">Gabung</button>
                </div>
            </div>

            <!-- Mini Soccer Card 2 -->
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-gray-800 to-gray-900 flex items-center justify-center text-white font-bold text-lg">SC</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">SPONTAN CHUY FC</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">Mini Soccer</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level Putih I</span>
                            <span class="text-yellow-400">⭐ 5.00</span>
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>07 Jun 2025 • 15:30</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>lap. Fuerza Arena</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">Biaya • TBD</div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring()">Gabung</button>
                </div>
            </div>

            <!-- Mini Soccer Card 3 -->
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-500 to-teal-500 flex items-center justify-center text-white font-bold text-lg">SK</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Southawla KSB</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">Mini Soccer</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level Putih I</span>
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>07 Jun 2025 • 16:00</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>Lapangan A, Jonas Mini Soccer</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">Biaya • TBD</div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring()">Gabung</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchOpponents() {
            alert('Mencari lawan sparring...');
        }

        function joinSparring() {
            alert('Bergabung dengan sparring ini!');
        }

        function openFilters() {
            alert('Membuka filter pencarian...');
        }
    </script>
</section>
@endsection