<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'profils_user_id',
        'court_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'customer_name',
        'customer_phone',
        'status',
        'payment_method', // Keep this if you want a quick reference here, or remove if strictly only in Payments table
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'float',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function profilsUser()
    {
        return $this->belongsTo(ProfilUser::class, 'profils_user_id', 'id');
    }

    // New: Relationship to Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}