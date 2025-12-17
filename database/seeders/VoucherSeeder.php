<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Voucher::create([
                'code' => strtoupper(Str::random(8)),
                'status' => true
            ]);
        }
    }
}
