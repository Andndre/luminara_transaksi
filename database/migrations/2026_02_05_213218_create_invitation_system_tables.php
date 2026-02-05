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
        // Invitation Templates - Master template definitions
        Schema::create('invitation_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Rustic Garden", "Modern Gold"
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->string('thumbnail', 500)->nullable();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable(); // rustic, modern, elegant
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('is_active');
            $table->index('category');
        });

        // Invitation Pages - Created invitations (from templates or blank)
        Schema::create('invitation_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('invitation_templates')->onDelete('set null');
            $table->string('title'); // "Pernikahan Romeo & Juliet"
            $table->string('slug')->unique(); // Public URL
            $table->string('groom_name');
            $table->string('bride_name');
            $table->dateTime('event_date');
            $table->enum('published_status', ['draft', 'published', 'archived'])->default('draft');
            $table->json('meta_data')->nullable(); // SEO, custom settings
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('published_status');
            $table->index('slug');
            $table->index('event_date');
        });

        // Invitation Sections - Components/sections (JSON-based)
        Schema::create('invitation_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('invitation_pages')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('invitation_sections')->cascadeOnDelete();
            $table->string('section_type', 100); // hero, text, image, countdown, rsvp, etc.
            $table->integer('order_index')->default(0);
            $table->json('props'); // Component properties (styles, content)
            $table->text('custom_css')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();

            $table->index(['page_id', 'order_index']);
            $table->index('section_type');
        });

        // Invitation Assets - Media library
        Schema::create('invitation_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('invitation_pages')->onDelete('cascade');
            $table->string('asset_name');
            $table->string('file_path', 500);
            $table->string('file_type', 50); // image, video, audio
            $table->string('mime_type', 100);
            $table->integer('file_size');
            $table->json('dimensions')->nullable(); // {width, height}
            $table->string('alt_text', 255)->nullable();
            $table->timestamps();

            $table->index('page_id');
            $table->index('file_type');
        });

        // Invitation RSVP Responses - RSVP submissions
        Schema::create('invitation_rsvp_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('invitation_pages')->cascadeOnDelete();
            $table->string('guest_name');
            $table->string('guest_phone', 50)->nullable();
            $table->string('guest_email')->nullable();
            $table->enum('attendance_status', ['hadir', 'tidak_hadir', 'ragu']);
            $table->integer('number_of_guests')->default(1);
            $table->text('message')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index('page_id');
            $table->index('attendance_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_rsvp_responses');
        Schema::dropIfExists('invitation_assets');
        Schema::dropIfExists('invitation_sections');
        Schema::dropIfExists('invitation_pages');
        Schema::dropIfExists('invitation_templates');
    }
};
