@extends('layout.headfoot')
@section('title', 'Homepage')
@section('content')
<section class="bg-gray-50">
    <div class="homepage min-h-screen">
        <!-- Hero Section -->
        <section class="hero relative h-[70vh] min-h-[600px] overflow-hidden">
            <div class="hero-content h-full">
                <div class="hero-image relative h-full w-full">
                    <img src="https://tnova.fr/site/assets/files/10962/wesley-tingey-dkckic0bqtu-unsplash.768x512-u0i0s0q90f1.768x512-u0i0s0q90f1.webp?1gvwp6"
                         alt="Sport Venue" class="main-hero-img w-full h-full object-cover brightness-60">
                    <div class="hero-overlay absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white z-10 max-w-[600px] px-5">
                        <h1 class="hero-title text-5xl md:text-6xl font-extrabold mb-5 leading-tight text-shadow-lg">Find Your Perfect Sport Venue</h1>
                        <p class="hero-subtitle text-xl opacity-90 mb-8 text-shadow">Booking premium sports facilities for your games and events</p>
                        <button class="cta-button inline-flex items-center gap-3 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white border-none px-8 py-4 rounded-full text-lg font-semibold cursor-pointer transition-all duration-300 shadow-lg hover:-translate-y-0.5 hover:shadow-xl">
                            <span>Explore Venues</span>
                            <svg class="cta-icon w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="stats py-16 bg-white border-b border-gray-200">
            <div class="container mx-auto px-5 max-w-6xl">
                <div class="stats-grid grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
                    <div class="stat-item p-5">
                        <div class="stat-number text-4xl font-extrabold text-emerald-500 mb-3">500+</div>
                        <div class="stat-label text-gray-600 font-medium">Premium Venues</div>
                    </div>
                    <div class="stat-item p-5">
                        <div class="stat-number text-4xl font-extrabold text-emerald-500 mb-3">10K+</div>
                        <div class="stat-label text-gray-600 font-medium">Happy Customers</div>
                    </div>
                    <div class="stat-item p-5">
                        <div class="stat-number text-4xl font-extrabold text-emerald-500 mb-3">50+</div>
                        <div class="stat-label text-gray-600 font-medium">Cities Available</div>
                    </div>
                    <div class="stat-item p-5">
                        <div class="stat-number text-4xl font-extrabold text-emerald-500 mb-3">24/7</div>
                        <div class="stat-label text-gray-600 font-medium">Customer Support</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Section -->
        <section class="categories py-20 bg-white">
            <div class="container mx-auto px-5 max-w-6xl">
                <div class="section-header text-center mb-16">
                    <h2 class="section-title text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Choose Your Sport</h2>
                    <p class="section-subtitle text-xl text-gray-600">Discover the perfect venue for your favorite sport</p>
                </div>
                <div class="category-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach([
                        ['name' => 'FOOTBALL', 'icon' => '⚽', 'count' => 120, 'image' => 'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300'],
                        ['name' => 'BASKETBALL', 'icon' => '🏀', 'count' => 85, 'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300'],
                        ['name' => 'TENNIS', 'icon' => '🎾', 'count' => 95, 'image' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300'],
                        ['name' => 'BADMINTON', 'icon' => '🏸', 'count' => 110, 'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300'],
                        ['name' => 'VOLLEYBALL', 'icon' => '🏐', 'count' => 70, 'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250'],
                        ['name' => 'SWIMMING', 'icon' => '🏊‍♂️', 'count' => 45, 'image' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300']
                    ] as $category)
                    <div class="category-card relative h-72 rounded-2xl overflow-hidden cursor-pointer transition-all duration-400 shadow-lg hover:-translate-y-2 hover:shadow-xl">
                        <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="category-img w-full h-full object-cover transition-transform duration-400">
                        <div class="category-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-black/30 text-white px-8 py-10 text-center transform transition-transform duration-300">
                            <div class="category-icon text-3xl mb-3">{{ $category['icon'] }}</div>
                            <h3 class="text-xl font-bold uppercase tracking-wider mb-1">{{ $category['name'] }}</h3>
                            <p class="category-count text-sm opacity-80">{{ $category['count'] }} venues</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Recommended Venues Section -->
        <section class="recommended py-20 bg-gray-50">
            <div class="container mx-auto px-5 max-w-6xl">
                <div class="section-header text-center mb-16">
                    <h2 class="section-title text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Recommended Venues</h2>
                    <p class="section-subtitle text-xl text-gray-600">Hand-picked premium venues just for you</p>
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
                    <div class="venue-card bg-white rounded-2xl overflow-hidden shadow-md transition-all duration-400 hover:-translate-y-2 hover:shadow-lg cursor-pointer">
                        <div class="venue-image relative h-56 overflow-hidden">
                            <img src="{{ $venue['image'] }}" alt="{{ $venue['name'] }}" class="w-full h-full object-cover transition-transform duration-400">
                            @if($venue['featured'])
                            <div class="venue-badge absolute top-4 left-4 bg-gradient-to-br from-amber-400 to-amber-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                Featured
                            </div>
                            @endif
                            <div class="venue-actions absolute top-4 right-4 flex gap-2 opacity-0 transition-opacity duration-300">
                                <button class="action-btn favorite w-9 h-9 rounded-full border-none bg-white/90 text-gray-600 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-white hover:text-emerald-500 hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                <button class="action-btn share w-9 h-9 rounded-full border-none bg-white/90 text-gray-600 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-white hover:text-emerald-500 hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="venue-info p-6">
                            <div class="venue-header flex justify-between items-start mb-4">
                                <h3 class="venue-name text-xl font-bold text-gray-900">{{ $venue['name'] }}</h3>
                                <div class="venue-category bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-xs font-semibold">
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
                                <span class="rating-score font-bold text-emerald-500 text-sm">{{ number_format($venue['rating'], 1) }}</span>
                                <span class="rating-count text-gray-500 text-xs">({{ $venue['reviews'] }} reviews)</span>
                            </div>
                            <div class="venue-features flex flex-wrap gap-2 mb-4">
                                @foreach($venue['features'] as $feature)
                                <span class="feature bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-medium">
                                    {{ $feature }}
                                </span>
                                @endforeach
                            </div>
                            <p class="venue-location flex items-center gap-1.5 text-gray-600 text-sm mb-5">
                                <svg class="location-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $venue['location'] }}
                            </p>
                            <div class="venue-footer flex justify-between items-center">
                                <div class="venue-price flex items-baseline gap-1">
                                    <span class="price text-2xl font-extrabold text-emerald-500">{{ $venue['price'] }}</span>
                                    <span class="price-unit text-gray-600 text-sm">/hour</span>
                                </div>
                                <button class="book-btn bg-gradient-to-br from-emerald-500 to-emerald-600 text-white border-none px-5 py-2 rounded-full font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
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

    <script>
        // Add hover effect for venue cards to show actions
        document.querySelectorAll('.venue-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.venue-actions').classList.remove('opacity-0');
            });
            card.addEventListener('mouseleave', function() {
                this.querySelector('.venue-actions').classList.add('opacity-0');
            });
        });
    </script>
</section>
@endsection