<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;  // ← TAMBAH INI
use Filament\Panel;  // ← TAMBAH INI


class User extends Authenticatable implements FilamentUser  // ← TAMBAH implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone', // Sudah ada
        'password',
        'is_admin', // ← TAMBAH INI untuk kontrol admin
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // ← TAMBAH INI
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true; // atau kondisi tertentu, misal: $this->is_admin
    }

    /**
     * Method untuk kontrol akses Filament Admin
     */

    /**
     * Relasi ke ProfilUser
     */


    // Relasi ke model ProfilUser
    public function profil() // Nama relasi ini akan kita gunakan: Auth::user()->profil
    {
        // 'ProfilUser::class' adalah nama model
        // 'user_id' adalah foreign key di tabel 'profils_user' yang merujuk ke 'users.id'
        return $this->hasOne(ProfilUser::class, 'user_id', 'id');
    }
    

}