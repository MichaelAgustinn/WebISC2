<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Cek jika role user ada di dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika guest 'none' (belum diverifikasi)
        if ($user->role === 'none') {
            return redirect()->route('dashboard')->with('error', 'Akun Anda belum diverifikasi admin.');
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
