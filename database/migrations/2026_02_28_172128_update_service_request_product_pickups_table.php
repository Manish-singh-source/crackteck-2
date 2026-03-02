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
        Schema::table('service_request_product_pickups', function (Blueprint $table) {
            // Add customer_approved_at and customer_rejected_at after admin_approved_at
            $table->timestamp('customer_approved_at')->nullable()->after('admin_approved_at');
            $table->timestamp('customer_rejected_at')->nullable()->after('customer_approved_at');
            
            // Change status column to include new options
            $table->enum('status', [
                'pending',
                'admin_approved',
                'customer_approved',
                'customer_rejected',
                'assigned',
                'approved',
                'picked',
                'received',
                'cancelled',
                'returned',
                'completed'
            ])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_request_product_pickups', function (Blueprint $table) {
            $table->dropColumn(['customer_approved_at', 'customer_rejected_at']);
            
            // Revert status column to original values
            $table->enum('status', [
                'pending',
                'admin_approved',
                'assigned',
                'approved',
                'picked',
                'received',
                'cancelled',
                'returned',
                'completed'
            ])->default('pending')->change();
        });
    }
};
