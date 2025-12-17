<?php

namespace Database\Seeders;

use App\Models\Logo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Logo::insert([
            [
                'title' => 'isc',
                'image' => 'storage/logo/logo_691a7dafea38e.webp',
            ],
            [
                'title' => 'iot',
                'image' => 'storage/logo/logo_69058beacb841.webp',
            ],
            [
                'title' => 'web',
                'image' => 'storage/logo/logo_69058c1f5c989.webp'
            ],
            [
                'title' => 'mobile',
                'image' => 'storage/logo/logo_69059386f26cc.webp',
            ],
            [
                'title' => 'sc',
                'iamge' => 'storage/logo/logo_6905939addf9e.webp'
            ],
            [
                'title' => 'ux',
                'image' => 'storage/logo/logo_690593ab91eca.webp'
            ],
            [
                'title' => 'tim creative',
                'image' => 'storage/logo/logo_690593bc4b9f6.webp'
            ],
            [
                'title' => 'tim marketing',
                'iamge' => 'storage/logo/logo_6905962f64791.webp'
            ]
        ]);
    }
}
