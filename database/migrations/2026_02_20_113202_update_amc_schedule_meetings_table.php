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
        Schema::table('amc_schedule_meetings', function (Blueprint $table) {
            // add one more in_progress
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'missed'])->default('scheduled')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amc_schedule_meetings', function (Blueprint $table) {
            //
            $table->enum('status', ['scheduled', 'completed', 'missed'])->default('scheduled')->change();
        });
    }
};
