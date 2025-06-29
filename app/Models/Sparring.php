<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparring extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'team_initials',
        'sport_type',
        'level',
        'rating',
        'datetime',
        'location',
        'total_cost',
        'down_payment',
        'city',
        'team_color',
    ];

     protected $casts = [
        'datetime' => 'datetime', // otomatis ubah ke Carbon
    ];

    public function getColorGradientAttribute()
    {
        $colors = [
            'blue' => ['from-blue-500', 'to-blue-700'],
            'red' => ['from-red-500', 'to-red-700'],
            'gray' => ['from-gray-600', 'to-gray-700'],
            'cyan' => ['from-cyan-500', 'to-cyan-700'],
            'black' => ['from-gray-800', 'to-gray-900'],
            'green' => ['from-green-500', 'to-teal-500'],
        ];

        return $colors[$this->team_color] ?? ['from-green-500', 'to-teal-400'];
    }
}

