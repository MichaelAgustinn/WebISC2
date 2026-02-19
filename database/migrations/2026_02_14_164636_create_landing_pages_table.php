<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            // Section: home, about, footer, vision_mission
            $table->string('section');
            $table->string('key'); // misal: 'home_title', 'about_image', 'contact_email'
            $table->text('value')->nullable(); // Isi kontennya
            $table->string('type')->default('text'); // text, image, longtext
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
