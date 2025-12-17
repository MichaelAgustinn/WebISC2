<?php

namespace Database\Seeders;

use App\Models\Creation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Miky',
                'email' => 'miky@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'Anggota',
            ],
            [
                'name' => 'Mawan',
                'email' => 'mawan@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'Anggota',
            ],
            [
                'name' => 'Ria',
                'email' => 'ria@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'Anggota',
            ],
            [
                'name' => 'Nobul',
                'email' => 'nobul@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'Anggota',
            ]
        ]);

        $this->call([
            LandingPageSeeder::class,
            FaqSeeder::class,
            LogoSeeder::class,
            FooterSeeder::class,
            ProfileSeeder::class,
            BlogSeeder::class,
            TagSeeder::class,
            TestimonialSeeder::class,
            MentorSeeder::class,
            InformationSeeder::class,
            PengurusSeeder::class,
            VoucherSeeder::class,
            // KaryaSeeder::class,
        ]);

        DB::table('blog_tag')->insert([
            [
                'blog_id' => 1,
                'tag_id' => 1,
            ],
            [
                'blog_id' => 1,
                'tag_id' => 2,
            ],
            [
                'blog_id' => 1,
                'tag_id' => 3,
            ]
        ]);

        Creation::factory(20)->create()->each(function ($creation) {
            // Ambil 1–3 user secara acak dari id 1–5
            $creatorId = collect([2, 3, 4, 5])->random();
            $memberIds = collect([2, 3, 4, 5])
                ->reject(fn($id) => $id === $creatorId)
                ->random(rand(1, 2))
                ->toArray();

            $creation->users()->attach([
                $creatorId => ['is_creator' => true],
            ] + collect($memberIds)->mapWithKeys(fn($id) => [$id => ['is_creator' => false]])->toArray());
        });
    }
}
