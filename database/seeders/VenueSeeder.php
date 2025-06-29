<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $venues = [
            [
                'name' => 'Metro Atom Futsal Badminton',
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=220&fit=crop',
                'rating' => 4.89,
                'city' => 'Jakarta Pusat',
                'categories' => json_encode(['Futsal', 'Badminton']),
                'price_per_session' => 70000,
            ],
            [
                'name' => 'Centro Sawah Besar',
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=220&fit=crop',
                'rating' => 4.70,
                'city' => 'Jakarta Barat',
                'categories' => json_encode(['Futsal']),
                'price_per_session' => 90000,
            ],
            [
                'name' => 'Gala Sport Asem Reges',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=220&fit=crop',
                'rating' => 4.44,
                'city' => 'Jakarta Barat',
                'categories' => json_encode(['Futsal', 'Badminton']),
                'price_per_session' => 50000,
            ],
            [
                'name' => 'Olympic Futsal Arena',
                'image_url' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=220&fit=crop',
                'rating' => 4.92,
                'city' => 'Jakarta Selatan',
                'categories' => json_encode(['Futsal', 'Basketball']),
                'price_per_session' => 85000,
            ],
            [
                'name' => 'Wisma Badminton Center',
                'image_url' => 'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=400&h=220&fit=crop',
                'rating' => 4.65,
                'city' => 'Jakarta Timur',
                'categories' => json_encode(['Badminton']),
                'price_per_session' => 45000,
            ],
            [
                'name' => 'Grand Slam Tennis Club',
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=220&fit=crop',
                'rating' => 4.78,
                'city' => 'Jakarta Utara',
                'categories' => json_encode(['Tennis', 'Squash']),
                'price_per_session' => 120000,
            ],
            [
                'name' => 'Victory Basketball Court',
                'image_url' => 'https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?w=400&h=220&fit=crop',
                'rating' => 4.56,
                'city' => 'Tangerang',
                'categories' => json_encode(['Basketball', 'Volleyball']),
                'price_per_session' => 60000,
            ],
            [
                'name' => 'Mega Futsal Complex',
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=220&fit=crop',
                'rating' => 4.81,
                'city' => 'Bekasi',
                'categories' => json_encode(['Futsal', 'Mini Soccer']),
                'price_per_session' => 75000,
            ],
            [
                'name' => 'Elite Badminton Hall',
                'image_url' => 'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=400&h=220&fit=crop',
                'rating' => 4.73,
                'city' => 'Depok',
                'categories' => json_encode(['Badminton', 'Table Tennis']),
                'price_per_session' => 55000,
            ],
            [
                'name' => 'Champions Sports Arena',
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=220&fit=crop',
                'rating' => 4.67,
                'city' => 'Bogor',
                'categories' => json_encode(['Futsal', 'Badminton', 'Basketball']),
                'price_per_session' => 65000,
            ],
            [
                'name' => 'Premier Volleyball Center',
                'image_url' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=220&fit=crop',
                'rating' => 4.59,
                'city' => 'Bandung',
                'categories' => json_encode(['Volleyball', 'Basketball']),
                'price_per_session' => 80000,
            ],
            [
                'name' => 'Ultimate Sports Complex',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=220&fit=crop',
                'rating' => 4.85,
                'city' => 'Surabaya',
                'categories' => json_encode(['Futsal', 'Badminton', 'Tennis']),
                'price_per_session' => 95000,
            ],
        ];

        DB::table('venues')->insert($venues);
    }
}

