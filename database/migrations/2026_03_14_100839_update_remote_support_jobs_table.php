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
        Schema::table('remote_support_jobs', function (Blueprint $table) {
            //
            $table->enum('status', ['pending', 'assigned_remote_support', 'in_progress', 'escalated', 'resolved', 'unresolved'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remote_support_jobs', function (Blueprint $table) {
            //
            $table->enum('status', ['pending', 'assigned_remote_support', 'in_progress', 'resolved', 'unresolved'])->default('pending')->change();
        });
    }
};
