<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'profils_user_id',
        'amount',
        'payment_method',
        'transaction_id', // Optional, for payment gateway ID
        'status', // e.g., 'pending', 'paid', 'failed', 'expired'
        'account_name', // Account name for manual transfer (e.g., "PT. Lapangan Jaya")
        'account_number', // Account number for manual transfer
        'payment_code', // e.g., Virtual Account number or QRIS string
        'expires_at',
        'paid_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'amount' => 'float',
    ];

    // Define relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function profilsUser()
    {
        return $this->belongsTo(ProfilUser::class, 'profils_user_id', 'id');
    }
}
