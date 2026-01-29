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
        // Add division to Users table (default to super_admin or photobooth for existing)
        Schema::table('users', function (Blueprint $table) {
            $table->string('division')->default('super_admin')->after('email'); 
            // Values: 'super_admin', 'photobooth', 'visual'
        });

        // Add business_unit to Bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('business_unit')->default('photobooth')->after('id');
            // Values: 'photobooth', 'visual'
        });

        // Add business_unit to Packages table
        Schema::table('packages', function (Blueprint $table) {
            $table->string('business_unit')->default('photobooth')->after('id');
            // Values: 'photobooth', 'visual'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('division');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('business_unit');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('business_unit');
        });
    }
};