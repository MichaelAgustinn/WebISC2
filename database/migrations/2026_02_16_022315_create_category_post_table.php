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
        // 1. Buat tabel pivot
        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 2. Hapus kolom category_id lama di tabel posts (Opsional, biar bersih)
        // Pastikan Anda sudah backup data jika aplikasi sudah live
        if (Schema::hasColumn('posts', 'category_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
