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
        Schema::table('orders', function (Blueprint $table) {
            // Add new status column for delivery tracking
            $table->enum('status', ['pending', 'admin_approved', 'assigned_delivery_man', 'order_accepted', 'product_taken', 'delivered', 'cancelled', 'returned'])
                  ->default('pending')
                  ->after('order_status')
                  ->comment('New status for delivery tracking: pending, admin_approved, assigned_delivery_man, order_accepted, product_taken, delivered, cancelled, returned');

            // Add assigned_at after confirmed_at
            $table->timestamp('assigned_at')->nullable()->after('confirmed_at');

            // Add accepted_at after assigned_at
            $table->timestamp('accepted_at')->nullable()->after('assigned_at');

            // Add cancelled_at after delivered_at
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');

            $table->dropColumn('order_status', 'delivery_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status', 'assigned_at', 'accepted_at', 'cancelled_at']);
            $table->enum('order_status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'])->default('pending')->comment('0 - Pending, 1 - Confirmed, 2 - Processing, 3 - Shipped, 4 - Delivered, 5 - Cancelled, 6 - Returned'); // pending, confirmed, processing, shipped, delivered, cancelled, returned
            $table->enum('delivery_status', ['pending', 'in_transit', 'delivered', 'failed', 'returned'])->default('pending')->comment('0 - Pending, 1 - In Transit, 2 - Delivered, 3 - Failed, 4 - Returned'); // pending, in_transit, delivered, failed, returned

        });
    }
};
