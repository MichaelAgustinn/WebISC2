<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $query = User::query();

        // Search feature
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Logic Filter Data:
        // Jika Pengurus yang login, sembunyikan Admin dan sesama Pengurus dari list
        // Agar mereka tidak salah edit atasan/rekan.
        if ($currentUser->role == 'pengurus') {
            $query->whereNotIn('role', ['admin', 'pengurus']);
        } else {
            // Jika Admin, sembunyikan dirinya sendiri agar tidak menurunkan role sendiri secara tidak sengaja
            $query->where('id', '!=', $currentUser->id);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,pengurus,anggota,none'
        ]);

        $currentUser = Auth::user();
        $newRole = $request->role;

        // --- SECURITY GATE ---

        // 1. Validasi untuk PENGURUS
        if ($currentUser->role == 'pengurus') {
            // Pengurus tidak boleh mengedit Admin atau Pengurus lain
            if ($user->role == 'admin' || $user->role == 'pengurus') {
                return back()->with('error', 'Anda tidak memiliki akses untuk mengubah user ini.');
            }

            // Pengurus hanya boleh set ke 'anggota' atau 'none'
            if (!in_array($newRole, ['anggota', 'none'])) {
                return back()->with('error', 'Pengurus hanya bisa mengubah role ke Anggota atau None.');
            }
        }

        // 2. Validasi untuk ADMIN (Opsional, misal Admin tidak boleh bikin Admin baru sembarangan)
        // Disini kita asumsi Admin bebas, kecuali mengubah dirinya sendiri (sudah difilter di index)

        // Update Role
        $user->update(['role' => $newRole]);

        return back()->with('success', "Role pengguna {$user->name} berhasil diubah menjadi " . ucfirst($newRole));
    }

    public function destroy(User $user)
    {
        // Proteksi level Pengurus hapus user
        if (Auth::user()->role == 'pengurus' && ($user->role == 'admin' || $user->role == 'pengurus')) {
            return back()->with('error', 'Akses ditolak.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
