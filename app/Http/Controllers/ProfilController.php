<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\ProfilUser;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman formulir edit profil pengguna.
     */
    public function edit()
    {
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
                // Validasi unik untuk username di tabel profils_user, abaikan user_id saat ini
                Rule::unique('profils_user')->ignore($user->id, 'user_id') 
            ],
            'birthDate' => ['nullable', 'date'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Validasi unik untuk email di tabel users, abaikan id user saat ini
                Rule::unique('users')->ignore($user->id) 
            ],
            'gender' => ['nullable', 'in:male,female'],
            'bio' => ['nullable', 'string', 'max:500'],
            'favoriteSports' => ['nullable', 'array'],
            'favoriteSports.*' => ['string'],
            'avatar' => ['nullable', 'image', 'max:2048'], // Pastikan ini sesuai dengan name di FormData
        ]);

        // Update email di tabel users
        $user->email = $request->email;
        $user->save();

        // Ambil atau buat profil pengguna
        $profil = $user->profilUser ?? new ProfilUser(['user_id' => $user->id]);

        $profil->fill([
            'username' => $request->username,
            'full_name' => $request->fullName,
            'birth_date' => $request->birthDate,
            'phone_number' => $request->phoneNumber,
            'gender' => $request->gender,
            'bio' => $request->bio,
            // Pastikan favoriteSports selalu berupa array, bahkan jika null dari request
            'favorite_sports' => $request->favoriteSports ?? [], 
        ]);

        // Handle unggah avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($profil->avatar && Storage::disk('public')->exists($profil->avatar)) {
                Storage::disk('public')->delete($profil->avatar);
            }
            
            // Simpan avatar baru dan dapatkan path-nya
            $path = $request->file('avatar')->store('avatars', 'public');
            $profil->avatar = $path; // Simpan path di kolom avatar
        }

        // Simpan perubahan ke database
        $profil->save();

        // Berikan respon JSON
        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'profil' => [
                // Mengirim semua atribut profil, termasuk 'avatar' (path)
                ...$profil->toArray(), 
                // Menambahkan 'avatar_url' untuk kemudahan di frontend
                'avatar_url' => $profil->avatar ? Storage::url($profil->avatar) : null,
            ]
        ], 200);
    }
}