<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Voucher;

class CheckVoucher
{
    public function handle(Request $request, Closure $next)
    {
        $voucherCode = $request->code ?? $request->voucher_code ?? null;

        if (!$voucherCode) {
            return redirect()->route('voting.input')
                ->with('error', 'Harap masukkan kode voucher.');
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

        // Masukkan voucher ke request agar bisa dipakai controller
        $request->merge([
            'voucher_id' => $voucher->id,
            'voucher_code' => $voucher->code,
        ]);

        return $next($request);
    }
}
