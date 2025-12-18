<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Voucher;

class CheckVoucher
{
    public function handle($request, Closure $next)
    {
        // Ambil dari request JIKA ADA
        $voucherCode = $request->code ?? session('voucher_code');

        if (!$voucherCode) {
            return redirect()->route('voting.input')
                ->with('error', 'Kode voucher wajib diisi.');
        }

        $voucher = Voucher::where('code', $voucherCode)->first();

        if (!$voucher) {
            return redirect()->route('voting.input')
                ->with('error', 'Kode voucher tidak ditemukan.');
        }

        if (!$voucher->status) {
            return redirect()->route('voting.input')
                ->with('error', 'Voucher sudah digunakan.');
        }

        // Simpan ke session (string saja)
        session(['voucher_code' => $voucher->code]);

        return $next($request);
    }
}
