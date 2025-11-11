<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_letter_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained('letters')->cascadeOnDelete();
            $table->string('perihal');          // Peminjaman Tempat / Peminjaman Alat
            $table->string('tujuan');           // Tempat/Orang tujuan surat
            $table->string('dasar_kegiatan');   // Atas dasar kegiatan apa
            $table->string('nama_tempat_barang');
            $table->string('hari');             // Hari peminjaman
            $table->string('jam');              // Jam peminjaman
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_letter_details');
    }
};
