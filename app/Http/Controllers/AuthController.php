<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //! Cek apakah user terdaftar dan berhasil login
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Selamat datang kembali!');
        }

        // ! Ambil data user yang belum di verifikasi berdasarkan email
        $isWaiting = DB::table('regists')
            ->where('email', $request->email)
            ->first();

        // ! Jika email ditemukan di tabel pending
        if ($isWaiting) {

            //? Cek apakah password sesuai
            if (Hash::check($request->password, $isWaiting->password)) {
                return view('auth.waiting-verification');
            }
        }

        // Jika login gagal sepenuhnya
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
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'none',
            'slug' => Str::slug($request->name) . '-' . Str::random(4),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'nim' => null,
            'phone_number' => $request->phone_number,
            'angkatan' => date('Y'),
        ]);

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
