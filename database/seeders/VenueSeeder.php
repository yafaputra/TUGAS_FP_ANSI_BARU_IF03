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
                'image_url' => 'https://superlive.id/storage/articles/b3cb4280-362c-4058-aa64-e0b4a0f7aab8.jpg', // Futsal court
                'rating' => 4.89,
                'city' => 'Jakarta Pusat',
                'categories' => json_encode(['Futsal', 'Badminton']),
                'price_per_session' => 70000,
            ],
            [
                'name' => 'Centro Sawah Besar',
                'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk3uWOfoAXZ-d1i6-PDAiIiHdYdw2vFFmjAJJ-fj_gxNAi0pqyQ4GMwVK9kR5FoNWZxWY&usqp=CAU', // Futsal court
                'rating' => 4.70,
                'city' => 'Jakarta Barat',
                'categories' => json_encode(['Futsal']),
                'price_per_session' => 90000,
            ],
            [
                'name' => 'Gala Sport Asem Reges',
                'image_url' => 'https://asset-2.tstatic.net/bangkaposwiki/foto/bank/images/12022020_lapangan-bulutangkis.jpg', // Multi-sport facility
                'rating' => 4.44,
                'city' => 'Jakarta Barat',
                'categories' => json_encode(['Futsal', 'Badminton']),
                'price_per_session' => 50000,
            ],
            [
                'name' => 'Olympic Futsal Arena',
                'image_url' => 'https://image.idntimes.com/post/20200914/lapangan-futsal-94db8dd85c516f7bffe3836900ae1e6e.jpg', // Futsal court
                'rating' => 4.92,
                'city' => 'Jakarta Selatan',
                'categories' => json_encode(['Futsal', 'Basketball']),
                'price_per_session' => 85000,
            ],
            [
                'name' => 'Wisma Badminton Center',
                'image_url' => 'https://jasakontraktorlapangan.id/wp-content/uploads/2023/05/Analisa-Bisnis-Lapangan-Badminton.jpg', // Badminton court
                'rating' => 4.65,
                'city' => 'Jakarta Timur',
                'categories' => json_encode(['Badminton']),
                'price_per_session' => 45000,
            ],
            [
                'name' => 'Grand Slam Tennis Club',
                'image_url' => 'https://mediaini.com/wp-content/uploads/2022/02/daftar-lapangan-tenis-di-Bandung-by-Pixabay-640x375.jpg', // Tennis court
                'rating' => 4.78,
                'city' => 'Jakarta Utara',
                'categories' => json_encode(['Tennis', 'Squash']),
                'price_per_session' => 120000,
            ],
            [
                'name' => 'Victory Basketball Court',
                'image_url' => 'https://centroflor.id/wp-content/uploads/2023/09/Karpet-Lapangan-Basket.jpg', // Basketball court
                'rating' => 4.56,
                'city' => 'Tangerang',
                'categories' => json_encode(['Basketball', 'Volleyball']),
                'price_per_session' => 60000,
            ],
            [
                'name' => 'Mega Futsal Complex',
                'image_url' => 'https://jasakontraktorlapangan.id/wp-content/uploads/2023/05/Analisa-Bisnis-Lapangan-Futsal.jpg', // Futsal court
                'rating' => 4.81,
                'city' => 'Bekasi',
                'categories' => json_encode(['Futsal', 'Mini Soccer']),
                'price_per_session' => 75000,
            ],
            [
                'name' => 'Elite Badminton Hall',
                'image_url' => 'https://asset.ayo.co.id/image/venue/170987522426828.image_cropper_1709875173687.jpg', // Badminton court
                'rating' => 4.73,
                'city' => 'Depok',
                'categories' => json_encode(['Badminton', 'Table Tennis']),
                'price_per_session' => 55000,
            ],

        ];

        DB::table('venues')->insert($venues);
    }
}
