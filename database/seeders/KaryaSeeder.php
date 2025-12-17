<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karya;

class KaryaSeeder extends Seeder
{
    public function run(): void
    {
        Karya::create([
            'judul' => 'Karya 1',
            'deskripsi' => 'Deskripsi singkat karya 1',
            'image' => 'images/karya1.jpg'
        ]);

        Karya::create([
            'judul' => 'Karya 2',
            'deskripsi' => 'Deskripsi singkat karya 2',
            'image' => 'images/karya2.jpg'
        ]);

        Karya::create([
            'judul' => 'Karya 3',
            'deskripsi' => 'Deskripsi singkat karya 3',
            'image' => 'images/karya3.jpg'
        ]);
    }
}
