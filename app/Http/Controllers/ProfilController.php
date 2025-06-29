<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Import model User

use Illuminate\Validation\Rule;
use App\Models\ProfilUser; // Import model ProfilUser

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman formulir edit profil pengguna.
     */
    public function edit()
    {
        // Pastikan pengguna sudah login
        $user = Auth::user();

        // Mengambil data profil dari relasi, jika belum ada, buat objek kosong
        // Gunakan relasi profilUser yang sudah didefinisikan di model User
        $profil = $user->profilUser ?? new ProfilUser(['user_id' => $user->id]);
        
        // Mengirim data profil ke view
        return view('user.profile', compact('user', 'profil'));
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'fullName' => ['required', 'string', 'max:255'],
        'username' => [
            'required',
            'string',
            'max:255',
            Rule::unique('profils_user')->ignore($user->id, 'user_id')
        ],
        'birthDate' => ['nullable', 'date'],
        'phoneNumber' => ['nullable', 'string', 'max:20'],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            Rule::unique('users')->ignore($user->id)
        ],
        'gender' => ['nullable', 'in:male,female'],
        'bio' => ['nullable', 'string', 'max:500'],
        'favoriteSports' => ['nullable', 'array'],
        'favoriteSports.*' => ['string'],
        'avatar' => ['nullable', 'image', 'max:2048'], // Pastikan ini sesuai dengan name di FormData
    ]);

    // Update user email
    $user->email = $request->email;
    $user->save();

    // Get or create profile
    $profil = $user->profilUser ?? new ProfilUser(['user_id' => $user->id]);

    $profil->fill([
        'username' => $request->username,
        'full_name' => $request->fullName,
        'birth_date' => $request->birthDate,
        'phone_number' => $request->phoneNumber,
        'gender' => $request->gender,
        'bio' => $request->bio,
        'favorite_sports' => $request->favoriteSports ?? [],
    ]);

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        // Delete old avatar if exists
        if ($profil->avatar) {
            Storage::disk('public')->delete($profil->avatar);
        }
        
        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $profil->avatar = $path;
    }

    $profil->save();

    return response()->json([
        'message' => 'Profil berhasil diperbarui!',
        'profil' => [
            ...$profil->toArray(),
            'avatar_url' => $profil->avatar ? Storage::url($profil->avatar) : null,
        ]
    ], 200);
}
}

