<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('form_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('form_field_id')->constrained()->onDelete('cascade'); // Menjawab soal yang mana
            $table->text('answer_text')->nullable(); // Untuk jawaban teks/angka/tanggal
            $table->string('answer_file')->nullable(); // Untuk menyimpan path file/gambar jika soalnya upload file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_answers');
    }
};
