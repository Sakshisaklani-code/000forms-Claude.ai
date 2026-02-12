<?php
// database/migrations/2024_01_02_000000_add_auto_response_to_forms_table.php

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
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('auto_response_enabled')->default(false)->after('email_notifications');
            $table->text('auto_response_message')->nullable()->after('auto_response_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn(['auto_response_enabled', 'auto_response_message']);
        });
    }
};