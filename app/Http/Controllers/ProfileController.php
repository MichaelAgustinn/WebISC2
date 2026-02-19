<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Untuk hapus file lama
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load('profile');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'nim' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:15',
            'angkatan' => 'nullable|numeric',
            'division' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // 2. Update Tabel Users (Data Akun)
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // 3. Persiapan Data Profile
        $profileData = [
            'nim' => $request->nim,
            'phone_number' => $request->phone_number,
            'angkatan' => $request->angkatan,
            'division' => $request->division,
            'special_team' => $request->special_team,
            'bio' => $request->bio,
        ];

        // 4. Handle Upload Foto (Ke folder Public)
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada (dan bukan default/avatar url)
            if ($user->profile && $user->profile->photo && file_exists(public_path('uploads/profiles/' . $user->profile->photo))) {
                File::delete(public_path('uploads/profiles/' . $user->profile->photo));
            }

            // Upload foto baru
            $file = $request->file('photo');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profiles'), $filename);

            $profileData['photo'] = $filename;
        }

        // 5. Simpan ke Tabel Profiles (Create jika belum ada, Update jika ada)
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
