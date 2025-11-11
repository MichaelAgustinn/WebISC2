<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mentor::insert([
            [
                'name' => 'Sugirato Cokrowibowo',
                'jabatan' => 'Wadek I Fakultas Teknik',
                'image' => 'storage/mentor/mentor_690b749c5d1b6.webp',
            ],
            [
                'name' => 'Muh. Fahmi Rustan',
                'jabatan' => 'Wadek I Fakultas Teknik',
                'image' => 'storage/mentor/mentor_690b74bd0b77f.webp',
            ],
            [
                'name' => 'Muh. Rafli Rasyid',
                'jabatan' => 'Kaprodi Informatika',
                'image' => 'storage/mentor/mentor_690b74f3300d8.webp'
            ],
            [
                'name' => 'Nuralamsah Zulkarnaim',
                'jabatan' => 'Pembimbing Divisi Website',
                'image' => 'storage/mentor/mentor_690b74d71b913.webp'
            ],
            [
                'name' => 'Farid Wajidi',
                'jabtan' => 'Pembimbing Divisi UI/UX',
                'image' => 'storage/mentor/mentor_690b7511e5c8f.webp'
            ],
            [
                'name' => 'Wawan Firgiawan',
                'jabatan' => 'Pembimbing Divisi Sistem Cerdas',
                'image' => 'storage/mentor/mentor_690b75254c697.webp'
            ],
            [
                'name' => 'A. Amirul Asnan Cirua',
                'jabatan' => 'Pembimbing Divisi IoT',
                'image' => 'storage/mentor/mentor_690b753bc6bcc.webp',
            ],
        ]);
    }
}
