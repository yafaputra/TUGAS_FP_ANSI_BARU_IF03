<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueMendaftar extends Model
{
      use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'facilities',
        'rules',
        'address',
        'city',
        'province',
        'opening_hours',
        'rating',
        'review_count',
        'hero_image_url'
    ];

    protected $casts = [
        'facilities' => 'array',
        'rules' => 'array',
        'rating' => 'float',
        'review_count' => 'integer',
    ];

    public function courts()
    {
        return $this->hasMany(Court::class, 'venue_mendaftars_id');
    }
}

