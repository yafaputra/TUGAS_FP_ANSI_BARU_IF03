<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SportVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        .floating-shapes .shape {
            animation: float 6s ease-in-out infinite;
        }
        
        .auth-card {
            animation: slideUp 0.6s ease-out;
        }
        
        .loading-spinner {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-5 bg-gradient-to-br from-indigo-600 to-purple-800 relative overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 overflow-hidden z-10">
        <div class="relative w-full h-full">
            <div class="absolute w-20 h-20 bg-white bg-opacity-10 rounded-full top-[10%] left-[10%] animate-float"></div>
            <div class="absolute w-32 h-32 bg-white bg-opacity-10 rounded-full top-[20%] right-[10%] animate-float animation-delay-1000"></div>
            <div class="absolute w-16 h-16 bg-white bg-opacity-10 rounded-full bottom-[30%] left-[15%] animate-float animation-delay-2000"></div>
            <div class="absolute w-24 h-24 bg-white bg-opacity-10 rounded-full bottom-[10%] right-[20%] animate-float animation-delay-3000"></div>
            <div class="absolute w-36 h-36 bg-white bg-opacity-10 rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-float animation-delay-4000"></div>
        </div>
    </div>

    <!-- Auth Card -->
    <div class="w-full max-w-lg bg-white bg-opacity-95 backdrop-blur-xl rounded-3xl p-12 shadow-2xl border border-white border-opacity-20 relative z-20">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="mb-7">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center mx-auto mb-4 text-white shadow-lg hover:scale-105 hover:rotate-6 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">SportVenue</h1>
                <p class="text-gray-500 font-medium mt-1">Book & Play</p>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Welcome Back!</h2>
            <p class="text-gray-600">Sign in to your account to continue</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="mb-9">
            @csrf
            
            <!-- Email Input -->
            <div class="mb-7">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl text-base bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all"
                        placeholder="Enter your email"
                        required
                        value="{{ old('email') }}"
                    />
                </div>
                @error('email')
                    <span class="text-red-500 text-sm font-medium mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-7">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <circle cx="12" cy="16" r="1"/>
                            <path d="m7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl text-base bg-white bg-opacity-90 backdrop-blur-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all"
                        placeholder="Enter your password"
                        required
                    />
                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-emerald-500 transition-colors"
                    >
                        <svg id="show-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                        </svg>
                        <svg id="hide-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm font-medium mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Options -->
            <div class="flex justify-between items-center mb-7">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="hidden">
                    <span class="w-5 h-5 border-2 border-gray-300 rounded flex items-center justify-center mr-2 transition-colors">
                        <svg class="w-3 h-3 text-white hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-gray-700 font-medium">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-emerald-500 font-semibold hover:text-emerald-600 hover:underline transition-colors">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-4 px-6 rounded-xl text-lg font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2"
            >
                <span id="loading-spinner" class="hidden w-5 h-5 border-2 border-white border-opacity-30 rounded-full border-t-white animate-spin"></span>
                <span id="button-text">Sign In</span>
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mb-9">
            <p class="text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-emerald-500 font-semibold hover:text-emerald-600 hover:underline transition-colors">Sign up here</a>
            </p>
        </div>

        <!-- Social Login -->
        <div class="mt-9">
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('login.google') }}" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 rounded-xl font-semibold text-sm hover:border-gray-300 hover:-translate-y-0.5 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </a>
                <a href="{{ route('login.facebook') }}" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 border-2 border-gray-200 rounded-xl font-semibold text-sm hover:border-gray-300 hover:-translate-y-0.5 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24">
                        <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const showIcon = document.getElementById('show-password');
            const hideIcon = document.getElementById('hide-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                hideIcon.classList.add('hidden');
                showIcon.classList.remove('hidden');
            }
        }
        
        // Form submission loading state
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const buttonText = document.getElementById('button-text');
        const loadingSpinner = document.getElementById('loading-spinner');
        
        form.addEventListener('submit', function() {
            submitButton.disabled = true;
            buttonText.textContent = 'Signing In...';
            loadingSpinner.classList.remove('hidden');
        });
        
        // Checkbox functionality
        const checkbox = document.querySelector('input[name="remember"]');
        const checkmark = checkbox.nextElementSibling;
        const checkIcon = checkmark.querySelector('svg');
        
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                checkmark.classList.add('bg-emerald-500', 'border-emerald-500');
                checkIcon.classList.remove('hidden');
            } else {
                checkmark.classList.remove('bg-emerald-500', 'border-emerald-500');
                checkIcon.classList.add('hidden');
            }
        });
    </script>
</body>
</html>