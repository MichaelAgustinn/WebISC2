<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\Clock\now;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id' => 1,
            'name' => 'Michael Agustin',
            'email' => 'michaelagustinn080@gmail.com',
            'password' => bcrypt('miky310505'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Profile::insert([
            'id' => 1,
            'user_id' => 1,
            'nim' => 'D0223310',
            'phone_number' => '082193295789',
            'angkatan' => '2023',
            'division' => 'website',
            'special_team' => 'Tim Kreatif',
            'photo' => '1771124721_2.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call([
            LandingPageSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
