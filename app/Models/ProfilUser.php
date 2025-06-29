<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilUser extends Model
{
    use HasFactory;

    protected $table = 'profils_user';
    protected $primaryKey = 'user_id';
    public $incrementing = false; // Ini tergantung pada tipe ID user Anda
    protected $keyType = 'integer'; // Jika user_id di tabel users adalah integer auto-increment

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Pastikan FK-nya benar
    }
}

