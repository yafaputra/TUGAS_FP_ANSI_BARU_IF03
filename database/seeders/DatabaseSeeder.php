<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Regular Test User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Admin User untuk Filament
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '08123456789',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        // Seeder lainnya
        $this->call(VenueSeeder::class);
        $this->call(SparringSeeder::class);
        $this->call(VenueMendaftarSeeder::class);
        $this->call(CourtSeeder::class);
    }
}
