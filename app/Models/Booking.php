<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'customer_name',
        'customer_phone',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime', // Akan di-cast ke Carbon instance
        'end_time' => 'datetime',   // Akan di-cast ke Carbon instance
        'total_price' => 'float',
    ];

    

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'court_id');
        // Sesuaikan 'court_id' dengan nama foreign key yang benar di tabel bookings
    }
}