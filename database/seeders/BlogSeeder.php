<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::insert([
            [
                'user_id' => 1,
                'title' => 'Meningkatkan Kreativitas Melalui Workshop: Belajar dari Pengalaman Langsung',
                'slug' => 'meningkatkan-kreativitas-melalui-workshop-belajar-dari-pengalaman-langsung',
                'content' => '<p data-start="244" data-end="558" style="text-align: center; "><img src="http://localhost:8000/storage/blog/blog_inline_690b81b7c8c06.webp" data-filename="image.png" style="width: 50%;"></p><p data-start="244" data-end="558" style="text-align: center; "><br></p><p data-start="244" data-end="558">Dalam dunia yang terus berkembang pesat, belajar tidak lagi cukup hanya melalui teori. Kini, banyak orang mulai beralih ke metode pembelajaran praktis seperti <strong data-start="403" data-end="415">workshop</strong>. Melalui workshop, peserta tidak hanya mendapatkan pengetahuan, tetapi juga pengalaman langsung dalam menerapkan keterampilan yang dipelajari.</p><p data-start="560" data-end="830">Workshop biasanya dirancang untuk menciptakan suasana belajar yang interaktif. Peserta dapat berdiskusi, mencoba berbagai teknik, serta mendapatkan bimbingan langsung dari fasilitator berpengalaman. Dengan demikian, proses belajar menjadi lebih efektif dan menyenangkan.</p><p data-start="832" data-end="1150">Salah satu keunggulan utama workshop adalah kesempatan untuk <strong data-start="893" data-end="908">berjejaring</strong>. Peserta dapat bertemu dengan individu lain yang memiliki minat dan tujuan serupa, membuka peluang kolaborasi dan pertukaran ide. Tidak jarang, hubungan yang terbentuk di dalam workshop berlanjut menjadi kerja sama profesional di masa depan.</p><p data-start="1152" data-end="1397">Selain itu, workshop juga sering menjadi tempat yang tepat untuk <strong data-start="1217" data-end="1245">menemukan inspirasi baru</strong>. Ketika terlibat langsung dalam proses kreatif, seseorang akan lebih mudah menemukan ide-ide segar yang mungkin tidak muncul saat belajar secara pasif.</p><p></p><p data-start="1399" data-end="1639">Dengan mengikuti workshop, kamu tidak hanya menambah pengetahuan dan keterampilan, tetapi juga memperluas wawasan dan koneksi. Jadi, jika kamu ingin berkembang di bidang apa pun, cobalah untuk mengikuti workshop yang relevan dengan minatmu!</p>',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
