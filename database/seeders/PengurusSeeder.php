<?php

namespace Database\Seeders;

use App\Models\Pengurus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengurus::insert([
            [
                "name" => "Ahmad Khanif Izzah Arifin",
                'jabatan' => 'Ketua Umum',
                'image' => 'storage/pengurus/pengurus_691199073553c.webp',
            ],
            [
                'name' => 'Armawan',
                'jabatan' => 'Wakil Ketua Umum',
                'image' => 'storage/pengurus/pengurus_6911992064d86.webp'
            ],
            [
                'name' => 'Ariqah Maheswari AP',
                'jabatan' => 'Sekretaris',
                'image' => 'storage/pengurus/pengurus_6911993103179.webp',
            ],
            [
                'name' => 'Deananda',
                'jabatan' => 'Bendahara',
                'image' => 'storage/pengurus/pengurus_691199422c426.webp'
            ],
            [
                'name' => 'Arhamullah Kamaruddin',
                'jabatan' => 'Koordinator Divisi Website',
                'image' => 'storage/pengurus/pengurus_6911996164859.webp'
            ],
            [
                'name' => 'Rahmadi',
                'jabatan' => 'Koordinator Divisi Mobile',
                'image' => 'storage/pengurus/pengurus_6911997225411.webp'
            ],
            [
                'name' => 'Muhammad Zuhdi',
                'jabatan' => 'Koordinator Divisi Sistem Cerdas',
                'image' => 'storage/pengurus/pengurus_691199846f13d.webp'
            ],
            [
                'name' => 'Muhammad Naufal',
                'jabatan' => 'Koordinator Divisi IoT',
                'image' => 'storage/pengurus/pengurus_69119993c0cb3.webp'
            ],
            [
                'name' => 'Muh. Sugandi',
                'jabatan' => 'Koordinator Divisi UI/UX',
                'image' => 'storage/pengurus/pengurus_691199ae3a500.webp'
            ],
            [
                'name' => 'Rifqah S',
                'jabatan' => 'Ketua Tim Creative',
                'image' => 'storage/pengurus/pengurus_691199e3dd4bb.webp'
            ],
            [
                'name' => 'Greis Banne Lilling',
                'jabatan' => 'Ketua Tim Marketing',
                'image' => 'storage/pengurus/pengurus_69119a081bb34.webp'
            ]
        ]);
    }
}
