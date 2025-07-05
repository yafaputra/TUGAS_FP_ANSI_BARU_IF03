@extends('layout.headfoot')
@section('title', 'Homepage')
@section('content')
<section class="bg-gray-50">
    <div class="homepage min-h-screen">
        <!-- Hero Section -->
        <section class="hero relative h-[80vh] min-h-[700px] overflow-hidden">
            <div class="hero-content h-full">
                <div class="hero-image relative h-full w-full">
                    <img src="https://wallpapercave.com/wp/wp2940452.jpg"
                         alt="Sport Venue" class="main-hero-img w-full h-full object-cover brightness-50">
                    
                    <!-- Animated Background Elements -->
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/20 via-transparent to-emerald-900/20"></div>
                    <div class="absolute top-20 left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-xl animate-pulse"></div>
                    <div class="absolute bottom-20 right-10 w-24 h-24 bg-blue-500/10 rounded-full blur-xl animate-pulse animation-delay-1000"></div>
                    
                    <div class="hero-overlay absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white z-10 max-w-[700px] px-5">
                        <div class="animate-fade-in-up">
                            <h1 class="hero-title text-5xl md:text-7xl font-black mb-6 leading-tight bg-gradient-to-r from-white via-emerald-100 to-white bg-clip-text text-transparent drop-shadow-2xl">
                                Find Your Perfect Sport Venue
                            </h1>
                            <p class="hero-subtitle text-xl md:text-2xl opacity-95 mb-10 font-light tracking-wide drop-shadow-lg">
                                Booking premium sports facilities for your games and events
                            </p>
                            <button onclick="window.location.href='{{ route('venue.index') }}'" class="cta-button group inline-flex items-center gap-4 bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 text-white border-none px-10 py-5 rounded-full text-lg font-bold cursor-pointer transition-all duration-500 shadow-2xl hover:shadow-emerald-500/25 hover:scale-105 hover:from-emerald-600 hover:to-teal-700 transform hover:-translate-y-1">
                                <span>Explore Venues</span>
                                <svg class="cta-icon w-6 h-6 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="stats py-20 bg-white border-b border-gray-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-50/30 to-teal-50/30"></div>
            <div class="container mx-auto px-5 max-w-6xl relative">
                <div class="stats-grid grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="stat-item group p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="stat-number text-5xl font-black bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent mb-3 group-hover:scale-110 transition-transform duration-300">500+</div>
                        <div class="stat-label text-gray-700 font-semibold text-lg">Premium Venues</div>
                    </div>
                    <div class="stat-item group p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="stat-number text-5xl font-black bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent mb-3 group-hover:scale-110 transition-transform duration-300">10K+</div>
                        <div class="stat-label text-gray-700 font-semibold text-lg">Happy Customers</div>
                    </div>
                    <div class="stat-item group p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="stat-number text-5xl font-black bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent mb-3 group-hover:scale-110 transition-transform duration-300">50+</div>
                        <div class="stat-label text-gray-700 font-semibold text-lg">Cities Available</div>
                    </div>
                    <div class="stat-item group p-6 text-center hover:scale-105 transition-transform duration-300">
                        <div class="stat-number text-5xl font-black bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent mb-3 group-hover:scale-110 transition-transform duration-300">24/7</div>
                        <div class="stat-label text-gray-700 font-semibold text-lg">Customer Support</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Section with Horizontal Scroll -->
        <section class="categories py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            <div class="container mx-auto px-5 max-w-7xl relative">
                <div class="section-header text-center mb-16">
                    <div class="inline-block">
                        <h2 class="section-title text-5xl font-black text-gray-900 mb-6 tracking-tight bg-gradient-to-r from-gray-900 via-emerald-600 to-gray-900 bg-clip-text text-transparent">
                            Choose Your Sport
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-teal-600 mx-auto mb-6 rounded-full"></div>
                    </div>
                    <p class="section-subtitle text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Discover the perfect venue for your favorite sport with our curated selection
                    </p>
                </div>
                
                <!-- Horizontal Scroll Container -->
                <div class="category-scroll-container relative">
                    <!-- Scroll Buttons -->
                    <button class="scroll-btn scroll-left absolute left-0 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg border border-gray-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-white hover:shadow-xl hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button class="scroll-btn scroll-right absolute right-0 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg border border-gray-200 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-white hover:shadow-xl hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    
                    <!-- Scrollable Categories -->
                    <div class="category-scroll overflow-x-auto scrollbar-hide pb-4" style="scroll-behavior: smooth;">
                        <div class="category-grid flex gap-6 px-12" style="width: max-content;">
                            @foreach([
                                ['name' => 'FOOTBALL', 'icon' => '⚽', 'count' => 120, 'image' => 'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300', 'color' => 'from-green-600 to-emerald-700'],
                                ['name' => 'BASKETBALL', 'icon' => '🏀', 'count' => 85, 'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300', 'color' => 'from-orange-600 to-red-700'],
                                ['name' => 'TENNIS', 'icon' => '🎾', 'count' => 95, 'image' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300', 'color' => 'from-yellow-600 to-green-700'],
                                ['name' => 'BADMINTON', 'icon' => '🏸', 'count' => 110, 'image' => 'https://blog.playo.co/wp-content/uploads/2017/04/LCW-jump-smash-1.jpg', 'color' => 'from-blue-600 to-purple-700'],
                                ['name' => 'VOLLEYBALL', 'icon' => '🏐', 'count' => 70, 'image' => 'https://images8.alphacoders.com/575/575648.jpg', 'color' => 'from-pink-600 to-red-700'],
                                ['name' => 'SWIMMING', 'icon' => '🏊‍♂️', 'count' => 45, 'image' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300', 'color' => 'from-cyan-600 to-blue-700'],
                                ['name' => 'BOXING', 'icon' => '🥊', 'count' => 35, 'image' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300', 'color' => 'from-red-600 to-gray-700'],
                            ] as $category)
                            <div class="category-card group relative w-80 h-80 rounded-3xl overflow-hidden cursor-pointer transition-all duration-500 shadow-xl hover:shadow-2xl hover:-translate-y-3 hover:rotate-1 flex-shrink-0">
                                <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="category-img w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                
                                <!-- Gradient Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t {{ $category['color'] }}/70 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                                
                                <!-- Content -->
                                <div class="category-overlay absolute inset-0 flex flex-col justify-end p-8 text-white transform transition-transform duration-300 group-hover:translate-y-0">
                                    <div class="transform transition-transform duration-300 group-hover:-translate-y-2">
                                        <div class="category-icon text-5xl mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">{{ $category['icon'] }}</div>
                                        <h3 class="text-2xl font-black uppercase tracking-wider mb-2 drop-shadow-lg">{{ $category['name'] }}</h3>
                                        <p class="category-count text-sm opacity-90 font-semibold">{{ $category['count'] }} venues available</p>
                                        
                                        <!-- Explore Button (appears on hover) -->
                                        <button class="explore-btn mt-4 bg-white/20 backdrop-blur-sm border border-white/30 text-white px-6 py-2 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white/30 hover:scale-105 transform translate-y-4 group-hover:translate-y-0">
                                            Explore
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Decorative Elements -->
                                <div class="absolute top-4 right-4 w-8 h-8 bg-white/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 animate-pulse"></div>
                                <div class="absolute bottom-4 left-4 w-6 h-6 bg-white/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 animate-pulse animation-delay-300"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recommended Venues Section -->
        <section class="recommended py-24 bg-gradient-to-b from-gray-50 to-white relative">
            <div class="absolute inset-0 bg-dots-pattern opacity-5"></div>
            <div class="container mx-auto px-5 max-w-7xl relative">
                <div class="section-header text-center mb-20">
                    <div class="inline-block">
                        <h2 class="section-title text-5xl font-black text-gray-900 mb-6 tracking-tight bg-gradient-to-r from-gray-900 via-emerald-600 to-gray-900 bg-clip-text text-transparent">
                            Recommended Venues
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-teal-600 mx-auto mb-6 rounded-full"></div>
                    </div>
                    <p class="section-subtitle text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Hand-picked premium venues just for you
                    </p>
                </div>
                <div class="venues-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach([
                        [
                            'name' => 'Green Court Tennis',
                            'category' => 'Tennis',
                            'rating' => 4.8,
                            'reviews' => 124,
                            'location' => 'Jakarta Selatan',
                            'price' => 'Rp 150.000',
                            'features' => ['AC', 'Parking', 'Shower'],
                            'featured' => true,
                            'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'
                        ],
                        [
                            'name' => 'Elite Basketball Court',
                            'category' => 'Basketball',
                            'rating' => 4.9,
                            'reviews' => 89,
                            'location' => 'Jakarta Pusat',
                            'price' => 'Rp 200.000',
                            'features' => ['Indoor', 'Sound System', 'Locker'],
                            'featured' => false,
                            'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'
                        ],
                        [
                            'name' => 'Premium Football Field',
                            'category' => 'Football',
                            'rating' => 4.7,
                            'reviews' => 156,
                            'location' => 'Jakarta Barat',
                            'price' => 'Rp 300.000',
                            'features' => ['Natural Grass', 'Floodlight', 'Cafeteria'],
                            'featured' => true,
                            'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'
                        ],
                        [
                            'name' => 'Indoor Badminton Hall',
                            'category' => 'Badminton',
                            'rating' => 4.6,
                            'reviews' => 203,
                            'location' => 'Jakarta Timur',
                            'price' => 'Rp 120.000',
                            'features' => ['AC', '6 Courts', 'Equipment Rental'],
                            'featured' => false,
                            'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'
                        ],
                        [
                            'name' => 'Modern Volleyball Court',
                            'category' => 'Volleyball',
                            'rating' => 4.8,
                            'reviews' => 67,
                            'location' => 'Jakarta Utara',
                            'price' => 'Rp 180.000',
                            'features' => ['Beach Volleyball', 'Night Light', 'Shower'],
                            'featured' => false,
                            'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'
                        ],
                        [
                            'name' => 'Pro Tennis Academy',
                            'category' => 'Tennis',
                            'rating' => 4.9,
                            'reviews' => 178,
                            'location' => 'Tangerang',
                            'price' => 'Rp 250.000',
                            'features' => ['Coach Available', 'Clay Court', 'Pro Shop'],
                            'featured' => true,
                            'image' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'
                        ]
                    ] as $venue)
                    <div class="venue-card group bg-white rounded-3xl overflow-hidden shadow-lg transition-all duration-500 hover:shadow-2xl hover:-translate-y-3 cursor-pointer border border-gray-100 hover:border-emerald-200">
                        <div class="venue-image relative h-56 overflow-hidden">
                            <img src="{{ $venue['image'] }}" alt="{{ $venue['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @if($venue['featured'])
                            <div class="venue-badge absolute top-4 left-4 bg-gradient-to-r from-amber-400 to-amber-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                                ⭐ Featured
                            </div>
                            @endif
                            <div class="venue-actions absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <button class="action-btn favorite w-10 h-10 rounded-full border-none bg-white/90 backdrop-blur-sm text-gray-600 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-white hover:text-red-500 hover:scale-110 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                <button class="action-btn share w-10 h-10 rounded-full border-none bg-white/90 backdrop-blur-sm text-gray-600 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-white hover:text-emerald-500 hover:scale-110 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="venue-info p-6">
                            <div class="venue-header flex justify-between items-start mb-4">
                                <h3 class="venue-name text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition-colors duration-300">{{ $venue['name'] }}</h3>
                                <div class="venue-category bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold border border-emerald-200">
                                    {{ $venue['category'] }}
                                </div>
                            </div>
                            <div class="venue-rating flex items-center gap-2 mb-4">
                                <div class="stars flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $venue['rating'])
                                        <span class="star-filled text-amber-400 text-sm">⭐</span>
                                        @else
                                        <span class="star-empty text-gray-300 text-sm">⭐</span>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-score font-bold text-emerald-600 text-sm">{{ number_format($venue['rating'], 1) }}</span>
                                <span class="rating-count text-gray-500 text-xs">({{ $venue['reviews'] }} reviews)</span>
                            </div>
                            <div class="venue-features flex flex-wrap gap-2 mb-4">
                                @foreach($venue['features'] as $feature)
                                <span class="feature bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium border border-gray-200">
                                    {{ $feature }}
                                </span>
                                @endforeach
                            </div>
                            <p class="venue-location flex items-center gap-2 text-gray-600 text-sm mb-5">
                                <svg class="location-icon w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $venue['location'] }}
                            </p>
                            <div class="venue-footer flex justify-between items-center">
                                <div class="venue-price flex items-baseline gap-1">
                                    <span class="price text-2xl font-black bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent">{{ $venue['price'] }}</span>
                                    <span class="price-unit text-gray-600 text-sm font-medium">/Sesi</span>
                                </div>
                                <button class="book-btn bg-gradient-to-r from-emerald-500 to-teal-600 text-white border-none px-6 py-3 rounded-full font-bold cursor-pointer transition-all duration-300 hover:shadow-lg hover:scale-105 hover:from-emerald-600 hover:to-teal-700 transform hover:-translate-y-0.5">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        
    </div>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .bg-grid-pattern {
            background-image: radial-gradient(circle, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .bg-dots-pattern {
            background-image: radial-gradient(circle, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Horizontal scroll functionality
            const scrollContainer = document.querySelector('.category-scroll');
            const scrollLeftBtn = document.querySelector('.scroll-left');
            const scrollRightBtn = document.querySelector('.scroll-right');
            const scrollAmount = 400;

            function updateScrollButtons() {
                const isAtStart = scrollContainer.scrollLeft <= 0;
                const isAtEnd = scrollContainer.scrollLeft >= scrollContainer.scrollWidth - scrollContainer.clientWidth;
                
                scrollLeftBtn.disabled = isAtStart;
                scrollRightBtn.disabled = isAtEnd;
            }

            scrollLeftBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            scrollRightBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            scrollContainer.addEventListener('scroll', updateScrollButtons);
            updateScrollButtons();

            // Touch/swipe support for mobile
            let isDown = false;
            let startX;
            let scrollLeft;

            scrollContainer.addEventListener('mousedown', (e) => {
                isDown = true;
                scrollContainer.classList.add('active');
                startX = e.pageX - scrollContainer.offsetLeft;
                scrollLeft = scrollContainer.scrollLeft;
            });

            scrollContainer.addEventListener('mouseleave', () => {
                isDown = false;
                scrollContainer.classList.remove('active');
            });

            scrollContainer.addEventListener('mouseup', () => {
                isDown = false;

                scrollContainer.classList.remove('active');
            });                 


            scrollContainer.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - scrollContainer.offsetLeft;
                const walk = (x - startX) * 2; // Adjust scroll speed
                scrollContainer.scrollLeft = scrollLeft - walk;
            });
            scrollContainer.addEventListener('touchstart', (e) => {
                isDown = true;
                startX = e.touches[0].pageX - scrollContainer.offsetLeft;
                scrollLeft = scrollContainer.scrollLeft;
            });
            scrollContainer.addEventListener('touchmove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.touches[0].pageX - scrollContainer.offsetLeft;
                const walk = (x - startX) * 2; // Adjust scroll speed
                scrollContainer.scrollLeft = scrollLeft - walk;
            });
            scrollContainer.addEventListener('touchend', () => {
                isDown = false;
            });
        });
    </script>
</section>
@endsection