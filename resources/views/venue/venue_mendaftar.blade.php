@extends('layout.headfoot') <!-- Jika file di resources/views/layout/headfoot.blade.php -->

@section('title', 'Halaman Saya') <!-- Optional -->

@section('content')
<section class="bg-gray-50">
    <div class="container-fluid px-0">
        <!-- Hero Section -->
        <section class="hero-section relative overflow-hidden py-8 bg-gray-100">
            <div class="hero-container mx-auto max-w-6xl px-4">
                <div class="hero-image-container rounded-xl overflow-hidden relative h-96 w-full shadow-lg">
                    <img src="https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
                         alt="Badminton Court" class="hero-image w-full h-full object-cover transition-transform duration-300 hover:scale-102">
                    <div class="hero-overlay absolute inset-0 bg-gradient-to-b from-black/10 via-black/5 to-black/10"></div>
                    <div class="hero-badge absolute bottom-5 right-5 bg-black/70 backdrop-blur-sm px-3 py-1 rounded-full text-white text-sm cursor-pointer transition-all duration-300 hover:bg-black/90 hover:-translate-y-0.5">
                        <span>Lihat semua foto</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mt-4 mx-auto px-4">
            <div class="row flex flex-wrap -mx-4">
                <!-- Left Content -->
                <div class="w-full lg:w-8/12 px-4">
                    <!-- Venue Header -->
                    <div class="venue-header mb-6">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Metro Atom Futsal Badminton</h1>
                        <div class="flex items-center mb-3">
                            <span class="rating-badge me-3 bg-emerald-50 border border-emerald-100 rounded-full px-3 py-1">
                                <i class="bi bi-star-fill text-yellow-400 me-1"></i>
                                <span class="font-bold">4.8</span>
                                <span class="text-gray-500 ms-1">(128 reviews)</span>
                            </span>
                            <span class="text-gray-500">
                                <i class="bi bi-geo-alt-fill me-1 text-emerald-500"></i>
                                Kota Jakarta Pusat, DKI Jakarta
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 py-2 px-3 rounded-full">
                                <i class="bi bi-lightning-charge me-1"></i>Futsal
                            </span>
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 py-2 px-3 rounded-full">
                                <i class="bi bi-trophy me-1"></i>Badminton
                            </span>
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 py-2 px-3 rounded-full">
                                <i class="bi bi-people-fill me-1"></i>Lapangan Indoor
                            </span>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="card border-0 shadow-sm mb-6 rounded-lg">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-3 flex items-center">
                                <i class="bi bi-info-circle me-2"></i>Deskripsi
                            </h3>
                            <p class="text-gray-500 mb-3">
                                Metro Atom Futsal Badminton menyediakan fasilitas olahraga berkualitas tinggi dengan lapangan standar internasional. 
                                Dilengkapi dengan sistem pencahayaan optimal dan lantai berkualitas premium untuk pengalaman bermain terbaik.
                            </p>
                            <p class="text-gray-500">
                                Lokasi strategis di pusat kota dengan akses mudah dan fasilitas lengkap termasuk area parkir luas, kantin, dan ruang ganti yang nyaman.
                            </p>
                            
                            <div class="mt-6">
                                <h5 class="text-emerald-600 mb-3">Fasilitas Utama</h5>
                                <div class="row flex flex-wrap">
                                    @foreach([
                                        '3 Lapangan Futsal Standar Internasional',
                                        '6 Lapangan Badminton',
                                        'Pencahayaan LED High Quality',
                                        'Lantai Vinyl Professional',
                                        'Parkir Luas (100+ mobil)',
                                        'Ruang Ganti & Kamar Mandi',
                                        'Kantin & Area Istirahat',
                                        'Free WiFi'
                                    ] as $facility)
                                    <div class="w-full md:w-6/12 px-2 mb-3">
                                        <div class="flex items-center">
                                            <i class="bi bi-check-circle-fill text-emerald-500 me-2"></i>
                                            <span class="text-gray-500">{{ $facility }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Venue Rules -->
                    <div class="card border-0 shadow-sm mb-6 rounded-lg">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-3 flex items-center">
                                <i class="bi bi-clipboard-check me-2"></i>Aturan Venue
                            </h3>
                            <div class="space-y-3">
                                @foreach([
                                    'Pelanggan harus datang tepat waktu sesuai jadwal booking',
                                    'Dilarang membawa air mineral dalam kemasan gelas',
                                    'Dilarang bersandar atau memegang jaring lapangan',
                                    'Dilarang membawa senjata tajam dan minuman beralkohol',
                                    'Wajib menggunakan sepatu olahraga yang sesuai (dilarang sepatu berdempul)',
                                    'Bertanggung jawab atas kerusakan alat/barang yang disewa',
                                    'Dilarang merokok di area dalam ruangan'
                                ] as $index => $rule)
                                <div class="w-full">
                                    <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                                        <div class="rule-number me-3 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">{{ $index + 1 }}</div>
                                        <span class="text-gray-500">{{ $rule }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Location Info -->
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-3 flex items-center">
                                <i class="bi bi-geo-alt-fill me-2"></i>Lokasi & Akses
                            </h3>
                            <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-100">
                                <h5 class="text-emerald-600 mb-3">Alamat Lengkap</h5>
                                <p class="text-gray-500 mb-2 flex items-center">
                                    <i class="bi bi-building me-2 text-emerald-500"></i>
                                    Pd Pasar Jaya Pasar Baru Metro Atom Plaza Lt. B (Gedung Parkir) Jakarta Pusat
                                </p>
                                <p class="text-gray-500 mb-4 flex items-center">
                                    <i class="bi bi-clock me-2 text-emerald-500"></i>
                                    <span class="font-semibold">24 Jam</span> - Buka setiap hari
                                </p>
                                
                                <div class="map-container rounded-lg overflow-hidden mb-4 h-48 bg-gray-100">
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=-6.1754,106.8272&zoom=15&size=800x300&maptype=roadmap&markers=color:red%7C-6.1754,106.8272&key=YOUR_API_KEY" 
                                         alt="Location Map" class="w-full h-full object-cover">
                                </div>
                                
                                <div class="flex flex-wrap gap-2">
                                    <button class="btn btn-success rounded-full px-4 py-2 bg-emerald-500 text-white hover:bg-emerald-600 transition-colors flex items-center">
                                        <i class="bi bi-map me-2"></i>Buka di Google Maps
                                    </button>
                                    <button class="btn btn-outline-success rounded-full px-4 py-2 border border-emerald-500 text-emerald-500 hover:bg-emerald-50 transition-colors flex items-center">
                                        <i class="bi bi-compass me-2"></i>Petunjuk Arah
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="w-full lg:w-4/12 px-4 mt-6 lg:mt-0">
                    <!-- Pricing Card -->
                    <div class="card border-0 shadow-sm rounded-lg mb-6 sticky top-5 z-10">
                        <div class="card-body p-6">
                            <h4 class="text-gray-900 mb-4 text-xl">Pesan Lapangan</h4>
                            
                            <div class="price-section mb-6">
                                <p class="text-gray-500 text-sm mb-1">Mulai dari</p>
                                <div class="flex items-baseline">
                                    <span class="text-3xl font-bold text-emerald-500 mb-0">Rp 70.000</span>
                                    <span class="text-gray-500 ms-2 text-sm">/sesi</span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">*Harga dapat berubah di hari tertentu</p>
                            </div>
                            <button class="btn btn-success w-full font-bold mb-3 py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-lg flex items-center justify-center transition-colors">
                                <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Gallery Section -->
            <div class="row mt-8">
                <div class="w-full px-4">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-body p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl text-emerald-600 mb-0 flex items-center">
                                    <i class="bi bi-images me-2"></i>Galeri Foto
                                </h3>
                                <a href="#" class="text-sm text-emerald-500 hover:text-emerald-600">Lihat Semua</a>
                            </div>
                            <div class="row flex flex-wrap -mx-2">
                                @foreach([
                                    ['title' => 'Lapangan Futsal Utama', 'url' => 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                                    ['title' => 'Lapangan Badminton', 'url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                                    ['title' => 'Area Kantin', 'url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                                    ['title' => 'Area Parkir', 'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                                    ['title' => 'Ruang Ganti', 'url' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                                    ['title' => 'Area Reception', 'url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80']
                                ] as $photo)
                                <div class="w-6/12 md:w-4/12 lg:w-3/12 px-2 mb-4">
                                    <div class="gallery-item relative rounded-lg overflow-hidden h-48 cursor-pointer transition-all duration-300 hover:scale-102 border border-gray-200 hover:border-emerald-300">
                                        <img src="{{ $photo['url'] }}" alt="{{ $photo['title'] }}" class="w-full h-full object-cover transition-all duration-300">
                                        <div class="gallery-overlay absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-0 hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                            <div class="gallery-content text-center transform translate-y-2 hover:translate-y-0 transition-all duration-300">
                                                <i class="bi bi-zoom-in text-white text-xl"></i>
                                                <p class="text-white text-sm mt-2 mb-0">{{ $photo['title'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add any necessary JavaScript -->
    <script>
        // You can add Alpine.js or other JavaScript here if needed
    </script>
</section>
@endsection