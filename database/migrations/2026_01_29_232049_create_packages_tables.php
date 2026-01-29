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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->unique(); // e.g., 'pb_unlimited', 'videobooth360'
            $table->text('description')->nullable();
            $table->decimal('base_price', 12, 2)->default(0); // Price for minimum duration
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('package_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->integer('duration_hours');
            $table->decimal('price', 12, 2);
            $table->string('description')->nullable(); // e.g. "50 Print", "No Print"
            $table->timestamps();
            
            // Ensure unique price for a specific duration per package
            $table->unique(['package_id', 'duration_hours']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_prices');
        Schema::dropIfExists('packages');
    }
};