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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // ID unik dari kita (misal: POS-12345)
            $table->decimal('amount', 12, 2);     // Nominal bayar
            $table->string('status')->default('pending'); // pending, paid, expire, cancel
            $table->string('snap_token')->nullable(); // Token dari Midtrans
            $table->string('payment_type')->nullable(); // qris, gopay, bank_transfer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
