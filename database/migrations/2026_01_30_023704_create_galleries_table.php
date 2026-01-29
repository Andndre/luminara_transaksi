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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('business_unit'); // 'photobooth' or 'visual'
            $table->string('image_path');
            $table->string('title')->nullable(); // Optional: untuk caption
            $table->boolean('is_featured')->default(false); // Penanda "Foto Terbaik" untuk Background
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};