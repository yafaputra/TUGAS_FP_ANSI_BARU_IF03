<?php

namespace Database\Seeders;

use App\Models\VenueMendaftar;
use Illuminate\Database\Seeder;

class VenueMendaftarSeeder extends Seeder
{
    public function run()
    {
        VenueMendaftar::create([
            'venue_id' => 1,
            'name' => 'Metro Atom Futsal Badminton',
            'description' => 'Metro Atom Futsal Badminton menyediakan fasilitas olahraga berkualitas tinggi dengan lapangan standar internasional. Dilengkapi dengan sistem pencahayaan optimal dan lantai berkualitas premium untuk pengalaman bermain terbaik. Lokasi strategis di pusat kota dengan akses mudah dan fasilitas lengkap termasuk area parkir luas, kantin, dan ruang ganti yang nyaman.',
            'facilities' => [
                '3 Lapangan Futsal Standar Internasional',
                '6 Lapangan Badminton',
                'Pencahayaan LED High Quality',
                'Lantai Vinyl Professional',
                'Parkir Luas (100+ mobil)',
                'Ruang Ganti & Kamar Mandi',
                'Kantin & Area Istirahat',
                'Free WiFi'
            ],
            'rules' => [
                'Pelanggan harus datang tepat waktu sesuai jadwal booking',
                'Dilarang membawa air mineral dalam kemasan gelas',
                'Dilarang bersandar atau memegang jaring lapangan',
                'Dilarang membawa senjata tajam dan minuman beralkohol',
                'Wajib menggunakan sepatu olahraga yang sesuai (dilarang sepatu berdempul)',
                'Bertanggung jawab atas kerusakan alat/barang yang disewa',
                'Dilarang merokok di area dalam ruangan'
            ],
            'address' => 'Pd Pasar Jaya Pasar Baru Metro Atom Plaza Lt. B (Gedung Parkir)',
            'city' => 'Jakarta Pusat',
            'province' => 'DKI Jakarta',
            'opening_hours' => '24 Jam',
            'rating' => 4.8,
            'review_count' => 128,
            'hero_image_url' => 'https://superlive.id/storage/articles/b3cb4280-362c-4058-aa64-e0b4a0f7aab8.jpg'
        ]);
    }
}

