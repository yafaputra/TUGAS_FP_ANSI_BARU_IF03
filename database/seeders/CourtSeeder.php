<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue; // Jangan lupa import Venue model
use App\Models\Court; // Jangan lupa import Court model

class CourtSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {

        // Ambil venue yang sudah dibuat dari VenueSeeder
        $metroAtom = Venue::where('name', 'Metro Atom Futsal Badminton')->first();

        if ($metroAtom) {
            // Lapangan Futsal
            Court::create([
                'venue_mendaftars_id' => $metroAtom->id,
                'name' => 'Lapangan Futsal A',
                'type' => 'Futsal',
                'surface_type' => 'Vinyl',
                'description' => 'Lapangan futsal standar internasional dengan lantai vinyl berkualitas tinggi.',
                'image_url' => 'https://storage.googleapis.com/data.ayo.co.id/photos/77445/SEO%20HDI%204/80.%20Cara%20Cepat%20dan%20Mudah%20Menyewa%20Lapangan%20Futsal%20untuk%20Tim%20Anda.jpg',
                'base_price_per_hour' => 160000,
                'is_indoor' => true,
            ]);

            Court::create([
                'venue_mendaftars_id' => $metroAtom->id,
                'name' => 'Lapangan Futsal B',
                'type' => 'Futsal',
                'surface_type' => 'Vinyl',
                'description' => 'Lapangan futsal standar internasional dengan pencahayaan optimal.',
                'image_url' => 'https://superlive.id/storage/articles/b3cb4280-362c-4058-aa64-e0b4a0f7aab8.jpg',
                'base_price_per_hour' => 160000,
                'is_indoor' => true,
            ]);

            // Lapangan Badminton
            Court::create([
                'venue_mendaftars_id' => $metroAtom->id,
                'name' => 'Lapangan Badminton 1',
                'type' => 'Badminton',
                'surface_type' => 'Vinyl',
                'description' => 'Lapangan badminton dengan lantai vinyl profesional untuk permainan terbaik.',
                'image_url' => 'https://asset.kompas.com/crops/KzkIUARnG2TzneFMani1IoLrvVU=/10x0:915x603/1200x800/data/photo/2021/11/12/618e70119b754.jpeg',
                'base_price_per_hour' => 70000,
                'is_indoor' => true,
            ]);

            Court::create([
                'venue_mendaftars_id' => $metroAtom->id,
                'name' => 'Lapangan Badminton 2',
                'type' => 'Badminton',
                'surface_type' => 'Vinyl',
                'description' => 'Lapangan badminton nyaman dengan sirkulasi udara baik.',
                'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIOTZTVbQUcHXVsIDnj39wDeC5DJuXJt0lUi4Y4OFuG9zAtu03DOtSPjpanqlRHfBNKKk&usqp=CAU',
                'base_price_per_hour' => 70000,
                'is_indoor' => true,
            ]);

            // Anda bisa tambahkan lebih banyak lapangan di sini
        } else {
            $this->command->info('Venue "Metro Atom Futsal Badminton" tidak ditemukan. Pastikan VenueSeeder dijalankan terlebih dahulu.');
        }
    }
}
