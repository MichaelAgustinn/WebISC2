<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::insert([
            [
                'user_id' => 2,
                'rating' => 5,
                'message' => 'Pelayanan yang sangat memuaskan. Timnya profesional dan cepat tanggap dalam menangani semua kebutuhan saya.'
            ],
            [
                'user_id' => 1,
                'rating' => 5,
                'message' => 'Produk berkualitas tinggi dan sesuai dengan deskripsi. Sangat puas dengan pengalaman belanja di sini!'
            ],
            [
                'user_id' => 3,
                'rating' => 5,
                'message' => 'Sangat puas dengan kualitas layanan dan produk yang diberikan. Tim supportnya juga sangat membantu dan ramah.'
            ],
            [
                'user_id' => 4,
                'rating' => 5,
                'message' => 'Pengalaman menggunakan layanan ini luar biasa. Semua berjalan lancar dan sesuai harapan.'
            ],
            [
                'user_id' => 5,
                'rating' => 5,
                'message' => 'Rekomendasi banget! Produk sampai tepat waktu dan kualitasnya melebihi ekspektasi saya.'
            ],

        ]);
    }
}
