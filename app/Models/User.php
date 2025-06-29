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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone', // Sudah ada
        'password',
        'is_admin', // ← TAMBAH INI untuk kontrol admin
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean', // ← TAMBAH INI
    ];

    /**
     * Method untuk kontrol akses Filament Admin
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Opsi 1: Berdasarkan email domain
        // return str_ends_with($this->email, '@admin.com');

        // Opsi 2: Berdasarkan field is_admin (RECOMMENDED)
        return $this->is_admin ?? false;

        // Opsi 3: Berdasarkan email spesifik
        // return in_array($this->email, ['admin@admin.com', 'super@admin.com']);
    }

    /**
     * Relasi ke ProfilUser
     */
    public function profilUser()
    {
        return $this->hasOne(ProfilUser::class);
    }
}
