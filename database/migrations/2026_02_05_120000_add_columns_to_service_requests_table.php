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
            // Add customer_address_id after customer_id
            $table->foreignId('customer_address_id')->nullable()->constrained('customer_address_details')->nullOnDelete()->after('customer_id');
            
            // Add visit_date and reschedule_date after request_source
            $table->date('visit_date')->nullable()->after('request_source');
            $table->date('reschedule_date')->nullable()->after('visit_date');
        });

        // Update the enum to include new status options
        Schema::table('service_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'admin_approved', 'assigned_engineer', 'engineer_approved', 'engineer_not_approved', 'in_transfer', 'transferred', 'in_progress', 'picking', 'picked', 'completed', 'reschedule', 'cancelled'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['customer_address_id']);
            $table->dropColumn('customer_address_id');
            $table->dropColumn('visit_date');
            $table->dropColumn('reschedule_date');
        });

        // Revert the enum back to original values
        Schema::table('service_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'admin_approved', 'assigned_engineer', 'engineer_approved', 'engineer_not_approved', 'in_transfer', 'transferred', 'in_progress', 'picking', 'picked', 'completed'])->default('pending')->change();
        });
    }
};
