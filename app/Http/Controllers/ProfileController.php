<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        $id = Auth::id();
        $user = User::with('profile')->find($id);
        return view('admin.profile-settings', compact('user'));
    }

    public function store(Request $request) {}


    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nim'       => 'required|string|max:20',
            'angkatan'  => 'required|integer',
            'divisi'    => 'required|string|max:100',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ]);

        $user = Auth::user();

        // Ambil atau buat profil user
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        $compressedPath = $profile->image; // default: foto lama (kalau ada)

        // Jika ada file baru diupload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getPathname();

            // kompres tanpa simpan dahulu
            $result = ImageHelper::compressImage($imagePath, 75, 600);

            // gunakan extension hasil proses, jangan pakai .webp fix
            $fileName = uniqid('profile_') . '.' . $result['extension'];
            $savePath = storage_path('app/public/profile/' . $fileName);

            // simpan file lewat helper
            ImageHelper::saveImage($result['image'], $savePath, $result['extension'], $result['quality']);

            $compressedPath = 'storage/profile/' . $fileName;

            // hapus lama
            if ($profile->image && file_exists(public_path($profile->image))) {
                unlink(public_path($profile->image));
            }
        }


        // Update data profil
        $profile->nim       = $validated['nim'];
        $profile->angkatan  = $validated['angkatan'];
        $profile->divisi    = $validated['divisi'];
        $profile->image     = $compressedPath;
        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function verifyUserIndex(Request $request)
    {
        if (Auth::user()->role == 'Admin') {
            $query = User::with('profile')->with('profile')->where('role', '!=', 'Admin')->orderBy('name');
        } else {
            $query = User::with('profile')->with('profile')->whereIn('role', ['None', 'anggota'])->orderBy('name');
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereHas('profile', function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(nim) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(angkatan) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('divisi')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('divisi', $request->divisi);
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);

        return view('admin.user-verify', ['users' => $users]);
    }
    public function verifyUser($id)
    {
        $user = User::find($id);
        $user->role = 'Anggota';
        $user->save();

        return redirect()->back()->with('success', 'Anggota Diverifikasi');
    }

    public function verifyPengurus($id)
    {
        $user = User::find($id);
        $user->role = 'Pengurus';
        $user->save();

        return redirect()->back()->with('success', 'Anggota Diverifikasi');
    }

    // ! nonaktifkan anggota
    public function unVerifyUser($id)
    {
        $user = User::find($id);
        $user->role = 'None';
        $user->save();

        return redirect()->back()->with('success', 'Anggota Dinonaktifkan');
    }
}
