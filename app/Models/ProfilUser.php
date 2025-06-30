<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilUser extends Model
{
    use HasFactory;

    protected $table = 'profils_user';
    // primaryKey adalah 'id', bukan 'user_id', karena migrasi Anda menggunakan $table->id();
    // Kalau primary key Anda memang 'user_id', maka $primaryKey = 'user_id'; $incrementing = false;
    // Tapi karena migrasi Anda pakai $table->id(), maka biarkan defaultnya.
    // protected $primaryKey = 'id'; // Default Laravel
    // public $incrementing = true; // Default Laravel

    protected $fillable = [
        'user_id',
        'username',
        'full_name',
        'birth_date',
        'phone_number',
        'gender',
        'bio',
        'favorite_sports',
        'avatar',
    ];

    protected $casts = [
        'favorite_sports' => 'array',
        'birth_date' => 'date',
    ];

    // Relasi kembali ke User
    public function user()
    {
        // 'User::class' adalah model yang dirujuk
        // 'user_id' adalah foreign key di tabel 'profils_user'
        // 'id' adalah primary key di tabel 'users'
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke Booking, karena Booking sekarang merujuk ke ProfilUser
    public function bookings()
    {
        // 'Booking::class' adalah model yang dirujuk
        // 'profils_user_id' adalah foreign key di tabel 'bookings'
        // 'id' adalah primary key di tabel 'profils_user'
        return $this->hasMany(Booking::class, 'profils_user_id', 'id');
    }
}