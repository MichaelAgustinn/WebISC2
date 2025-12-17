<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Voucher;

class CheckVoucher
{
    public function handle(Request $request, Closure $next)
    {
        $voucherCode = $request->code;

        $voucher = Voucher::where('code', $voucherCode)->first();

        if (!$voucher)
            return redirect()->route('voucher.input')->with('error', 'Kode voucher tidak ditemukan.');

        if (!$voucher->status)
            return redirect()->route('voucher.input')->with('error', 'Voucher sudah digunakan.');

        // SIMPAN voucher ke session
        session(['voucher' => $voucher]);

        return $next($request);
    }
}
