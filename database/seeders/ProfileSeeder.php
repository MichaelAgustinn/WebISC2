<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::insert([
            [
                'user_id' => 1,
                'nim' => 'D02233109',
                'angkatan' => '2023',
                'jabatan' => 'Admin',
                'divisi' => 'Mobile',
                'image' => 'storage/profile/profile_690e552e3bf29.png'
            ],
            [
                'user_id' => 2,
                'nim' => 'D0223310',
                'angkatan' => '2023',
                'jabatan' => 'Bukan Admin',
                'divisi' => 'Mobile',
                'image' => 'storage/profile/profile_690a1ee349acd.webp'
            ],
            [
                'user_id' => 3,
                'nim' => 'D0223555',
                'angkatan' => '2023',
                'jabatan' => 'None',
                'divisi' => 'Website',
                'image' => 'storage/profile/profile_690a24c14092d.webp'
            ],
            [
                'user_id' => 4,
                'nim' => 'D0223666',
                'angkatan' => '2023',
                'jabatan' => 'None',
                'divisi' => 'Mobile',
                'image' => 'storage/profile/profile_690a25ece5542.webp'
            ],
            [
                'user_id' => 5,
                'nim' => 'D0223777',
                'angkatan' => '2023',
                'jabatan' => 'None',
                'divisi' => 'Website',
                'image' => 'storage/profile/profile_690a26aecc670.webp'
            ],
        ]);
    }
}
