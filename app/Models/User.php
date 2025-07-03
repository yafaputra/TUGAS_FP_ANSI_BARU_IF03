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
<<<<<<< HEAD
        'phone', // Sudah ada
=======
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985
        'password',
        'is_admin', // ← TAMBAH INI untuk kontrol admin
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
<<<<<<< HEAD
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
=======
    ];

    // Relasi ke model ProfilUser
    public function profil() // Nama relasi ini akan kita gunakan: Auth::user()->profil
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985
    {
        // 'ProfilUser::class' adalah nama model
        // 'user_id' adalah foreign key di tabel 'profils_user' yang merujuk ke 'users.id'
        return $this->hasOne(ProfilUser::class, 'user_id', 'id');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> bb5addc04e56a4ec8fa6c893357a1810e909a985
