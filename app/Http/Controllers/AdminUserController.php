<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Regist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function unverified(Request $request)
    {
        $query = Regist::query();

        // Search feature
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.verify', compact('users'));
    }

    public function verify($id)
    {
        $regist = Regist::find($id);

        if (!$regist) {

            return redirect()
                ->back()
                ->with('error', 'Data user tidak ditemukan');
        }

        $user = User::create([
            'name' => $regist->name,
            'email' => $regist->email,
            'password' => $regist->password,
            'role' => 'anggota',

        ]);

        Profile::create([
            'user_id' => $user->id,
            'nim' => $regist->nim,
            'phone_number' => $regist->phone_number,
            'angkatan' => $regist->angkatan,

        ]);

        $regist->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diaktivasi');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,pengurus,anggota,none'
        ]);

        $currentUser = Auth::user();
        $newRole = $request->role;

        if ($currentUser->role == 'pengurus') {
            if ($user->role == 'admin' || $user->role == 'pengurus') {
                return back()->with('error', 'Anda tidak memiliki akses untuk mengubah user ini.');
            }

            if (!in_array($newRole, ['anggota', 'none'])) {
                return back()->with('error', 'Pengurus hanya bisa mengubah role ke Anggota atau None.');
            }
        }


        $user->update(['role' => $newRole]);

        return back()->with('success', "Role pengguna {$user->name} berhasil diubah menjadi " . ucfirst($newRole));
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role == 'pengurus' && ($user->role == 'admin' || $user->role == 'pengurus')) {
            return back()->with('error', 'Akses ditolak.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
