<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'rating',
        'city',
        'categories',
        'price_per_session',
    ];

    protected $casts = [
        'categories' => 'array',
    ];
}