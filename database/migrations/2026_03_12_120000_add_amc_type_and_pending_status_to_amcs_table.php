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
        // Add amc_type column to amcs table
        Schema::table('amcs', function (Blueprint $table) {
            $table->enum('amc_type', ['remote', 'onsite'])->nullable()->after('service_type');
        });

        // Update status to include 'pending'
        Schema::table('amcs', function (Blueprint $table) {
            $table->enum('status', ['active', 'completed', 'expired', 'cancelled', 'pending'])->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amcs', function (Blueprint $table) {
            $table->dropColumn('amc_type');
        });

        Schema::table('amcs', function (Blueprint $table) {
            $table->enum('status', ['active', 'completed', 'expired', 'cancelled'])->default('active')->change();
        });
    }
};
