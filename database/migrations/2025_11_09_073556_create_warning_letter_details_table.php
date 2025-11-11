<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warning_letter_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained('letters')->cascadeOnDelete();
            $table->enum('peringatan_ke', ['1', '2', '3']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warning_letter_details');
    }
};
