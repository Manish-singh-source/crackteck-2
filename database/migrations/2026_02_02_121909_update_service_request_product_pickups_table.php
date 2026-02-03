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
            //
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
            ])->change();

            // Add new column
            $table->string('admin_approved_at')->nullable()->after('otp_expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_request_product_pickups', function (Blueprint $table) {
            //
            $table->enum('status', [
                'pending',
                'assigned',
                'approved',
                'picked',
                'received',
                'cancelled',
                'returned',
                'completed'
            ])->change();

            // Drop new column
            $table->dropColumn('admin_approved_at');
        });
    }
};
