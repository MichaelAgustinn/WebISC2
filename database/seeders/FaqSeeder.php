<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::insert([
            [
                'question' => 'Apa itu ISC?',
                'answered' => 'ISC (Informatics Study Club) adalah komunitas mahasiswa yang menjadi wadah pengembangan minat dan bakat di bidang teknologi informasi, khususnya untuk mahasiswa Informatika.'
            ],
            [
                'question' => 'Siapa saja yang bisa bergabung dengan ISC?',
                'answered' => 'Semua Mahasiswa yang berstatus aktif dari Universitas Sulawesi Barat dapat bergabung, baik yang baru belajar maupun yang sudah berpengalaman di bidang teknologi.'
            ],
            [
                'question' => 'ISC memiliki divisi apa saja?',
                'answered' => 'ISC memiliki 5 divisi utama: Mobile, Web, UI/UX, IoT, dan Sistem Cerdas. Selain itu, ada 2 tim pendukung: Tim Kreatif dan Tim Marketing.'
            ],
            [
                'question' => 'Apakah saya harus jago ngoding untuk ikut ISC?',
                'answered' => 'Tidak! ISC terbuka untuk semua level, mulai dari pemula hingga mahir. Justru ISC akan membantu kamu berkembang lewat mentoring, project, dan kegiatan belajar bersama.'
            ],
            [
                'question' => 'Kegiatan apa saja yang biasa dilakukan ISC?',
                'answered' => 'Kami rutin mengadakan workshop, pelatihan, studi kasus, diskusi mingguan, proyek bersama, hingga pengiriman delegasi untuk lomba atau kompetisi teknologi.'
            ],
            [
                'question' => 'Bagaimana cara mendaftar ke ISC?',
                'answered' => 'Pendaftaran biasanya dibuka setiap awal semester melalui platform web ISC. Ikuti media sosial ISC untuk info terbaru!'
            ]
        ]);
    }
}
