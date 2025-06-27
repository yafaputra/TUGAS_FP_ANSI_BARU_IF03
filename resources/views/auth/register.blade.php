<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-5 bg-gradient-to-br from-indigo-600 to-purple-600 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden z-10">
        <div class="relative w-full h-full">
            <div class="absolute w-20 h-20 bg-white bg-opacity-10 rounded-full top-1/4 left-1/4 animate-float"></div>
            <div class="absolute w-32 h-32 bg-white bg-opacity-10 rounded-full top-1/5 right-1/4 animate-float animation-delay-1000"></div>
            <div class="absolute w-16 h-16 bg-white bg-opacity-10 rounded-full bottom-1/3 left-1/5 animate-float animation-delay-2000"></div>
            <div class="absolute w-24 h-24 bg-white bg-opacity-10 rounded-full bottom-1/4 right-1/5 animate-float animation-delay-3000"></div>
            <div class="absolute w-36 h-36 bg-white bg-opacity-10 rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-float animation-delay-4000"></div>
        </div>
    </div>

    <div class="bg-white bg-opacity-95 backdrop-blur-xl rounded-3xl p-12 w-full max-w-2xl shadow-2xl border border-white border-opacity-20 relative z-20 animate-slide-up">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="mb-7">
                <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-5 text-white shadow-lg transition-transform duration-300 hover:scale-105 hover:rotate-6">
                    <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">SportVenue</h1>
                <p class="text-lg text-gray-500 mt-1.5 font-medium">Book & Play</p>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-3 tracking-tight">Create Account</h2>
            <p class="text-gray-500 text-lg leading-relaxed">Join us to book your favorite sports venues</p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="mb-9">
            @csrf
            
            <div class="grid grid-cols-2 gap-5 mb-7">
                <div>
                    <label for="firstName" class="block font-semibold text-gray-700 mb-2.5 text-sm">First Name</label>
                    <div class="relative flex items-center">
                        <div class="absolute left-5 w-5 h-5 text-gray-400 z-10 transition-colors duration-300">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="firstName"
                            name="first_name"
                            class="w-full pl-14 pr-5 py-4.5 border-2 border-gray-200 rounded-xl text-base transition-all duration-300 bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 focus:bg-white"
                            placeholder="First name"
                            required
                            value="{{ old('first_name') }}"
                        />
                    </div>
                    @error('first_name')
                        <span class="text-red-500 text-sm font-medium mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="lastName" class="block font-semibold text-gray-700 mb-2.5 text-sm">Last Name</label>
                    <div class="relative flex items-center">
                        <div class="absolute left-5 w-5 h-5 text-gray-400 z-10 transition-colors duration-300">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="lastName"
                            name="last_name"
                            class="w-full pl-14 pr-5 py-4.5 border-2 border-gray-200 rounded-xl text-base transition-all duration-300 bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 focus:bg-white"
                            placeholder="Last name"
                            required
                            value="{{ old('last_name') }}"
                        />
                    </div>
                    @error('last_name')
                        <span class="text-red-500 text-sm font-medium mt-2 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-7">
                <label for="email" class="block font-semibold text-gray-700 mb-2.5 text-sm">Email Address</label>
                <div class="relative flex items-center">
                    <div class="absolute left-5 w-5 h-5 text-gray-400 z-10 transition-colors duration-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full pl-14 pr-5 py-4.5 border-2 border-gray-200 rounded-xl text-base transition-all duration-300 bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 focus:bg-white"
                        placeholder="Enter your email"
                        required
                        value="{{ old('email') }}"
                    />
                </div>
                @error('email')
                    <span class="text-red-500 text-sm font-medium mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-7">
                <label for="phone" class="block font-semibold text-gray-700 mb-2.5 text-sm">Phone Number</label>
                <div class="relative flex items-center">
                    <div class="absolute left-5 w-5 h-5 text-gray-400 z-10 transition-colors duration-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="w-full pl-14 pr-5 py-4.5 border-2 border-gray-200 rounded-xl text-base transition-all duration-300 bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 focus:bg-white"
                        placeholder="Enter your phone number"
                        required
                        value="{{ old('phone') }}"
                    />
                </div>
                @error('phone')
                    <span class="text-red-500 text-sm font-medium mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-7">
                <label for="password" class="block font-semibold text-gray-700 mb-2.5 text-sm">Password</label>
                <div class="relative flex items-center">
                    <div class="absolute left-5 w-5 h-5 text-gray-400 z-10 transition-colors duration-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <circle cx="12" cy="16" r="1"/>
                            <path d="m7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        id="password"
                        name="password"
                        class="w-full pl-14 pr-14 py-4.5 border-2 border-gray-200 rounded-xl text-base transition-all duration-300 bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 focus:bg-white"
                        placeholder="Create a password"
                        required
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-5 bg-transparent border-none cursor-pointer p-1.5 text-gray-400 transition-colors duration-300 z-10 hover:text-emerald-500"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-show="!showPassword">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-show="showPassword">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm font-medium mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-7">
                <label for="password_confirmation" class="block font-semibold text-gray-700 mb-2.5 text-sm">Confirm Password</label>
                <div class="relative flex items-center">
                    <div class="absolute left-5 w-5 h-5 text-gray-400 z-10 transition-colors duration-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <circle cx="12" cy="16" r="1"/>
                            <path d="m7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input
                        :type="showConfirmPassword ? 'text' : 'password'"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full pl-14 pr-14 py-4.5 border-2 border-gray-200 rounded-xl text-base transition-all duration-300 bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-3 focus:ring-emerald-100 focus:bg-white"
                        placeholder="Confirm your password"
                        required
                    />
                    <button
                        type="button"
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute right-5 bg-transparent border-none cursor-pointer p-1.5 text-gray-400 transition-colors duration-300 z-10 hover:text-emerald-500"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-show="!showConfirmPassword">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" x-show="showConfirmPassword">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-start mb-7">
                <div class="flex items-center h-5">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        class="w-5 h-5 border-2 border-gray-300 rounded focus:ring-emerald-500 text-emerald-600"
                        required
                    />
                </div>
                <label for="terms" class="ml-3 block text-sm text-gray-700 font-medium">
                    I agree to the <a href="#" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors">Terms of Service</a> and <a href="#" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors">Privacy Policy</a>
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-br from-emerald-500 to-emerald-700 text-white border-none py-4.5 px-5 rounded-xl text-lg font-semibold cursor-pointer transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-3 focus:ring-emerald-300 focus:ring-opacity-50 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
                :disabled="isLoading"
            >
                <span class="w-5 h-5 border-2 border-white border-opacity-30 rounded-full border-t-white animate-spin" x-show="isLoading"></span>
                <span x-text="isLoading ? 'Creating Account...' : 'Create Account'"></span>
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mb-9">
            <p class="text-gray-500 text-base">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors">Sign in here</a>
            </p>
        </div>

        <!-- Social Login -->
        <div class="mt-9">
            <div class="relative text-center mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative inline-flex items-center justify-center px-4 bg-white bg-opacity-95 text-sm text-gray-500 font-medium">
                    Or continue with
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('login.google') }}" class="flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 rounded-xl bg-white text-gray-700 font-semibold text-sm cursor-pointer transition-all duration-300 hover:border-gray-300 hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </a>
                <a href="{{ route('login.facebook') }}" class="flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 rounded-xl bg-white text-gray-700 font-semibold text-sm cursor-pointer transition-all duration-300 hover:border-gray-300 hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-opacity-50">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('register', () => ({
            showPassword: false,
            showConfirmPassword: false,
            isLoading: false,
            
            handleRegister() {
                this.isLoading = true;
                // Form submission is handled by Laravel
            }
        }));
    });
</script>
@endpush

@push('styles')
<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.7;
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 1;
        }
    }
    
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-3000 {
        animation-delay: 3s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out;
    }
</style>
@endpush