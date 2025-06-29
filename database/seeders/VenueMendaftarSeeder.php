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
            'hero_image_url' => 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80',
            'gallery_images' => [
                ['title' => 'Lapangan Futsal Utama', 'url' => 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Lapangan Badminton', 'url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Area Kantin', 'url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Area Parkir', 'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Ruang Ganti', 'url' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'],
                ['title' => 'Area Reception', 'url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80']
            ],
        ]);
    }
    
    
}

