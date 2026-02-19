<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add is_archived to submissions table
        Schema::table('submissions', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('is_spam');
        });

        // Add archive_when_paused to forms table
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('archive_when_paused')->default(true)->after('status');
        });

        // Index for fast tab queries
        Schema::table('submissions', function (Blueprint $table) {
            $table->index(['form_id', 'is_archived', 'is_spam'], 'submissions_form_archive_spam_idx');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropIndex('submissions_form_archive_spam_idx');
            $table->dropColumn('is_archived');
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('archive_when_paused');
        });
    }
};