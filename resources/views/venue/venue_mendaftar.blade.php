@extends('layout.headfoot')

@section('title', $venue->name)

@section('content')
<section class="bg-gray-50">
    <div class="container-fluid px-0">
        <section class="hero-section relative overflow-hidden py-8 bg-gray-100">
            <div class="hero-container mx-auto max-w-7xl px-6">
                <div class="hero-image-container rounded-xl overflow-hidden relative h-96 w-full shadow-lg">
                    <img src="{{ $venue->hero_image_url ?? 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80' }}"
                        alt="{{ $venue->name }}" class="hero-image w-full h-full object-cover transition-transform duration-300 hover:scale-102">
                    <div class="hero-overlay absolute inset-0 bg-gradient-to-b from-black/10 via-black/5 to-black/10"></div>
                    <div class="hero-badge absolute bottom-5 right-5 bg-black/70 backdrop-blur-sm px-3 py-1 rounded-full text-white text-sm cursor-pointer transition-all duration-300 hover:bg-black/90 hover:-translate-y-0.5">
                        <span>Lihat semua foto</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mt-4 mx-auto max-w-7xl px-6" x-data="venuePage()">
            <div class="row flex flex-wrap -mx-4">
                <div class="w-full lg:w-8/12 px-4">
                    <div class="venue-header mb-6 p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $venue->name }}</h1>
                        <div class="flex items-center mb-3">
                            <span class="rating-badge me-3 bg-emerald-50 border border-emerald-100 rounded-full px-3 py-1">
                                <i class="bi bi-star-fill text-yellow-400 me-1"></i>
                                <span class="font-bold">{{ $venue->rating ?? 'N/A' }}</span>
                                <span class="text-gray-500 ms-1">({{ $venue->review_count ?? 0 }} reviews)</span>
                            </span>
                            <span class="text-gray-500">
                                <i class="bi bi-geo-alt-fill me-1 text-emerald-500"></i>
                                {{ $venue->city }}, {{ $venue->province }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($venue->facilities as $facility)
                            <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-200 py-2 px-3 rounded-full">
                                <i class="bi bi-{{ str_contains(strtolower($facility), 'futsal') ? 'lightning-charge' : (str_contains(strtolower($facility), 'badminton') ? 'trophy' : 'people-fill') }} me-1"></i>{{ $facility }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border border-gray-200 shadow-sm mb-6 rounded-lg bg-white">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-3 flex items-center">
                                <i class="bi bi-info-circle me-2"></i>Deskripsi
                            </h3>
                            <p class="text-gray-500 mb-3">
                                {{ $venue->description }}
                            </p>

                            @if($venue->facilities)
                            <div class="mt-6">
                                <h5 class="text-emerald-600 mb-3">Fasilitas Utama</h5>
                                <div class="row flex flex-wrap">
                                    @foreach($venue->facilities as $facility)
                                    <div class="w-full md:w-6/12 px-2 mb-3">
                                        <div class="flex items-center">
                                            <i class="bi bi-check-circle-fill text-emerald-500 me-2"></i>
                                            <span class="text-gray-500">{{ $facility }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card border border-gray-200 shadow-sm mb-6 rounded-lg bg-white">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-3 flex items-center">
                                <i class="bi bi-clipboard-check me-2"></i>Aturan Venue
                            </h3>
                            <div class="space-y-3">
                                @if($venue->rules)
                                @foreach($venue->rules as $index => $rule)
                                <div class="w-full">
                                    <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                                        <div class="rule-number me-3 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">{{ $index + 1 }}</div>
                                        <span class="text-gray-500">{{ $rule }}</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card border border-gray-200 shadow-sm mb-6 rounded-lg bg-white">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-4 flex items-center">
                                <i class="bi bi-calendar-check me-2"></i>Pilih Lapangan
                            </h3>

                            <div class="date-selector mb-6 border-b border-gray-100 pb-4">
                                <div class="flex gap-2 overflow-x-auto">
                                    @foreach($dates as $dateItem)
                                    <div class="flex-shrink-0 text-center p-3 rounded-lg border cursor-pointer min-w-16
                                        {{ $dateItem['active'] ? 'bg-red-500 text-white border-red-500' : 'bg-white border-gray-200 hover:border-emerald-300' }}"
                                        @click="selectDate('{{ $dateItem['full_date'] }}')"
                                        :class="{ 'bg-red-500 text-white border-red-500': selectedDate === '{{ $dateItem['full_date'] }}', 'bg-white border-gray-200 hover:border-emerald-300': selectedDate !== '{{ $dateItem['full_date'] }}' }">
                                        <div class="text-xs font-medium" :class="{ 'text-white': selectedDate === '{{ $dateItem['full_date'] }}', 'text-gray-500': selectedDate !== '{{ $dateItem['full_date'] }}' }">{{ $dateItem['day'] }}</div>
                                        <div class="font-bold" :class="{ 'text-white': selectedDate === '{{ $dateItem['full_date'] }}', 'text-gray-900': selectedDate !== '{{ $dateItem['full_date'] }}' }">{{ $dateItem['date'] }}</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-6" x-show="!loadingSlots">
                                <template x-for="court in availableCourtSlots" :key="court.court_id">
                                    <div class="court-card border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <div class="flex flex-col lg:flex-row gap-4">
                                            <div class="w-full lg:w-48 h-32 rounded-lg overflow-hidden">
                                                <img :src="court.image_url" :alt="court.court_name" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="text-lg font-semibold text-gray-900" x-text="court.court_name"></h4>
                                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">Jadwal Tersedia</span>
                                                </div>
                                                <p class="text-sm text-gray-500 mb-1" x-text="court.description"></p>
                                                <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                                    <span x-show="court.court_type">
                                                        <i class="me-1" :class="'bi bi-' + (court.court_type === 'Futsal' ? 'lightning-charge' : 'trophy')"></i>
                                                        <span x-text="court.court_type"></span>
                                                    </span>
                                                    <span x-show="court.is_indoor">
                                                        <i class="bi bi-people me-1"></i>Indoor
                                                    </span>
                                                    <span x-show="court.surface_type">
                                                        <i class="bi bi-gear me-1"></i>
                                                        <span x-text="court.surface_type"></span>
                                                    </span>
                                                </div>

                                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                                                    <template x-for="slot in court.slots" :key="slot.time">
                                                        <div class="text-center p-2 rounded border"
                                                            :class="{
                                                                'bg-emerald-100 border-emerald-500': selectedSlot && selectedSlot.courtId === court.court_id && selectedSlot.time === slot.time,
                                                                'bg-white border-gray-200 hover:border-emerald-300 cursor-pointer': slot.available && !(selectedSlot && selectedSlot.courtId === court.court_id && selectedSlot.time === slot.time),
                                                                'bg-gray-100 border-gray-200 cursor-not-allowed': !slot.available
                                                            }"
                                                            @click="selectSlot(court.court_id, court.court_name, slot.time, slot.raw_price, slot.start_time_raw, slot.end_time_raw)"
                                                            :disabled="!slot.available">
                                                            <div class="text-xs font-medium" :class="{ 'text-gray-900': slot.available, 'text-gray-400': !slot.available }" x-text="slot.time"></div>
                                                            <div class="text-xs" :class="{ 'text-emerald-600 font-semibold': slot.available, 'text-gray-400': !slot.available }" x-text="slot.price"></div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div x-show="loadingSlots" class="text-center py-8">
                                <p class="text-gray-500">Memuat jadwal...</p>
                            </div>
                            <div x-show="!loadingSlots && availableCourtSlots.length === 0" class="text-center py-8">
                                <p class="text-gray-500">Tidak ada lapangan tersedia untuk tanggal ini.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border border-gray-200 shadow-sm rounded-lg bg-white">
                        <div class="card-body p-6">
                            <h3 class="text-xl text-emerald-600 mb-3 flex items-center">
                                <i class="bi bi-geo-alt-fill me-2"></i>Lokasi & Akses
                            </h3>
                            <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-100">
                                <h5 class="text-emerald-600 mb-3">Alamat Lengkap</h5>
                                <p class="text-gray-500 mb-2 flex items-center">
                                    <i class="bi bi-building me-2 text-emerald-500"></i>
                                    {{ $venue->address }}, {{ $venue->city }}, {{ $venue->province }}
                                </p>
                                <p class="text-gray-500 mb-4 flex items-center">
                                    <i class="bi bi-clock me-2 text-emerald-500"></i>
                                    <span class="font-semibold">{{ $venue->opening_hours }}</span> - Buka setiap hari
                                </p>

                                <div class="map-container rounded-lg overflow-hidden mb-4 h-48 bg-gray-100">
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($venue->address . ', ' . $venue->city) }}&zoom=15&size=800x300&maptype=roadmap&markers=color:red%7C{{ urlencode($venue->address . ', ' . $venue->city) }}&key={{ env('MAPS_API_KEY') }}"
                                        alt="Location Map" class="w-full h-full object-cover">
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($venue->address . ', ' . $venue->city) }}" target="_blank" class="btn btn-success rounded-full px-4 py-2 bg-emerald-500 text-white hover:bg-emerald-600 transition-colors flex items-center">
                                        <i class="bi bi-map me-2"></i>Buka di Google Maps
                                    </a>
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($venue->address . ', ' . $venue->city) }}" target="_blank" class="btn btn-outline-success rounded-full px-4 py-2 border border-emerald-500 text-emerald-500 hover:bg-emerald-50 transition-colors flex items-center">
                                        <i class="bi bi-compass me-2"></i>Petunjuk Arah
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-4/12 px-4 mt-6 lg:mt-0">
                    <div class="card border border-gray-200 shadow-sm rounded-lg mb-6 bg-white sticky-card" id="booking-section">
                        <div class="card-body p-6">
                            <h4 class="text-gray-900 mb-4 text-xl">Pesan Lapangan</h4>

                            <div class="price-section mb-6">
                                <p class="text-gray-500 text-sm mb-1">Mulai dari</p>
                                <div class="flex items-baseline">
                                    <span class="text-3xl font-bold text-emerald-500 mb-0">Rp {{ number_format($venue->courts->min('base_price_per_hour') ?? 0, 0, ',', '.') }}</span>
                                    <span class="text-gray-500 ms-2 text-sm">/sesi</span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">*Harga dapat berubah di hari tertentu</p>
                            </div>
                                <button type="submit" class="btn btn-success w-full font-bold py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-lg flex items-center justify-center transition-colors">
                                    <i class="bi bi-cart-fill me-2"></i>Konfirmasi Booking
                                </button>
                                <p x-show="bookingMessage" x-text="bookingMessage" :class="bookingSuccess ? 'text-green-600' : 'text-red-600'" class="mt-3 text-center"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-8">
                <div class="w-full px-4">
                    <div class="card border border-gray-200 shadow-sm rounded-lg bg-white">
                        <div class="card-body p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl text-emerald-600 mb-0 flex items-center">
                                    <i class="bi bi-images me-2"></i>Galeri Foto
                                </h3>
                                <a href="#" class="text-sm text-emerald-500 hover:text-emerald-600">Lihat Semua</a>
                            </div>
                            <div class="row flex flex-wrap -mx-2">
                                @if($venue->gallery_images)
                                @foreach($venue->gallery_images as $photo)
                                <div class="w-6/12 md:w-4/12 lg:w-3/12 px-2 mb-4">
                                    <div class="gallery-item relative rounded-lg overflow-hidden h-48 cursor-pointer transition-all duration-300 hover:scale-102 border border-gray-200 hover:border-emerald-300">
                                        <img src="{{ $photo['url'] ?? 'https://via.placeholder.com/400' }}" alt="{{ $photo['title'] ?? 'Venue Image' }}" class="w-full h-full object-cover transition-all duration-300">
                                        <div class="gallery-overlay absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-0 hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                            <div class="gallery-content text-center transform translate-y-2 hover:translate-y-0 transition-all duration-300">
                                                <i class="bi bi-zoom-in text-white text-xl"></i>
                                                <p class="text-white text-sm mt-2 mb-0">{{ $photo['title'] ?? 'Foto Lapangan' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    function venuePage() {
        return {
            venueId: {{ $venue->id }},
            selectedDate: '{{ \Carbon\Carbon::today()->toDateString() }}',
            availableCourtSlots: @json($availableSlots ?? []), // Data slot awal dari controller
            loadingSlots: false,
            selectedSlot: {
                courtId: null,
                courtName: '',
                time: '',
                price: 0,
                startTimeRaw: '', // Waktu mulai murni untuk booking
                endTimeRaw: ''   // Waktu selesai murni untuk booking
            },
            customerName: '',
            customerPhone: '',
            duration: 1,
            totalPrice: 0,
            bookingMessage: '',
            bookingSuccess: false,

            init() {
                this.calculateTotalPrice(); // Hitung total harga awal jika ada slot default
            },

            async selectDate(date) {
                this.selectedDate = date;
                this.selectedSlot = { courtId: null, courtName: '', time: '', price: 0, startTimeRaw: '', endTimeRaw: '' }; // Reset selected slot
                this.duration = 1; // Reset duration
                this.calculateTotalPrice(); // Recalculate total price

                this.loadingSlots = true;
                try {
                    const response = await fetch('/api/courts/availability', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Penting untuk Laravel
                        },
                        body: JSON.stringify({
                            venue_id: this.venueId,
                            date: this.selectedDate
                        })
                    });
                    if (!response.ok) {
                        throw new Error('Gagal memuat ketersediaan lapangan.');
                    }
                    const data = await response.json();
                    this.availableCourtSlots = data;
                } catch (error) {
                    console.error('Error fetching court availability:', error);
                    alert('Terjadi kesalahan saat memuat jadwal lapangan. Mohon coba lagi.');
                    this.availableCourtSlots = []; // Kosongkan jika ada error
                } finally {
                    this.loadingSlots = false;
                }
            },

            selectSlot(courtId, courtName, time, price, startTimeRaw, endTimeRaw) {
                if (price === 'Booked' || !price) return; // Jangan pilih slot yang sudah dibooking

                this.selectedSlot = { courtId, courtName, time, price, startTimeRaw, endTimeRaw };
                this.calculateTotalPrice();
            },

            calculateTotalPrice() {
                if (this.selectedSlot.price && typeof this.selectedSlot.price === 'number') {
                    this.totalPrice = this.selectedSlot.price * this.duration;
                } else {
                    this.totalPrice = 0;
                }
            },

            async handleBookingSubmit() {
                if (!this.selectedSlot.courtId) {
                    this.bookingMessage = 'Pilih lapangan dan slot waktu terlebih dahulu.';
                    this.bookingSuccess = false;
                    return;
                }

                // Cek apakah data input sudah lengkap
                if (!this.customerName || !this.customerPhone || !this.duration) {
                    this.bookingMessage = 'Mohon lengkapi semua data booking.';
                    this.bookingSuccess = false;
                    return;
                }

                try {
                    const response = await fetch('/api/bookings/process', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            court_id: this.selectedSlot.courtId,
                            booking_date: this.selectedDate,
                            start_time: this.selectedSlot.startTimeRaw, // Gunakan raw start time dari slot
                            duration_hours: this.duration,
                            customer_name: this.customerName,
                            customer_phone: this.customerPhone,
                            total_price: this.totalPrice
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.bookingMessage = data.message;
                        this.bookingSuccess = true;
                        // Reset form
                        this.customerName = '';
                        this.customerPhone = '';
                        this.duration = 1;
                        this.selectedSlot = { courtId: null, courtName: '', time: '', price: 0, startTimeRaw: '', endTimeRaw: '' };
                        
                        // Reload slots untuk tanggal yang dipilih
                        setTimeout(() => {
                            this.selectDate(this.selectedDate);
                        }, 1000);
                        
                        // Redirect ke halaman pembayaran jika ada
                        if (data.redirect_url) {
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 2000);
                        }
                    } else {
                        this.bookingMessage = data.message || 'Booking gagal. Silakan coba lagi.';
                        this.bookingSuccess = false;
                    }
                } catch (error) {
                    console.error('Error during booking:', error);
                    this.bookingMessage = 'Terjadi kesalahan sistem. Mohon coba lagi nanti.';
                    this.bookingSuccess = false;
                }
            },

            formatPrice(price) {
                if (!price) return '0';
                return new Intl.NumberFormat('id-ID').format(price);
            },

            formatDate(dateString) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }
        }
    }
</script>
@endpush
@endsection