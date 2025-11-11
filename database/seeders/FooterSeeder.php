<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Footer::insert([
            [
                'nomor_telepon' => '+62 821 9329 5789',
                'email' => 'isc@unsulbar.ac.id',
                'link_facebook' => 'https://facebook',
                'link_instagram' => 'https://instagram',
                'link_tiktok' => 'https://tiktok.com',
            ]
        ]);
    }
}
