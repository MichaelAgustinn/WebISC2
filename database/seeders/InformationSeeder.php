<?php

namespace Database\Seeders;

use App\Models\Information;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Information::insert([
            [
                'name' => 'Kartu Rencana Studi (KRS) Kurikulum 2023',
                'file' => 'storage/information/kartu-rencana-studi-krs-kurikulum-2023.docx',
            ],
            [
                'name' => 'KARTU KONTROL MENGIKUTI SEMINAR',
                'file' => 'storage/information/kartu-kontrol-mengikuti-seminar.docx',
            ]
        ]);
    }
}
