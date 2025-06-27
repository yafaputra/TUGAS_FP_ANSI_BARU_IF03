<!-- atau -->
@extends('layout.headfoot') <!-- Jika file di resources/views/layout/headfoot.blade.php -->

@section('title', 'Halaman Saya') <!-- Optional -->

@section('content')

<section class="bg-gray-50 font-sans">
    <!-- Hero Section -->
    <div class="hero-section bg-gradient-to-br from-green-500 to-green-600 py-16 px-5 text-center relative overflow-hidden">
        <div class="hero-content relative z-10 max-w-6xl mx-auto">
            <h1 class="hero-title text-white text-4xl font-bold mb-8 drop-shadow-md">BOOKING LAPANGAN ONLINE TERBAIK</h1>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container max-w-6xl mx-auto px-5">
        <!-- Search Section -->
        <div class="search-section bg-white p-8 -mt-8 mx-5 mb-8 rounded-xl shadow-xl relative z-10">
            <div class="search-row flex flex-wrap gap-4 items-center">
                <input type="text" class="search-input flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition" placeholder="Cari nama venue" id="venueSearch">
                <input type="text" class="search-input flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition" placeholder="Pilih Kota" id="citySearch">
                <input type="text" class="search-input flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition" placeholder="Pilih Cabang Olahraga" id="sportSearch">
                <button class="filter-btn bg-gray-50 border-2 border-gray-200 p-2 rounded-lg cursor-pointer hover:bg-gray-100 transition" onclick="openFilters()">⚙️</button>
                <button class="search-btn bg-gradient-to-br from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer shadow-md hover:shadow-lg hover:-translate-y-0.5 transition" onclick="searchVenue()">Cari venue</button>
            </div>
        </div>

        <!-- Results Info -->
        <div class="results-info text-gray-600 text-sm my-5">
            Menampilkan <strong>628 venue tersedia</strong>
        </div>

        <!-- Sort Info -->
        <div class="sort-info text-gray-600 text-sm text-right mb-5">
            Urutkan berdasarkan : <strong>Popularitas</strong>
        </div>

        <!-- Venues Grid -->
        <div class="venues-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="venues">
            <!-- Venue Card 1 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=220&fit=crop" alt="Metro Atom Futsal Badminton" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Metro Atom Futsal Badminton</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.89</span>
                        </div>
                        <span>• Kota Jakarta Pusat</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Badminton</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp70.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Metro Atom')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 2 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=220&fit=crop" alt="Centro Sawah Besar" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Centro Sawah Besar</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.70</span>
                        </div>
                        <span>• Kota Jakarta Barat</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp90.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Centro Sawah Besar')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 3 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=220&fit=crop" alt="Gala Sport Asem Reges" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Gala Sport Asem Reges</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.44</span>
                        </div>
                        <span>• Kota Jakarta Barat</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Badminton</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp50.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Gala Sport')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 4 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=220&fit=crop" alt="Olympic Futsal Arena" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Olympic Futsal Arena</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.92</span>
                        </div>
                        <span>• Kota Jakarta Selatan</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Basketball</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp85.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Olympic Futsal')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 5 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=400&h=220&fit=crop" alt="Wisma Badminton Center" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Wisma Badminton Center</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.65</span>
                        </div>
                        <span>• Kota Jakarta Timur</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Badminton</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp45.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Wisma Badminton')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 6 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=220&fit=crop" alt="Grand Slam Tennis Club" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Grand Slam Tennis Club</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.78</span>
                        </div>
                        <span>• Kota Jakarta Utara</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Tennis</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Squash</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp120.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Grand Slam Tennis')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 7 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?w=400&h=220&fit=crop" alt="Victory Basketball Court" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Victory Basketball Court</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.56</span>
                        </div>
                        <span>• Kota Tangerang</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Basketball</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Volleyball</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp60.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Victory Basketball')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 8 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=220&fit=crop" alt="Mega Futsal Complex" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Mega Futsal Complex</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.81</span>
                        </div>
                        <span>• Kota Bekasi</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Mini Soccer</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp75.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Mega Futsal')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 9 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=400&h=220&fit=crop" alt="Elite Badminton Hall" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Elite Badminton Hall</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.73</span>
                        </div>
                        <span>• Kota Depok</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Badminton</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Table Tennis</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp55.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Elite Badminton')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 10 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=220&fit=crop" alt="Champions Sports Arena" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Champions Sports Arena</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.67</span>
                        </div>
                        <span>• Kota Bogor</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Badminton</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Basketball</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp65.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Champions Sports')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 11 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=220&fit=crop" alt="Premier Volleyball Center" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Premier Volleyball Center</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.59</span>
                        </div>
                        <span>• Kota Bandung</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Volleyball</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Basketball</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp80.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Premier Volleyball')">Pesan</button>
                    </div>
                </div>
            </div>

            <!-- Venue Card 12 -->
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=220&fit=crop" alt="Ultimate Sports Complex" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">Ultimate Sports Complex</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>4.85</span>
                        </div>
                        <span>• Kota Surabaya</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Futsal</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Badminton</span>
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">Tennis</span>
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp95.000</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <button class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition" onclick="bookVenue('Ultimate Sports')">Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

    <script>
        function bookVenue(venueName) {
            alert(`Booking ${venueName}! Fitur ini akan mengarahkan ke halaman pemesanan.`);
        }

        function smoothScroll() {
            document.querySelector('#venues').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function searchVenue() {
            const venueSearch = document.getElementById('venueSearch').value;
            const citySearch = document.getElementById('citySearch').value;
            const sportSearch = document.getElementById('sportSearch').value;
            
            if (venueSearch || citySearch || sportSearch) {
                alert(`Mencari venue dengan kriteria:\nVenue: ${venueSearch}\nKota: ${citySearch}\nOlahraga: ${sportSearch}`);
            } else {
                alert('Silakan masukkan kriteria pencarian!');
            }
        }

        function openFilters() {
            alert('Membuka filter pencarian...');
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.search-input').forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchVenue();
                    }
                });
            });
        });
    </script>

