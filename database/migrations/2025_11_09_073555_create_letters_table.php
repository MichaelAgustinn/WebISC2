<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_surat', ['peringatan', 'peminjaman_tempat', 'peminjaman_alat']);
            $table->date('tanggal');
            $table->string('nomor_surat');
            $table->string('nama_ketua');
            $table->string('jabatan_ketua')->default('Ketua Umum ISC');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
