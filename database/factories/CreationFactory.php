<?php

namespace Database\Factories;

use App\Models\Creation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CreationFactory extends Factory
{
    protected $model = Creation::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $slug = Str::slug($title);
        $divisiOptions = ['Website', 'Mobile', 'IoT', 'SistemCerdas', 'UI/UX'];
        $statusOptions = ['pending', 'approve', 'rejected'];

        return [
            'title'   => $title,
            'slug'    => $slug,
            // Simulasi konten summernote dengan <p> dan <img>
            'content' => $this->generateSummernoteContent(),
            'divisi'  => $this->faker->randomElement($divisiOptions),
            'status'  => $this->faker->randomElement($statusOptions),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Membuat konten mirip Summernote (HTML lengkap)
     */
    private function generateSummernoteContent(): string
    {
        $paragraphs = collect(range(1, rand(2, 4)))
            ->map(fn() => '<p>' . $this->faker->paragraph() . '</p>')
            ->implode('');

        // Contoh gambar random
        $imageUrl = $this->faker->imageUrl(640, 480, 'tech', true, 'Random');

        return <<<HTML
            <h4>{$this->faker->sentence(3)}</h4>
            {$paragraphs}
            <img src="{$imageUrl}" alt="example" class="img-fluid" />
            <p>{$this->faker->paragraph()}</p>
        HTML;
    }
}
