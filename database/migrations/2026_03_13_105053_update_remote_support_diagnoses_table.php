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
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->string('time_spent')->nullable();
            $table->string('client_feedback')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'unresolved'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->dropColumn('time_spent');
            $table->dropColumn('client_feedback');
            $table->dropColumn('status');
        });
    }
};
