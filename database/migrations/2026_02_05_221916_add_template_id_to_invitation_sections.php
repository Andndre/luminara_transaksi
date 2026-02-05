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
        Schema::table('invitation_sections', function (Blueprint $table) {
            // Make page_id nullable first
            $table->unsignedBigInteger('page_id')->nullable()->change();

            // Add template_id
            $table->foreignId('template_id')->nullable()->constrained('invitation_templates')->onDelete('cascade');

            // Add index for template_id
            $table->index('template_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitation_sections', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['template_id']);
            $table->dropIndex(['template_id']);

            // Drop column
            $table->dropColumn('template_id');

            // Make page_id not nullable again
            $table->unsignedBigInteger('page_id')->nullable(false)->change();
        });
    }
};
