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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            
            // Customer Info (Snapshot from booking, but editable)
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_address')->nullable();

            // Financials
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_percent', 5, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('dp_amount', 15, 2)->default(0);
            $table->decimal('balance_due', 15, 2)->default(0); // Sisa tagihan

            $table->string('status')->default('UNPAID'); // UNPAID, PARTIAL, PAID, CANCELLED
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->boolean('is_bonus')->default(false); // Free item indicator
            $table->timestamps();
        });
        
        // Add dp_amount to bookings table if not exists (for initial capture)
        if (!Schema::hasColumn('bookings', 'dp_amount')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->decimal('dp_amount', 15, 2)->default(0)->after('price_total');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        
        if (Schema::hasColumn('bookings', 'dp_amount')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('dp_amount');
            });
        }
    }
};