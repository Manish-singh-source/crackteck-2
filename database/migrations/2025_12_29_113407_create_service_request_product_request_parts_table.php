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
        Schema::create('service_request_product_request_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('service_request_products')->cascadeOnDelete();
            $table->foreignId('engineer_id')->constrained('assigned_engineers')->cascadeOnDelete();
            $table->foreignId('part_id')->constrained('products')->cascadeOnDelete();
            $table->enum('request_type', ['stock_in_hand', 'part_request'])->comment('0 - Stock In Hand, 1 - Part Request');

            $table->enum('assigned_person_type', ['delivery_man', 'engineer'])->comment('0 - Delivery Man, 1 - Engineer')->nullable();
            $table->foreignId('assigned_person_id')->nullable()->constrained('staff')->cascadeOnDelete();

            $table->enum('status', ['requested', 'approved', 'rejected', 'customer_approved', 'customer_rejected', 'picked', 'in_transit', 'delivered', 'used', 'cancelled'])->default('requested')->comment('0 - Pending, 1 - Approved, 2 - Rejected, 3 - Customer Approved, 4 - Customer Rejected, 5 - Picked, 6 - In Transit, 7 - Delivered, 8 - Used');

            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('customer_approved_at')->nullable();
            $table->timestamp('customer_rejected_at')->nullable();
            $table->timestamp('picked_at')->nullable();
            $table->timestamp('in_transit_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_product_request_parts');
    }
};
