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
                'image_url' => 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'base_price_per_hour' => 160000,
                'is_indoor' => true,
            ]);

            Court::create([
                'venue_mendaftars_id' => $metroAtom->id,
                'name' => 'Lapangan Futsal B',
                'type' => 'Futsal',
                'surface_type' => 'Vinyl',
                'description' => 'Lapangan futsal standar internasional dengan pencahayaan optimal.',
                'image_url' => 'https://images.unsplash.com/photo-1559863438-e0496a7277b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
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
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'base_price_per_hour' => 70000,
                'is_indoor' => true,
            ]);

            Court::create([
                'venue_mendaftars_id' => $metroAtom->id,
                'name' => 'Lapangan Badminton 2',
                'type' => 'Badminton',
                'surface_type' => 'Vinyl',
                'description' => 'Lapangan badminton nyaman dengan sirkulasi udara baik.',
                'image_url' => 'https://images.unsplash.com/photo-1621213032549-b5a0344d2d47?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                'base_price_per_hour' => 70000,
                'is_indoor' => true,
            ]);

            // Anda bisa tambahkan lebih banyak lapangan di sini
        } else {
            $this->command->info('Venue "Metro Atom Futsal Badminton" tidak ditemukan. Pastikan VenueSeeder dijalankan terlebih dahulu.');
        }
    }
}