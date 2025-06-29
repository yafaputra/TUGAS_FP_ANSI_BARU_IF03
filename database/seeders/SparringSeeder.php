<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SparringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sparrings = [
            [
                'team_name' => 'Jakarta Timur Football Community',
                'team_initials' => 'JT',
                'sport_type' => 'Sepak Bola',
                'level' => 'Putih I',
                'rating' => 4.88,
                'datetime' => Carbon::create(2025, 6, 5, 20, 0, 0),
                'location' => 'Utama, Stadion Inguk Klender',
                'total_cost' => 400000,
                'down_payment' => 200000,
                'city' => 'Jakarta Timur',
                'team_color' => 'blue',
            ],
            [
                'team_name' => 'Petakilan FC',
                'team_initials' => 'PF',
                'sport_type' => 'Futsal',
                'level' => 'Perak II',
                'rating' => 4.79,
                'datetime' => Carbon::create(2025, 6, 5, 20, 0, 0),
                'location' => 'Lap B atau G, Halim Futsal & Badminton',
                'total_cost' => 170000,
                'down_payment' => 0,
                'city' => 'Jakarta Timur',
                'team_color' => 'red',
            ],
            [
                'team_name' => 'Sucks Ballers',
                'team_initials' => 'SB',
                'sport_type' => 'Futsal',
                'level' => 'Putih I',
                'rating' => null,
                'datetime' => Carbon::create(2025, 6, 6, 18, 50, 0),
                'location' => 'Lapangan Biru, Magnet Arena New',
                'total_cost' => 125000,
                'down_payment' => 0,
                'city' => 'Jakarta Barat',
                'team_color' => 'gray',
            ],
            [
                'team_name' => 'Matador FC',
                'team_initials' => 'MF',
                'sport_type' => 'Mini Soccer',
                'level' => 'Putih I',
                'rating' => null,
                'datetime' => Carbon::create(2025, 6, 7, 8, 0, 0),
                'location' => 'Mini soccer, de King&D30 Arena (Futsal and Mini Soccer)',
                'total_cost' => null,
                'down_payment' => 0,
                'city' => 'Jakarta Selatan',
                'team_color' => 'cyan',
            ],
            [
                'team_name' => 'SPONTAN CHUY FC',
                'team_initials' => 'SC',
                'sport_type' => 'Mini Soccer',
                'level' => 'Putih I',
                'rating' => 5.00,
                'datetime' => Carbon::create(2025, 6, 7, 15, 30, 0),
                'location' => 'lap. Fuerza Arena',
                'total_cost' => null,
                'down_payment' => 0,
                'city' => 'Jakarta Utara',
                'team_color' => 'black',
            ],
            [
                'team_name' => 'Southawla KSB',
                'team_initials' => 'SK',
                'sport_type' => 'Mini Soccer',
                'level' => 'Putih I',
                'rating' => null,
                'datetime' => Carbon::create(2025, 6, 7, 16, 0, 0),
                'location' => 'Lapangan A, Jonas Mini Soccer',
                'total_cost' => null,
                'down_payment' => 0,
                'city' => 'Jakarta Barat',
                'team_color' => 'green',
            ],
        ];

        DB::table('sparrings')->insert($sparrings);
    }
}