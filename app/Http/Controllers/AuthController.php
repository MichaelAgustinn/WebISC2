<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register
    public function processRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric',
            'password' => 'required|min:6|confirmed', // Pastikan input confirm password bernama 'password_confirmation'
        ]);

        // 1. Buat User (Tabel Users)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'none', // Default role 'none' (Guest/Belum diverifikasi)
        ]);

        // 2. Buat Profile (Tabel Profiles)
        // Kita simpan nomor HP di tabel profile sesuai struktur database sebelumnya
        Profile::create([
            'user_id' => $user->id,
            'nim' => '-', // Default
            'phone_number' => $request->phone_number,
            'angkatan' => date('Y'), // Default tahun ini
        ]);

        // 3. Auto Login setelah register
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
