<?php

namespace Database\Seeders;

use App\Models\Landing_page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{

    public function run(): void
    {
        Landing_page::insert([
            [
                'section' => 'hero',
                'title' => 'Informatics Study Club',
                'description' => 'Satu-satunya wadah yang fokus untuk meningkatkan Skill Mahasiswa Teknik Informatika Prodi Informatika Unsulbar',
                'image' => 'storage/landing/landing_6904d29a4f1fd.webp',
            ],
            [
                'section' => 'about',
                'title' => 'Belajar, Berkembang, dan Berkontribusi di ISC',
                'description' => 'ISC adalah wadah mahasiswa untuk mengembangkan keterampilan di bidang teknologi informasi melalui lima divisi: Mobile, Web, UI/UX, IoT, dan Sistem Cerdas. Didukung oleh Tim Kreatif dan Tim Marketing, ISC mendorong kolaborasi, eksplorasi, dan kontribusi nyata dalam dunia digital.',
                'image' => 'storage/landing/landing_6904d3459d842.webp',
            ],
            [
                'section' => 'visi',
                'title' => 'Visi Informatics Study Club',
                'description' => 'Menjadi tempat utama pengembangan talenta digital mahasiswa yang inovatif, kolaboratif, dan berdaya saing di era teknologi.',
                'image' => 'storage/landing/landing_6904d3f4ccbee.webp',
            ],
            [
                'section' => 'misi',
                'title' => 'Misi Informatics Study Club',
                'description' => 'Menyediakan tempat belajar dan berkarya di bidang teknologi melalui lima divisi utama dan dua tim pendukung guna meningkatkan keterampilan serta kolaborasi mahasiswa.',
                'image' => 'storage/landing/landing_6904d4056023f.webp',
            ],
        ]);
    }
}
