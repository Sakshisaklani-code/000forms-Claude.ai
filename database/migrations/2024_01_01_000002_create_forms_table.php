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
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('name');
            $table->string('slug')->unique(); // The public form ID (e.g., f_x8k2m9)
            $table->string('recipient_email');
            $table->boolean('email_verified')->default(false);
            $table->string('email_verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            
            // Settings
            $table->enum('status', ['active', 'paused', 'disabled'])->default('active');
            $table->string('redirect_url')->nullable(); // Custom thank-you page
            $table->string('success_message')->default('Thank you for your submission!');
            $table->boolean('honeypot_enabled')->default(true);
            $table->string('honeypot_field')->default('_gotcha');
            $table->boolean('email_notifications')->default(true);
            $table->boolean('store_submissions')->default(true);
            
            // Stats
            $table->unsignedBigInteger('submission_count')->default(0);
            $table->unsignedBigInteger('spam_count')->default(0);
            $table->timestamp('last_submission_at')->nullable();
            
            // Metadata
            $table->json('allowed_domains')->nullable(); // Restrict form to specific domains
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index('slug');
            $table->index('recipient_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
