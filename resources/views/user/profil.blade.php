@extends('layout.headfoot') <!-- Jika file di resources/views/layout/headfoot.blade.php -->
@section('title', 'Halaman Saya') <!--
Optional -->
@section('content')
<section class="bg-gray-100 p-5">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden" x-data="profileForm()">
        <div class="p-8 border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-gray-800">Profile</h1>
            <p class="text-gray-600 text-sm">Lengkapi profil anda</p>
        </div>

        <div class="p-8">
            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap:</label>
                        <input 
                            type="text" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                            x-model="formData.fullName" 
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Username:</label>
                        <input 
                            type="text" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                            x-model="formData.username" 
                            required
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Bulan Lahir:</label>
                        <select 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                            x-model="formData.birthMonth" 
                            required
                        >
                            <option value="">Pilih Bulan</option>
                            <template x-for="(month, index) in months" :key="index">
                                <option :value="index + 1" x-text="month"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Tahun Lahir:</label>
                        <input 
                            type="number" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                            x-model="formData.birthYear" 
                            min="1900" 
                            :max="currentYear" 
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Lahir:</label>
                        <input 
                            type="number" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                            x-model="formData.birthDay" 
                            min="1" 
                            max="31" 
                            required
                        >
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">No. Handphone:</label>
                    <div class="flex">
                        <div class="flex items-center px-4 py-3 border border-r-0 border-gray-300 rounded-l-lg bg-gray-50 text-gray-700">
                            <div class="w-5 h-4 bg-gradient-to-b from-red-600 via-white to-red-600 rounded-sm mr-2"></div>
                            +62
                        </div>
                        <input 
                            type="tel" 
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                            x-model="formData.phoneNumber" 
                            required
                        >
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Jenis Kelamin:</label>
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

                <div class="mb-8">
                    <h3 class="text-gray-700 font-medium mb-5">Olahraga Favorit:</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <template x-for="sport in sports" :key="sport.id">
                            <div 
                                class="flex flex-col items-center p-4 border-2 rounded-xl cursor-pointer transition-all"
                                :class="{
                                    'border-green-500 bg-green-50': formData.favoriteSports.includes(sport.id),
                                    'border-gray-200 hover:border-green-500 hover:bg-green-50': !formData.favoriteSports.includes(sport.id)
                                }"
                                @click="toggleSport(sport.id)"
                            >
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl mb-2" x-text="sport.emoji"></div>
                                <div class="text-xs font-medium text-gray-700 text-center" x-text="sport.name"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 px-6 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg uppercase tracking-wider transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    :disabled="isSubmitting"
                    :class="{ 'bg-gray-500 hover:bg-gray-500 cursor-not-allowed': isSubmitting }"
                >
                    <span x-text="isSubmitting ? 'MENYIMPAN...' : 'SIMPAN PROFIL'"></span>
                </button>

                <div 
                    class="mt-5 p-3 bg-green-100 border border-green-200 text-green-800 rounded-lg"
                    x-show="showSuccessMessage"
                    x-transition
                >
                    ✓ Profil berhasil disimpan!
                </div>
            </form>
        </div>
    </div>

    <script>
        function profileForm() {
            return {
                formData: {
                    fullName: 'Dito Pratama',
                    username: 'pratamadito210',
                    birthMonth: 6,
                    birthYear: 2025,
                    birthDay: 6,
                    phoneNumber: '000000000',
                    gender: 'female',
                    favoriteSports: []
                },
                months: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],
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
                    { id: 'cycling', name: 'Cycling', emoji: '🚴' },
                    { id: 'fitness', name: 'Fitness', emoji: '💪' }
                ],
                currentYear: new Date().getFullYear(),
                isSubmitting: false,
                showSuccessMessage: false,
                toggleSport(sportId) {
                    if (this.formData.favoriteSports.includes(sportId)) {
                        this.formData.favoriteSports = this.formData.favoriteSports.filter(id => id !== sportId);
                    } else {
                        this.formData.favoriteSports.push(sportId);
                    }
                },
                submitForm() {
                    this.isSubmitting = true;
                    
                    // Simulate API call
                    setTimeout(() => {
                        this.isSubmitting = false;
                        this.showSuccessMessage = true;
                        
                        // Hide success message after 3 seconds
                        setTimeout(() => {
                            this.showSuccessMessage = false;
                        }, 3000);
                        
                        // Scroll to top
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        
                        // You can add actual form submission logic here
                        console.log('Form submitted:', this.formData);
                    }, 1000);
                }
            }
        }
    </script>

</section>
@endsection