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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('package_id')->nullable();
            $table->string('package_name');
            $table->string('package_type'); // photobooth | videobooth360 | combo
            $table->integer('duration_hours');
            $table->decimal('price_total', 15, 2);
            $table->string('payment_type'); // DP | LUNAS | NONE
            $table->date('event_date');
            $table->time('event_time');
            $table->text('event_location');
            $table->string('event_type')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('PENDING'); // PENDING | DP_DIBAYAR | LUNAS | DIBATALKAN
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};