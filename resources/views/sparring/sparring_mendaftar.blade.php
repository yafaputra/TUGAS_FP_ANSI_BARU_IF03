@extends('layout.headfoot') <!-- Jika file di resources/views/layout/headfoot.blade.php -->

@section('title', 'Halaman Saya') <!-- Optional -->

@section('content')

<section class="bg-gray-100 font-sans text-gray-800">
    <div class="container mx-auto px-4 py-5 max-w-6xl">
        <!-- Main Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
            <!-- Left Section -->
            <div class="md:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
                <!-- Team Header -->
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-green-800 flex items-center justify-center text-white font-bold text-xl relative">
                            SB
                            <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs">!</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Sucks Ballers</h1>
                            <div class="flex items-center gap-5 text-gray-600 text-sm mt-1">
                                <span><i class="fas fa-futbol mr-1"></i> Futsal</span>
                                <span><i class="fas fa-map-marker-alt mr-1"></i> Kota Jakarta Utara</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Section -->
                <div class="p-5">
                    <h3 class="text-lg font-medium mb-3">Lokasi Venue</h3>
                    <p class="text-gray-600 text-sm mb-5 leading-relaxed">
                        Batas No.32-46, RW.1, Kapuk Muara, Kec. Penjaringan, Jkt Utara, Daerah Khusus Ibukota Jakarta 14460, Indonesia
                    </p>

                    <!-- Map Container -->
                    <div class="h-72 bg-blue-50 rounded-lg relative overflow-hidden">
                        <!-- Map Controls -->
                        <div class="absolute top-3 left-3 flex bg-white rounded-md shadow-sm overflow-hidden">
                            <button class="px-4 py-2 text-sm bg-white" :class="{ 'bg-gray-100 font-medium': mapView === 'map' }" @click="mapView = 'map'">
                                Peta
                            </button>
                            <button class="px-4 py-2 text-sm bg-white" :class="{ 'bg-gray-100 font-medium': mapView === 'satellite' }" @click="mapView = 'satellite'">
                                Satelit
                            </button>
                        </div>
                        
                        <!-- Map Tools -->
                        <div class="absolute top-3 right-3 flex flex-col gap-1">
                            <button class="w-8 h-8 bg-white rounded flex items-center justify-center shadow-sm">
                                <i class="fas fa-expand text-gray-600 text-sm"></i>
                            </button>
                            <button class="w-8 h-8 bg-white rounded flex items-center justify-center shadow-sm">
                                <i class="fas fa-compress text-gray-600 text-sm"></i>
                            </button>
                            <button class="w-8 h-8 bg-white rounded flex items-center justify-center shadow-sm">
                                <i class="fas fa-street-view text-gray-600 text-sm"></i>
                            </button>
                        </div>

                        <!-- Google Logo -->
                        <div class="absolute bottom-3 left-3 text-xs text-gray-600">
                            <i class="fab fa-google mr-1"></i> Google
                        </div>

                        <!-- Map Info -->
                        <div class="absolute bottom-3 right-3 text-xs text-gray-600 flex gap-2">
                            <span>Pintasan keyboard</span>
                            <span>Data peta ©2025</span>
                            <span>Persyaratan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex flex-col gap-5">
                <!-- Price Card -->
                <div class="bg-white rounded-xl shadow-sm p-5 text-right">
                    <div class="text-2xl font-bold mb-4">Rp. 125.000</div>
                    <button class="w-full py-3 bg-primary hover:bg-primary-hover text-white font-semibold rounded-lg flex items-center justify-center gap-2 transition-colors" @click="bookSparing">
                        Ambil Sparing <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Details Card -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <!-- Date Item -->
                    <div class="flex gap-4 mb-5">
                        <div class="text-gray-600 mt-1">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-sm mb-1">Waktu & Tanggal</h4>
                            <p class="text-gray-600 text-sm">Friday, 06 Jun 2025 • 18:50 - 20:00</p>
                        </div>
                    </div>

                    <!-- Location Item -->
                    <div class="flex gap-4">
                        <div class="text-gray-600 mt-1">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-sm mb-1">Lokasi</h4>
                            <p class="text-gray-600 text-sm">
                                Lapangan Biru, Magnet Arena New<br>
                                Kota Jakarta Utara, Daerah Khusus<br>
                                Ibukota Jakarta
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sparing List -->
        <div class="mt-8 space-y-4">
            
            <div class="bg-white rounded-xl shadow-sm p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-semibold text-lg">Garuda FC vs Red Eagles</h3>
                    <div class="text-gray-600 text-sm mt-1">
                        <p><i class="fas fa-calendar mr-1"></i>Sabtu, 8 Juni 2025 • 16:00-18:00</p>
                        <p><i class="fas fa-map-marker-alt mr-1"></i>'Lapangan Senayan, Jakarta Pusat'</p>
                    </div>
                </div>
                <div class="flex gap-2 self-end md:self-auto">
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm">
                        Detail
                    </button>
                    <button class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-md text-sm flex items-center gap-1" >
                        <i class="fas fa-handshake"></i> Gabung
                    </button>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-semibold text-lg">Bintang United vs Thunder Bolts</h3>
                    <div class="text-gray-600 text-sm mt-1">
                        <p><i class="fas fa-calendar mr-1"></i> 'Minggu, 9 Juni 2025 • 08:00-10:00'</p>
                        <p><i class="fas fa-map-marker-alt mr-1"></i>'Lapangan Bintaro, Tangerang'</p>
                    </div>
                </div>
                <div class="flex gap-2 self-end md:self-auto">
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm">
                        Detail
                    </button>
                    <button class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-md text-sm flex items-center gap-1" >
                        <i class="fas fa-handshake"></i> Gabung
                    </button>
                </div>
            </div>
            
            
        </div>

        <!-- Floating Button -->
        <button class="fixed bottom-8 right-8 w-14 h-14 bg-primary hover:bg-primary-hover text-white rounded-full shadow-lg flex items-center justify-center text-xl transition-all hover:scale-105" @click="showModal = true">
            <i class="fas fa-plus"></i>
        </button>

    
    </div>
    <!-- Alpine JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sparingApp', () => ({
                mapView: 'map',
                showModal: false,
                minDate: new Date().toISOString().split('T')[0],
                matches: [
                    {
                        name: 'Garuda FC vs Red Eagles',
                        date: 'Sabtu, 8 Juni 2025 • 16:00-18:00',
                        location: 'Lapangan Senayan, Jakarta Pusat'
                    },
                    {
                        name: 'Bintang United vs Thunder Bolts',
                        date: 'Minggu, 9 Juni 2025 • 08:00-10:00',
                        location: 'Lapangan Bintaro, Tangerang'
                    }
                ],
                newSparing: {
                    teamName: '',
                    date: '',
                    time: '',
                    location: '',
                    price: '',
                    notes: ''
                },
                
                bookSparing() {
                    if (confirm('Apakah Anda yakin ingin mengambil sparing ini?')) {
                        alert('Sparing berhasil diambil! Anda akan mendapat konfirmasi lebih lanjut.');
                    }
                },
                
                joinMatch(matchName) {
                    if (confirm(`Apakah Anda yakin ingin bergabung dengan ${matchName}?`)) {
                        alert(`Permintaan bergabung dengan ${matchName} telah dikirim!`);
                    }
                },
                
                createNewSparing() {
                    // Format the date for display
                    const formattedDate = new Date(this.newSparing.date).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) + ' • ' + this.newSparing.time;
                    
                    // Add new match to the list
                    this.matches.unshift({
                        name: this.newSparing.teamName,
                        date: formattedDate,
                        location: this.newSparing.location
                    });
                    
                    alert('Sparing baru berhasil dibuat! Tim lain dapat melihat dan bergabung.');
                    this.showModal = false;
                    this.resetForm();
                },
                
                resetForm() {
                    this.newSparing = {
                        teamName: '',
                        date: '',
                        time: '',
                        location: '',
                        price: '',
                        notes: ''
                    };
                }
            }));
        });
    </script>

</section>
@endsection
    

