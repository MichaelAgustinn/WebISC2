<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // --- HOME ---
            ['section' => 'home', 'key' => 'home_title', 'value' => 'Informatics Study Club', 'type' => 'text'],
            ['section' => 'home', 'key' => 'home_subtitle', 'value' => 'atu-satunya wadah yang fokus untuk meningkatkan Skill Informatika di Universitas Sulawesi Barat', 'type' => 'textarea'],
            ['section' => 'home', 'key' => 'home_hero_image', 'value' => null, 'type' => 'image'],

            // --- ABOUT ---
            ['section' => 'about', 'key' => 'about_title', 'value' => 'Tentang Kami', 'type' => 'text'],
            ['section' => 'about', 'key' => 'about_description', 'value' => 'Kami adalah organisasi yang berdedikasi untuk mengembangkan talenta muda di bidang teknologi. Dengan semangat kolaborasi, kami menjembatani kesenjangan antara teori akademis dan kebutuhan industri.

Kami percaya bahwa teknologi terbaik lahir dari perpaduan antara keahlian teknis yang mendalam dan kreativitas tanpa batas.', 'type' => 'textarea'],
            ['section' => 'about', 'key' => 'about_image', 'value' => null, 'type' => 'image'],

            // --- VISI MISI ---
            ['section' => 'visimisi', 'key' => 'visi', 'value' => 'Menjadi pusat keunggulan teknologi mahasiswa yang diakui secara nasional, mencetak inovator handal yang siap menghadapi tantangan industri global.', 'type' => 'textarea'],
            ['section' => 'visimisi', 'key' => 'misi', 'value' => 'Menyelenggarakan pelatihan teknologi yang relevan dan mutakhir.
Membangun ekosistem kolaborasi antar disiplin ilmu.
Menciptakan solusi digital yang bermanfaat bagi masyarakat.', 'type' => 'textarea'],

            // --- FOOTER & CONTACT ---
            ['section' => 'footer', 'key' => 'contact_address', 'value' => 'Majene, Sulawesi Barat', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'contact_email', 'value' => 'isc@unsulbar.ac.id', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'contact_phone', 'value' => '08123456789', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'social_instagram', 'value' => 'https://instagram.com', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'social_facebook', 'value' => 'https://facebook.com', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'social_youtube', 'value' => 'https://youtube.com', 'type' => 'text'],
            ['section' => 'footer', 'key' => 'social_tiktok', 'value' => 'https://tiktok.com', 'type' => 'text'],
        ];

        foreach ($data as $item) {
            LandingPage::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
