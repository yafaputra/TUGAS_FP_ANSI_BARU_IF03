<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SportVenue')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#10B981',
                            600: '#059669',
                        }
                    },
                    animation: {
                        'slide-in-right': 'slideInRight 0.3s ease',
                        'fade-in': 'fadeIn 0.3s ease',
                        'slide-down': 'slideDown 0.2s ease-out',
                        'slide-up': 'slideUp 0.2s ease-in',
                    },
                    keyframes: {
                        slideInRight: {
                            'from': { transform: 'translateX(100%)', opacity: '0' },
                            'to': { transform: 'translateX(0)', opacity: '1' },
                        },
                        fadeIn: {
                            'from': { opacity: '0', transform: 'translateY(-10px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            'from': { opacity: '0', transform: 'translateY(-10px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            'from': { opacity: '1', transform: 'translateY(0)' },
                            'to': { opacity: '0', transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style type="text/css">
        .nav-indicator {
            transition: width 0.3s ease;
        }
        .nav-link:hover .nav-indicator {
            width: 60%;
        }
        .router-link-active .nav-indicator {
            width: 80%;
        }
        .mobile-menu-toggle span {
            transition: all 0.3s ease;
            transform-origin: center;
        }
        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }
        a:hover {
            opacity: 0.8;
        }
        .btn-outline-light:hover {
            transform: translateY(-1px);
        }
        
        /* Fixed navbar height to prevent movement */
        .navbar-fixed {
            height: 80px !important;
            transition: all 0.3s ease;
        }
        .navbar-fixed.scrolled {
            height: 64px !important;
            backdrop-filter: blur(10px);
        }
        
        /* Profile dropdown styles */
        .profile-dropdown {
            transform-origin: top right;
        }
        
        /* Smooth dropdown animations */
        .dropdown-enter {
            animation: slideDown 0.2s ease-out forwards;
        }
        .dropdown-leave {
            animation: slideUp 0.2s ease-in forwards;
        }
    </style>
    
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="navbar navbar-fixed fixed top-0 w-full z-50 bg-gradient-to-br from-primary-500 to-primary-600 shadow-lg transition-all duration-300 backdrop-blur-md"
         :class="{ 'scrolled': scrolled }" 
         x-data="{ 
            isMobileMenuOpen: false, 
            scrolled: false,
            profileDropdownOpen: false
         }" 
         @scroll.window="scrolled = window.scrollY > 50"
         @click.outside="profileDropdownOpen = false">
        
        <div class="nav-container max-w-7xl mx-auto px-8 h-full flex justify-between items-center gap-16">
            <!-- Logo Section -->
            <div class="logo flex items-center gap-3 cursor-pointer transition-transform duration-300 hover:scale-105">
                <div class="flex flex-col">
                    <span class="logo-text text-2xl font-extrabold text-white tracking-tighter drop-shadow-md">SportVenue</span>
                    <span class="logo-subtitle text-xs text-white text-opacity-80 font-medium tracking-wider mt-[-0.3rem]">Book & Play</span>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <ul class="nav-links hidden md:flex gap-6 items-center m-0 p-0">
                <li class="nav-item relative">
                    <a href="/home" class="nav-link flex items-center gap-2 px-6 py-3 rounded-2xl text-white font-semibold text-sm relative overflow-hidden hover:bg-white hover:bg-opacity-10 transition-all duration-300 {{ Request::is('home') ? 'bg-white bg-opacity-20 border border-white border-opacity-30' : '' }}">
                        <div class="nav-icon w-4 h-4 opacity-80 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span>Home</span>
                        <div class="nav-indicator absolute bottom-[-2px] left-1/2 transform -translate-x-1/2 w-0 h-1 bg-white rounded-sm"></div>
                    </a>
                </li>
                <li class="nav-item relative">
                    <a href="/venue" class="nav-link flex items-center gap-2 px-6 py-3 rounded-2xl text-white font-semibold text-sm relative overflow-hidden hover:bg-white hover:bg-opacity-10 transition-all duration-300 {{ Request::is('venue') ? 'bg-white bg-opacity-20 border border-white border-opacity-30' : '' }}">
                        <div class="nav-icon w-4 h-4 opacity-80 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                            </svg>
                        </div>
                        <span>Venue</span>
                        <div class="nav-indicator absolute bottom-[-2px] left-1/2 transform -translate-x-1/2 w-0 h-1 bg-white rounded-sm"></div>
                    </a>
                </li>
                <li class="nav-item relative">
                    <a href="/event" class="nav-link flex items-center gap-2 px-6 py-3 rounded-2xl text-white font-semibold text-sm relative overflow-hidden hover:bg-white hover:bg-opacity-10 transition-all duration-300 {{ Request::is('event') ? 'bg-white bg-opacity-20 border border-white border-opacity-30' : '' }}">
                        <div class="nav-icon w-4 h-4 opacity-80 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span>Event</span>
                        <div class="nav-indicator absolute bottom-[-2px] left-1/2 transform -translate-x-1/2 w-0 h-1 bg-white rounded-sm"></div>
                    </a>
                </li>
                <li class="nav-item relative">
                    <a href="/sparring" class="nav-link flex items-center gap-2 px-6 py-3 rounded-2xl text-white font-semibold text-sm relative overflow-hidden hover:bg-white hover:bg-opacity-10 transition-all duration-300 {{ Request::is('sparring') ? 'bg-white bg-opacity-20 border border-white border-opacity-30' : '' }}">
                        <div class="nav-icon w-4 h-4 opacity-80 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span>Sparring</span>
                        <div class="nav-indicator absolute bottom-[-2px] left-1/2 transform -translate-x-1/2 w-0 h-1 bg-white rounded-sm"></div>
                    </a>
                </li>
            </ul>

            <!-- Auth Buttons (Desktop) -->
            @guest
                <div class="auth-buttons hidden md:flex items-center gap-4 ml-10">
                    <a href="/register" class="signup-btn px-5 py-2 rounded-xl font-semibold text-sm cursor-pointer transition-all duration-300 border-2 border-white border-opacity-30 bg-white bg-opacity-15 text-white backdrop-blur-md hover:bg-opacity-25 hover:border-opacity-50 hover:-translate-y-0.5 hover:shadow-lg">
                        Sign Up
                    </a>
                    <a href="/login" class="login-btn px-5 py-2 rounded-xl font-semibold text-sm cursor-pointer transition-all duration-300 border-2 border-white bg-white text-primary-500 hover:bg-gray-50 hover:-translate-y-0.5 hover:shadow-lg">
                        Login
                    </a>
                </div>
            @endguest

            @auth
                <div class="hidden md:flex items-center space-x-4 relative">
                    <span class="text-sm text-white">Welcome, {{ Auth::user()->name }}</span>
                    
                    <!-- Profile Dropdown Button -->
                    <div class="relative">
                        <button 
                            @click="profileDropdownOpen = !profileDropdownOpen"
                            class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50"
                        >
                            <i class="fas fa-user text-white text-sm"></i>
                        </button>
                        
                        <!-- Profile Dropdown Menu -->
                        <div 
                            x-show="profileDropdownOpen" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50 profile-dropdown"
                            style="display: none;"
                        >
                            <div class="py-2">
                                <!-- Profile -->
                                <a href="/profile" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg mr-3">
                                        <i class="fas fa-user-edit text-gray-600 text-sm"></i>
                                    </div>
                                    Profil
                                </a>
                                
                                <!-- Dashboard Venue -->
                                <a href="/dashboard/venue" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg mr-3">
                                        <i class="fas fa-building text-blue-600 text-sm"></i>
                                    </div>
                                    Dashboard Venue
                                </a>
                                
                                <!-- Dashboard Event -->
                                <a href="/dashboard/event" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg mr-3">
                                        <i class="fas fa-calendar-alt text-green-600 text-sm"></i>
                                    </div>
                                    Dashboard Event
                                </a>
                                
                                <!-- Dashboard Sparring -->
                                <a href="/dashboard/sparring" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-lg mr-3">
                                        <i class="fas fa-fist-raised text-orange-600 text-sm"></i>
                                    </div>
                                    Dashboard Sparring
                                </a>
                                
                                <div class="border-t border-gray-100 my-2"></div>
                                
                                <!-- Logout -->
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                        <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg mr-3">
                                            <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                                        </div>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Mobile Menu Toggle -->
            <div class="mobile-menu-toggle md:hidden flex flex-col cursor-pointer gap-1.5 w-8 h-8 justify-center items-center"
                 @click="isMobileMenuOpen = !isMobileMenuOpen" :class="{ 'active': isMobileMenuOpen }">
                <span class="w-6 h-0.5 bg-white rounded-sm"></span>
                <span class="w-6 h-0.5 bg-white rounded-sm"></span>
                <span class="w-6 h-0.5 bg-white rounded-sm"></span>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <ul class="nav-links-mobile fixed top-20 left-0 w-full h-[calc(100vh-5rem)] bg-gradient-to-br from-primary-500 to-primary-600 flex flex-col gap-0 p-0 z-50 backdrop-blur-md hidden"
            :class="{ '!flex': isMobileMenuOpen }" x-show="isMobileMenuOpen" x-transition:enter="animation slide-in-right">
            <li class="nav-item w-full px-5">
                <a href="/home" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                    <div class="nav-icon w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item w-full px-5">
                <a href="/venue" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                    <div class="nav-icon w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/>
                        </svg>
                    </div>
                    <span>Venue</span>
                </a>
            </li>
            <li class="nav-item w-full px-5">
                <a href="/event" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                    <div class="nav-icon w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span>Event</span>
                </a>
            </li>
            <li class="nav-item w-full px-5">
                <a href="/sparring" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                    <div class="nav-icon w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span>Sparring</span>
                    </a>
                </li>
                
                @guest
                    <li class="nav-item w-full px-5">
                        <a href="/login" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                            <div class="nav-icon w-5 h-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <span>Login</span>
                        </a>
                    </li>
                    <li class="nav-item w-full px-5">
                        <a href="/register" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base">
                            <div class="nav-icon w-5 h-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <span>Sign Up</span>
                        </a>
                    </li>
                @endguest
                
                @auth
                    <li class="nav-item w-full px-5 border-b border-white border-opacity-10">
                        <div class="flex items-center gap-3 px-5 py-4">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="font-semibold text-white">{{ Auth::user()->name }}</span>
                        </div>
                    </li>
                    
                    <!-- Mobile Profile Menu Items -->
                   <!-- Mobile Profile Menu Items -->
                    <li class="nav-item w-full px-5">
                        <a href="{{ route('profil.index') }}" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                            <div class="nav-icon w-5 h-5">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <span>Profil</span>
                        </a>
                    </li>
                    <li class="nav-item w-full px-5">
                        <a href="{{ route('venue.dashboard') }}" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                            <div class="nav-icon w-5 h-5">
                                <i class="fas fa-building"></i>
                            </div>
                            <span>Dashboard Venue</span>
                        </a>
                    </li>
                    <li class="nav-item w-full px-5">
                        <a href="/#" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                            <div class="nav-icon w-5 h-5">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <span>Dashboard Event</span>
                        </a>
                    </li>
                    <li class="nav-item w-full px-5">
                        <a href="{{ route('sparring.dashboard') }}" class="nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base border-b border-white border-opacity-10">
                            <div class="nav-icon w-5 h-5">
                                <i class="fas fa-fist-raised"></i>
                            </div>
                            <span>Dashboard Sparring</span>
                        </a>
                    </li>
                    <li class="nav-item w-full px-5">
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left nav-link flex items-center gap-3 px-5 py-4 text-white font-semibold text-base">
                                <div class="nav-icon w-5 h-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>

            <!-- Mobile Overlay -->
            <div class="mobile-overlay fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-40" 
                 x-show="isMobileMenuOpen" @click="isMobileMenuOpen = false">

        <!-- Mobile Overlay -->
        <div class="mobile-overlay fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-40" 
             x-show="isMobileMenuOpen" @click="isMobileMenuOpen = false"></div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-600 text-white py-12" x-data="{ email: '' }">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Venue Info -->
                <div class="col-span-1">
                    
                    <p class="mb-4 text-gray-100">
                        Modern sports facility with premium courts and equipment for all your athletic needs.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">5 Courts</span>
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Open 24/7</span>
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Pro Equipment</span>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="col-span-1">
                    <h6 class="font-semibold mb-4">Facilities</h6>
                    <ul class="space-y-2">
                        @foreach(['Basketball', 'Tennis', 'Badminton', 'Volleyball', 'Fitness Center'] as $facility)
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition">{{ $facility }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-span-1">
                    <h6 class="font-semibold mb-4">Services</h6>
                    <ul class="space-y-2">
                        @foreach(['Court Booking', 'Equipment Rental', 'Personal Training', 'Group Classes', 'Events'] as $service)
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white transition">{{ $service }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact & Booking -->
                <div class="col-span-1">
                    <h6 class="font-semibold mb-4">Contact & Book</h6>
                    <div class="mb-4">
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            123 Sports Street, City Center
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-phone mr-2"></i>
                            <a href="tel:+1234567890" class="hover:underline">(123) 456-7890</a>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope mr-2"></i>
                            <a href="mailto:info@sportzone.com" class="hover:underline">info@sportzone.com</a>
                        </p>
                    </div>
                    <button class="w-full bg-white text-green-600 font-medium py-2 px-4 rounded mb-2 hover:bg-gray-100 transition">
                        <i class="fas fa-calendar-check mr-2"></i>Book Court Now
                    </button>
                    <p class="text-center text-sm text-gray-300">Quick & easy online booking</p>
                </div>
            </div>
        </div>

        <!-- Social & Newsletter -->
        <div class="border-t border-white border-opacity-25 mt-8 pt-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center justify-center md:justify-start">
                            <span class="mr-4">Follow us:</span>
                            <div class="flex space-x-2">
                                <a href="#" class="w-8 h-8 flex items-center justify-center border border-white border-opacity-50 rounded-full hover:bg-white hover:bg-opacity-10 transition">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="w-8 h-8 flex items-center justify-center border border-white border-opacity-50 rounded-full hover:bg-white hover:bg-opacity-10 transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="w-8 h-8 flex items-center justify-center border border-white border-opacity-50 rounded-full hover:bg-white hover:bg-opacity-10 transition">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="w-8 h-8 flex items-center justify-center border border-white border-opacity-50 rounded-full hover:bg-white hover:bg-opacity-10 transition">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-auto">
                        <div class="flex">
                            <input
                                type="email"
                                class="form-input rounded-r-none border-r-0 focus:ring-0 focus:border-gray-300"
                                placeholder="Get updates & offers"
                                x-model="email"
                            >
                            <button class="bg-white text-green-600 px-4 rounded-r hover:bg-gray-100 transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom -->
        <div class="border-t border-white border-opacity-25 mt-6 pt-6">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-3 md:mb-0 text-center md:text-left">
                        <p class="text-gray-300">© 2024 SportZone Arena. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-4 justify-center md:justify-end">
                        <a href="#" class="text-gray-300 hover:text-white transition">Privacy</a>
                        <a href="#" class="text-gray-300 hover:text-white transition">Terms</a>
                        <a href="#" class="text-gray-300 hover:text-white transition">Support</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @stack('scripts')
</body>
</html>