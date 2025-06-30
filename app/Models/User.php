<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke model ProfilUser
    public function profil() // Nama relasi ini akan kita gunakan: Auth::user()->profil
    {
        // 'ProfilUser::class' adalah nama model
        // 'user_id' adalah foreign key di tabel 'profils_user' yang merujuk ke 'users.id'
        return $this->hasOne(ProfilUser::class, 'user_id', 'id');
    }
}