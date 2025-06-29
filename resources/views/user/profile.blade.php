@extends('layout.headfoot')
@section('title', 'Profil Pengguna')
@section('content')

<style>
    .badge-animate {
        animation: bounce 1.2s infinite alternate;
    }

    @keyframes bounce {
        to {
            transform: translateY(-6px);
        }
    }

    @keyframes progressBar {
        from {
            width: 0;
        }
        to {
            width: 75%;
        }
    }

    .progress-animate {
        animation: progressBar 1.2s cubic-bezier(.4, 2, .6, 1) forwards;
    }
</style>

<section class="bg-gray-50 min-h-screen text-gray-800 font-sans" x-data="profileForm()">
    <div class="max-w-4xl mx-auto px-6 pt-24">

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-green-700">Profil Pengguna</h1>
            <p class="text-gray-600 mt-2">Lengkapi dan perbarui informasi profil Anda untuk pengalaman terbaik di SportVenue.</p>
        </div>

        {{-- Menampilkan pesan status Laravel (jika ada, misal dari `back()->with('status', ...)`) --}}
        @if (session('status'))
            <div class="mt-5 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg">
                ✅ {{ session('status') }}
            </div>
        @endif

        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            {{-- Avatar & Basic Info Section --}}
            <div class="bg-white shadow rounded-lg p-8 mb-6 flex flex-col md:flex-row items-center md:items-start gap-8">
                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <img x-ref="avatarPreview"
                         src="{{ $profil->avatar ? Storage::url($profil->avatar) : '/api/placeholder/120/120' }}" {{-- Gunakan Storage::url untuk avatar --}}
                         alt="Avatar Olahragawan"
                         class="w-32 h-32 rounded-full border-4 border-green-500 shadow-xl object-cover">
                    <label class="absolute bottom-0 right-0 bg-green-600 text-white rounded-full p-2 cursor-pointer hover:bg-green-700 transition transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <input type="file" class="hidden" accept="image/*" @change="handleAvatarChange" x-ref="avatarInput"> {{-- Tambahkan x-ref di sini --}}
                    </label>
                </div>

                {{-- Basic Info Display & Stats --}}
                <div class="flex-grow text-center md:text-left">
                    <div class="font-bold text-green-800 text-3xl mb-2 flex flex-col md:flex-row items-center md:items-start gap-2">
                        <span x-text="formData.fullName || 'Nama Lengkap Atlet'"></span>
                    </div>
                    <p class="text-gray-700 mb-4" x-text="formData.bio || 'Ceritakan tentang semangat dan petualangan olahragamu di sini!'"></p>

                    {{-- User Stats/Progress (Example) --}}
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-gray-700">
                        <div class="flex items-center gap-1 bg-green-50 px-3 py-1 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold">Pencapaian:</span> <span class="text-green-800">Aktif</span>
                        </div>
                        <div class="flex items-center gap-1 bg-green-50 px-3 py-1 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 11.586V6z" clip-rule="evenodd"></path></svg>
                            <span class="font-semibold">Bergabung:</span> <span x-text="formatJoinDate()"></span>
                        </div>
                        <div class="flex items-center gap-1 bg-green-50 px-3 py-1 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zm-6 6C3 12 0 14 0 18h16c0-4-3-6-6-6H7z"></path></svg>
                            <span class="font-semibold">Olahraga Favorit:</span> <span x-text="formData.favoriteSports.length"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Fields Section --}}
            <div class="bg-white shadow rounded-lg p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Profil</h2>

                {{-- Basic Info Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                        <input
                            type="text"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            x-model="formData.fullName"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Username</label>
                        <input
                            type="text"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            x-model="formData.username"
                            required
                        >
                    </div>
                </div>

                {{-- Birth Date as datetime-local --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Lahir</label>
                    <input
                        type="date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        x-model="formData.birthDate"
                        required
                    >
                </div>

                {{-- Phone Number --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">No. Handphone</label>
                    <input
                        type="tel"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        x-model="formData.phoneNumber"
                        placeholder="+62 812-3456-7890"
                        required
                    >
                </div>

                {{-- Email --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input
                        type="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        x-model="formData.email"
                        required
                    >
                </div>

                {{-- Gender --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Jenis Kelamin</label>
                    <div class="flex space-x-6">
                        <div class="flex items-center">
                            <input
                                type="radio"
                                id="male"
                                class="w-5 h-5 text-green-600 focus:ring-green-500"
                                x-model="formData.gender"
                                value="male"
                            >
                            <label for="male" class="ml-2 text-gray-700">Laki-laki</label>
                        </div>
                        <div class="flex items-center">
                            <input
                                type="radio"
                                id="female"
                                class="w-5 h-5 text-green-600 focus:ring-green-500"
                                x-model="formData.gender"
                                value="female"
                            >
                            <label for="female" class="ml-2 text-gray-700">Perempuan</label>
                        </div>
                    </div>
                </div>

                {{-- Bio --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Bio</label>
                    <textarea
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        x-model="formData.bio"
                        rows="3"
                        placeholder="Bagikan cerita olahragamu, tujuan latihan, atau tim favoritmu!"
                    ></textarea>
                </div>
                {{-- Favorite Sports --}}
                <div class="mb-8">
                    <h3 class="text-gray-700 font-medium mb-4">Olahraga Favorit</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <template x-for="sport in sports" :key="sport.id">
                            <div
                                class="flex flex-col items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200"
                                :class="{
                                    'border-green-500 bg-green-50 text-green-800 shadow-md': formData.favoriteSports.includes(sport.id),
                                    'border-gray-200 hover:border-green-400 hover:bg-green-50': !formData.favoriteSports.includes(sport.id)
                                }"
                                @click="toggleSport(sport.id)"
                            >
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-xl mb-2 shadow-sm" x-text="sport.emoji"></div>
                                <div class="text-xs font-medium text-center"
                                    :class="{
                                        'text-green-800': formData.favoriteSports.includes(sport.id),
                                        'text-gray-700': !formData.favoriteSports.includes(sport.id)
                                    }"
                                    x-text="sport.name"></div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Motivational Quote --}}
                <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg text-center font-semibold italic">
                    <span x-text="motivationalQuote"></span>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-between items-center pt-4">
                    <button
                        type="submit"
                        class="bg-green-700 text-white font-bold px-8 py-3 rounded-lg hover:bg-green-800 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center gap-2"
                        :disabled="isSubmitting"
                        :class="{ 'bg-gray-500 hover:bg-gray-500 cursor-not-allowed': isSubmitting }"
                    >
                        <svg x-show="isSubmitting" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                    </button>
                </div>

                {{-- Success/Error Messages --}}
                <div
                    class="mt-5 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg"
                    x-show="showSuccessMessage"
                    x-transition
                >
                    ✅ Profil olahragawan berhasil disimpan!
                </div>

                <div
                    class="mt-5 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg"
                    x-show="showErrorMessage"
                    x-transition
                >
                    ❌ Terjadi kesalahan saat menyimpan data profil.
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    function profileForm() {
        return {
            formData: {
                // Inisialisasi formData dengan data dari backend
                // Pastikan variabel $profil dan $user tersedia dari controller
                avatar: "{{ $profil->avatar ? Storage::url($profil->avatar) : '' }}", // Gunakan Storage::url untuk mendapatkan URL yang benar
                fullName: "{{ $profil->full_name ?? ($user->name ?? '') }}", // Gunakan ($user->name ?? '') untuk menghindari error jika $user->name null
                username: "{{ $profil->username ?? '' }}",
                birthDate: "{{ $profil->birth_date ? $profil->birth_date->format('Y-m-d') : '' }}",
                phoneNumber: "{{ $profil->phone_number ?? '' }}",
                email: "{{ $user->email ?? '' }}", // Email dari tabel users
                gender: "{{ $profil->gender ?? '' }}",
                bio: "{{ $profil->bio ?? '' }}",
                favoriteSports: @json($profil->favorite_sports ?? []), // Konversi array PHP ke JSON string
                joinDate: "{{ $user->created_at->format('Y-m-d') }}" // Tanggal bergabung dari User created_at
            },
            sports: [
                { id: 'soccer', name: 'Mini Soccer', emoji: '⚽' },
                { id: 'badminton', name: 'Badminton', emoji: '🏸' },
                { id: 'basketball', name: 'Bola Basket', emoji: '🏀' },
                { id: 'tennis', name: 'Tenis', emoji: '🎾' },
                { id: 'futsal', name: 'Futsal', emoji: '⚽' },
                { id: 'ping-pong', name: 'Ping Pong', emoji: '🏓' },
                { id: 'volleyball', name: 'Bola Voli', emoji: '🏐' },
                { id: 'baseball', name: 'Baseball', emoji: '⚾' },
                { id: 'swimming', name: 'Renang', emoji: '🏊' },
                { id: 'running', name: 'Lari', emoji: '🏃' },
                { id: 'cycling', name: 'Bersepeda', emoji: '🚴' },
                { id: 'fitness', name: 'Fitness', emoji: '💪' }
            ],
            isSubmitting: false,
            showSuccessMessage: false,
            showErrorMessage: false,
            motivationalQuote: "Setiap latihan adalah investasi untuk performa terbaikmu! 🏆", // Initial quote

            init() {
                // Inisialisasi awal untuk avatar jika ada
                @if($profil->avatar)
                    this.$refs.avatarPreview.src = "{{ Storage::url($profil->avatar) }}";
                @endif
                // Set default quote
                this.motivationalQuote = this.getRandomQuote();
            },

            formatBirthDate() {
                if (!this.formData.birthDate) return 'Tanggal lahir belum diisi';
                const date = new Date(this.formData.birthDate);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString('id-ID', options);
            },

            formatJoinDate() {
                if (!this.formData.joinDate) return '';
                const date = new Date(this.formData.joinDate);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString('id-ID', options);
            },

            toggleSport(sportId) {
                if (this.formData.favoriteSports.includes(sportId)) {
                    this.formData.favoriteSports = this.formData.favoriteSports.filter(id => id !== sportId);
                } else {
                    this.formData.favoriteSports.push(sportId);
                }
            },

            handleAvatarChange(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.$refs.avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    this.formData.avatarFile = file; // Simpan file di formData untuk dikirim
                }
            },

            getRandomQuote() {
                const quotes = [
                    "Setiap latihan adalah investasi untuk performa terbaikmu! 🏆",
                    "Tak ada yang instan, hasil itu dari konsisten! 👟",
                    "Tumbuh kuat, berlatih hebat, raih mimpi sportimu! 🥇",
                    "Jadikan keringatmu motivasi untuk meraih prestasi! ✨",
                    "Batasi dirimu hanya dengan langit dan lapangan! 🚀",
                    "Kalahkan diri sendiri hari ini untuk juara esok hari! 💪"
                ];
                return quotes[Math.floor(Math.random() * quotes.length)];
            },

            submitForm() {
    this.isSubmitting = true;
    this.showSuccessMessage = false;
    this.showErrorMessage = false;

    const data = new FormData();
    
    // Tambahkan CSRF token pertama kali
    data.append('_token', '{{ csrf_token() }}');
    
    // Append semua data kecuali favoriteSports dan avatarFile
    for (const key in this.formData) {
        if (key === 'favoriteSports') {
            this.formData[key].forEach(sportId => {
                data.append('favoriteSports[]', sportId);
            });
        } else if (key !== 'avatarFile') { // Skip avatarFile karena akan ditangani khusus
            data.append(key, this.formData[key]);
        }
    }
    
    // Handle file upload secara khusus
    if (this.$refs.avatarInput.files[0]) {
        data.append('avatar', this.$refs.avatarInput.files[0]);
    }

    fetch("{{ route('profil.update') }}", {
        method: 'POST',
        body: data,
        headers: {
            'Accept': 'application/json',
            // Jangan set Content-Type, biarkan browser mengatur boundary untuk FormData
        },
    })
    .then(response => {
        this.isSubmitting = false;
        if (!response.ok) {
            return response.json().then(errorData => {
                if (errorData.errors) {
                    let errorMessages = Object.values(errorData.errors).flat().join('\n');
                    alert('Validasi gagal:\n' + errorMessages);
                } else if (errorData.message) {
                    alert('Error: ' + errorData.message);
                }
                throw new Error('Terjadi kesalahan saat menyimpan profil.');
            });
        }
        return response.json();
    })
    .then(response => {
        this.showSuccessMessage = true;
        this.motivationalQuote = this.getRandomQuote();
        
        // Jika ada avatar baru di response, update preview
        if (response.profil && response.profil.avatar_url) {
            this.$refs.avatarPreview.src = response.profil.avatar_url;
        }

        setTimeout(() => {
            this.showSuccessMessage = false;
        }, 3000);

        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .catch(error => {
        this.isSubmitting = false;
        this.showErrorMessage = true;
        console.error('Error submitting form:', error);
        setTimeout(() => {
            this.showErrorMessage = false;
        }, 3000);
    });
}
        }
    }
</script>

@endsection