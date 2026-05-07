<?php

namespace App\Http\Controllers;

use App\Models\Regist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;

class RegistController extends Controller
{
    public function waiting()
    {
        return view('auth.waiting-verification');
    }

    public function regist(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric',
            'nim' => 'required|unique:profiles,nim',
            'angkatan' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        Regist::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
        ]);

        return redirect()->route('waiting.verification')->with('success', 'registrasi berhasil, mohon tunggu untuk di verifikasi');
    }
}
