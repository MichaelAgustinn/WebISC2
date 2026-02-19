<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'Apa itu ISC?',
                'answer' => 'Informatics Study Club adalah wadah mahasiswa untuk belajar dan berdiskusi seputar teknologi bersama di luar jam kuliah.'
            ],
            [
                'question' => 'Apa tujuan ISC?',
                'answer' => 'ISC bertujuan meningkatkan kemampuan teknis dan soft skill mahasiswa di bidang teknologi melalui mentoring, sharing session, dan project bersama.'
            ],
            [
                'question' => 'Bagaimana cara bergabung?',
                'answer' => 'Anda bisa mendaftar saat open recruitment yang diadakan setiap awal semester ganjil. Informasi pendaftaran biasanya diumumkan melalui media sosial resmi ISC.'
            ],
            [
                'question' => 'Siapa saja yang boleh bergabung?',
                'answer' => 'Seluruh mahasiswa yang memiliki minat di bidang teknologi dan ingin belajar bersama dipersilakan untuk bergabung, tanpa memandang jurusan atau angkatan.'
            ],
            [
                'question' => 'Apakah harus jago koding?',
                'answer' => 'Tidak. Yang terpenting adalah kemauan untuk belajar. Kita akan belajar dari nol bersama-sama dengan bimbingan mentor.'
            ],
            [
                'question' => 'Kegiatan apa saja yang ada di ISC?',
                'answer' => 'Kegiatan ISC meliputi kelas rutin, workshop, sharing session, pengerjaan project tim, serta persiapan lomba atau kompetisi di bidang teknologi.'
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
