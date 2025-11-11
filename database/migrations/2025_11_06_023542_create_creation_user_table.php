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
        Schema::create('creation_user', function (Blueprint $table) {
            $table->boolean('is_creator')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('creation_id')->constrained()->onDelete('cascade');
            $table->primary(['user_id', 'creation_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creation_user');
    }
};
