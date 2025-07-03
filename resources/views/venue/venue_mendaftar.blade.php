
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
                                                    <template x-for="(slot, slotIndex) in court.slots" :key="slot.time">
                                                        <div class="text-center p-2 rounded border"
                                                            :class="{
                                                                'bg-emerald-100 border-emerald-500': isSlotSelected(court.court_id, slot.time),
                                                                'bg-white border-gray-200 hover:border-emerald-300 cursor-pointer': slot.available && !isSlotSelected(court.court_id, slot.time),
                                                                'bg-gray-100 border-gray-200 cursor-not-allowed': !slot.available
                                                            }"
                                                            @click="toggleSlot(court.court_id, court.court_name, slot.time, slot.raw_price, slot.start_time_raw, slot.end_time_raw, slotIndex)"
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

                {{-- Ini adalah bagian yang akan dihapus dari venue_mendaftar dan dipindahkan ke booking.checkout --}}
                <div class="w-full lg:w-4/12 px-4 mt-6 lg:mt-0">
                    <div class="card border border-gray-200 shadow-sm rounded-lg mb-6 bg-white sticky-card" id="booking-section">
                        <div class="card-body p-6">
                            <h4 class="text-gray-900 mb-4 text-xl">Detail Booking Anda</h4>

                            <div class="summary-section mb-6 p-4 bg-gray-50 rounded-md border border-gray-100">
                                <h5 class="font-semibold text-gray-800 mb-2">Ringkasan Booking</h5>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-600">Lapangan:</span>
                                    <span class="font-medium text-gray-800" x-text="selectedSlots.length > 0 ? selectedSlots[0].courtName : 'Pilih Lapangan'"></span>
                                </div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-600">Tanggal:</span>
                                    <span class="font-medium text-gray-800" x-text="formatDate(selectedDate)"></span>
                                </div>
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-gray-600">Waktu:</span>
                                    <div class="font-medium text-gray-800 text-right">
                                        <template x-if="selectedSlots.length > 0">
                                            <div x-html="formatSelectedTimes()"></div>
                                        </template>
                                        <template x-if="selectedSlots.length === 0">
                                            <span>Pilih Waktu</span>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Durasi:</span>
                                    <span class="font-medium text-gray-800" x-text="selectedSlots.length + ' jam'"></span>
                                </div>
                                <hr class="my-2 border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total Harga:</span>
                                    <span class="text-xl font-bold text-emerald-500">Rp <span x-text="formatPrice(totalPrice)"></span></span>
                                </div>
                            </div>

                            <button type="button" @click="proceedToCheckout()" class="btn btn-success w-full font-bold py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-lg flex items-center justify-center transition-colors"
                                :disabled="selectedSlots.length === 0">
                                <i class="bi bi-arrow-right me-2"></i>Lanjutkan Booking
                            </button>
                            <p x-show="bookingMessage" x-text="bookingMessage" :class="bookingSuccess ? 'text-green-600' : 'text-red-600'" class="mt-3 text-center"></p>
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
            selectedDate: '{{ \Carbon\Carbon::today('Asia/Jakarta')->toDateString() }}',
            availableCourtSlots: @json($availableSlots ?? []),
            loadingSlots: false,
            selectedSlots: [],
            totalPrice: 0,
            bookingMessage: '',
            bookingSuccess: false,

            init() {
                this.calculateTotalPrice();
            },

            async selectDate(date) {
                this.selectedDate = date;
                this.selectedSlots = [];
                this.calculateTotalPrice();

                this.loadingSlots = true;
                this.availableCourtSlots = [];

                try {
                    const response = await fetch(`{{ route('venue.get-availability', ['id' => $venue->id]) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            date: this.selectedDate
                        })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Gagal memuat ketersediaan lapangan.');
                    }

                    const data = await response.json();
                    this.availableCourtSlots = data;
                } catch (error) {
                    console.error('Error fetching court availability:', error);
                    this.bookingMessage = error.message || 'Terjadi kesalahan saat memuat jadwal lapangan. Mohon coba lagi.';
                    this.bookingSuccess = false;
                    this.availableCourtSlots = [];
                } finally {
                    this.loadingSlots = false;
                }
            },

            isSlotSelected(courtId, time) {
                return this.selectedSlots.some(slot => slot.courtId === courtId && slot.time === time);
            },

            toggleSlot(courtId, courtName, time, rawPrice, startTimeRaw, endTimeRaw, slotIndex) {
                if (rawPrice === 'Booked' || rawPrice === 'Lewat Waktu' || !rawPrice) {
                    this.bookingMessage = `Slot ini ${rawPrice.toLowerCase()} dan tidak bisa dipilih.`;
                    this.bookingSuccess = false;
                    return;
                }

                const selected = this.isSlotSelected(courtId, time);
                const newSlot = { courtId, courtName, time, rawPrice, startTimeRaw, endTimeRaw, slotIndex };

                if (selected) {
                    this.selectedSlots = this.selectedSlots.filter(slot => !(slot.courtId === courtId && slot.time === time));
                } else {
                    if (this.selectedSlots.length > 0 && this.selectedSlots[0].courtId !== courtId) {
                        this.bookingMessage = 'Hanya bisa memilih slot dari satu lapangan yang sama.';
                        this.bookingSuccess = false;
                        return;
                    }

                    let canAdd = true;
                    if (this.selectedSlots.length > 0) {
                        const sortedSelected = [...this.selectedSlots].sort((a, b) => {
                            const timeA = new Date(`2000/01/01 ${a.startTimeRaw}`);
                            const timeB = new Date(`2000/01/01 ${b.startTimeRaw}`);
                            return timeA - timeB;
                        });

                        const lastSelectedSlot = sortedSelected[sortedSelected.length - 1];
                        const firstSelectedSlot = sortedSelected[0];

                        const newSlotHour = parseInt(newSlot.startTimeRaw.split(':')[0]);
                        const lastSelectedHour = parseInt(lastSelectedSlot.startTimeRaw.split(':')[0]);
                        const firstSelectedHour = parseInt(firstSelectedSlot.startTimeRaw.split(':')[0]);

                        const isNextSlot = newSlotHour === (lastSelectedHour + 1);
                        const isPreviousSlot = newSlotHour === (firstSelectedHour - 1);

                        if (!isNextSlot && !isPreviousSlot) {
                            canAdd = false;
                            this.bookingMessage = 'Slot harus berurutan. Pilih slot yang berdekatan.';
                            this.bookingSuccess = false;
                        }
                    }

                    if (canAdd) {
                        this.selectedSlots.push(newSlot);
                    }
                }
                this.calculateTotalPrice();
                this.bookingMessage = '';
            },

            calculateTotalPrice() {
                this.totalPrice = this.selectedSlots.reduce((sum, slot) => sum + slot.rawPrice, 0);
            },

            formatSelectedTimes() {
                if (this.selectedSlots.length === 0) return 'Pilih Waktu';

                const sortedSlots = [...this.selectedSlots].sort((a, b) => {
                    const timeA = new Date(`2000/01/01 ${a.startTimeRaw}`);
                    const timeB = new Date(`2000/01/01 ${b.startTimeRaw}`);
                    return timeA - timeB;
                });

                if (sortedSlots.length === 1) {
                    return sortedSlots[0].time;
                } else {
                    const firstTime = sortedSlots[0].startTimeRaw.substring(0, 5);
                    const lastSlotEndTime = sortedSlots[sortedSlots.length - 1].endTimeRaw.substring(0, 5);
                    return `${firstTime} - ${lastSlotEndTime}`;
                }
            },

            // --- Fungsi BARU untuk melanjutkan ke halaman checkout ---
            proceedToCheckout() {
                if (this.selectedSlots.length === 0) {
                    this.bookingMessage = 'Pilih setidaknya satu slot waktu untuk melanjutkan.';
                    this.bookingSuccess = false;
                    return;
                }

                // Urutkan slot untuk mendapatkan waktu mulai dan selesai booking yang benar
                const sortedSlots = [...this.selectedSlots].sort((a, b) => {
                    const timeA = new Date(`2000/01/01 ${a.startTimeRaw}`);
                    const timeB = new Date(`2000/01/01 ${b.startTimeRaw}`);
                    return timeA - timeB;
                });

                const firstSlot = sortedSlots[0];
                const lastSlot = sortedSlots[sortedSlots.length - 1];

                // Data yang akan dikirim ke halaman checkout
                const checkoutData = {
                    court_id: firstSlot.courtId,
                    booking_date: this.selectedDate,
                    start_time: firstSlot.startTimeRaw,
                    end_time: lastSlot.endTimeRaw,
                    duration_hours: this.selectedSlots.length,
                    total_price: this.totalPrice
                };

                // Bentuk URL dengan query parameters
                const queryParams = new URLSearchParams(checkoutData).toString();
                window.location.href = `{{ route('booking.checkout.show') }}?${queryParams}`;
            },

            // handleBookingSubmit() tidak diperlukan lagi di sini, karena booking akan diproses di halaman checkout
            // Anda bisa menghapus fungsi ini dari script atau membiarkannya (tidak akan terpakai)
            async handleBookingSubmit() {
                // Not used anymore as booking is processed on checkout page
            },

            formatPrice(price) {
                if (typeof price === 'string' && (price === 'Booked' || price === 'Lewat Waktu')) {
                    return price;
                }
                return new Intl.NumberFormat('id-ID').format(price || 0);
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