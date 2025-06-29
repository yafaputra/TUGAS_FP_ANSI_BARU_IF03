<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_mendaftars_id',
        'name',
        'type',
        'surface_type',
        'description',
        'image_url',
        'base_price_per_hour',
        'is_indoor',
    ];

    protected $casts = [
        'base_price_per_hour' => 'float',
        'is_indoor' => 'boolean',
    ];

    public function venue()
    {
        return $this->belongsTo(VenueMendaftar::class, 'venue_mendaftars_id');
    }
    // app/Models/Court.php

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'court_id');
        // Sesuaikan 'court_id' dengan nama foreign key yang benar di tabel bookings
}
}