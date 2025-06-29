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
            <form action="{{ route('venue.search') }}" method="GET">
                <div class="search-row flex flex-wrap gap-4 items-center">
                    <input type="text" name="venue" class="search-input flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition" placeholder="Cari nama venue" id="venueSearch">
                    <input type="text" name="city" class="search-input flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition" placeholder="Pilih Kota" id="citySearch">
                    <input type="text" name="sport" class="search-input flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition" placeholder="Pilih Cabang Olahraga" id="sportSearch">
                    <button type="button" class="filter-btn bg-gray-50 border-2 border-gray-200 p-2 rounded-lg cursor-pointer hover:bg-gray-100 transition" onclick="openFilters()">⚙️</button>
                    <button type="submit" class="search-btn bg-gradient-to-br from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer shadow-md hover:shadow-lg hover:-translate-y-0.5 transition">Cari venue</button>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="results-info text-gray-600 text-sm my-5">
            Menampilkan <strong>{{ $venues->count() }} venue tersedia</strong>
        </div>

        <!-- Sort Info -->
        <div class="sort-info text-gray-600 text-sm text-right mb-5">
            Urutkan berdasarkan : <strong>Popularitas</strong>
        </div>

        <!-- Venues Grid -->
        <div class="venues-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="venues">
            @foreach($venues as $venue)
            <div class="venue-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300">
                <img src="{{ $venue->image_url }}" alt="{{ $venue->name }}" class="venue-image w-full h-56 object-cover hover:scale-105 transition duration-300">
                <div class="venue-info p-6">
                    <div class="venue-label text-gray-500 text-sm mb-2">Venue</div>
                    <h3 class="venue-title text-xl font-bold text-gray-800 mb-3">{{ $venue->name }}</h3>
                    <div class="venue-details flex items-center gap-4 text-gray-500 text-sm mb-4">
                        <div class="venue-rating flex items-center gap-1">
                            <span class="star text-yellow-400">★</span>
                            <span>{{ number_format($venue->rating, 2) }}</span>
                        </div>
                        <span>• Kota {{ $venue->city }}</span>
                    </div>
                    <div class="venue-tags flex gap-2 mb-5">
                        @foreach($venue->categories as $category)
                        <span class="tag bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">{{ $category }}</span>
                        @endforeach
                    </div>
                    <div class="venue-footer flex justify-between items-center">
                        <div>
                            <div class="price text-green-500 text-lg font-bold">Rp{{ number_format($venue->price_per_session, 0, ',', '.') }}</div>
                            <div class="price-label text-gray-500 text-xs">/sesi</div>
                        </div>
                        <a href="{{ route('venue.show', $venue->id) }}" class="book-button bg-gradient-to-r from-green-500 to-green-600 text-white border-none px-6 py-3 rounded-lg font-bold cursor-pointer hover:-translate-y-0.5 hover:shadow-md transition">
                            Pesan
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
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

