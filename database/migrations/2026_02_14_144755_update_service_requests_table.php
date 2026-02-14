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
        Schema::table('service_requests', function (Blueprint $table) {
            //
            $table->dropColumn('request_status');
            $table->enum('status', ['pending', 'active', 'inactive', 'expired', 'cancelled', 'admin_approved', 'assigned_engineer', 'engineer_approved', 'engineer_not_approved', 'in_transfer', 'transferred', 'in_progress', 'picking', 'picked', 'completed'])->default('pending')->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            //
            $table->enum('request_status', ['pending', 'approved', 'rejected', 'processing', 'processed', 'picking', 'picked', 'completed'])->default('pending')->index();
            $table->enum('status', ['pending', 'admin_approved', 'assigned_engineer', 'engineer_approved', 'engineer_not_approved', 'in_transfer', 'transferred', 'in_progress', 'picking', 'picked', 'completed'])->default('pending')->comment('0 - Pending, 1 - Admin Approved, 2 - Assigned Engineer, 3 - Engineer Approved, 4 - Engineer Not Approved, 5 - In Transfer, 6 - Transferred, 7 - In Progress, 8 - Picking, 9 - Picked, 10 - Completed, 11 - On Hold')->change(); 
        });
    }
};
