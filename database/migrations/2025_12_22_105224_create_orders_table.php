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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->string('order_number')->unique();

            // Items & Pricing
            $table->integer('total_items')->default(0);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('shipping_charges', 15, 2)->default(0);
            $table->decimal('packaging_charges', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);

            // Address
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_address_details')->onDelete('cascade');
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_address_details')->onDelete('cascade');
            $table->boolean('billing_same_as_shipping')->default(true);

            // Status
            $table->enum('order_status', [0, 1, 2, 3, 4, 5, 6])->default(0)->comment('0 - Pending, 1 - Confirmed, 2 - Processing, 3 - Shipped, 4 - Delivered, 5 - Cancelled, 6 - Returned'); // pending, confirmed, processing, shipped, delivered, cancelled, returned
            $table->enum('payment_status', [0, 1, 2, 3, 4])->default(0)->comment('0 - Pending, 1 - Partial, 2 - Completed, 3 - Failed, 4 - Refunded'); // pending, partial, completed, failed, refunded
            $table->enum('delivery_status', [0, 1, 2, 3, 4])->default(0)->comment('0 - Pending, 1 - In Transit, 2 - Delivered, 3 - Failed, 4 - Returned'); // pending, in_transit, delivered, failed, returned

            // Dates
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->date('expected_delivery_date')->nullable();

            // OTP Verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            // Additional Info
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->enum('source_platform', [0, 1, 2])->default(0)->comment('0 - Website, 1 - Mobile App, 2 - Admin Panel'); // website, mobile_app, admin_panel
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();

            // Return Info
            $table->boolean('is_returnable')->default(true);
            $table->integer('return_days')->default(30);
            $table->enum('return_status', [0, 1, 2])->comment('0 - Pending, 1 - Approved, 2 - Rejected')->nullable();
            $table->decimal('refund_amount', 15, 2)->nullable();
            $table->enum('refund_status', [0, 1, 2])->comment('0 - Pending, 1 - Processed, 2 - Cancelled')->nullable(); // pending, processed, cancelled

            // Metrics
            $table->boolean('is_priority')->default(false);
            $table->boolean('requires_signature')->default(false);
            $table->boolean('is_gift')->default(false);

            // Created & Updated By
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['customer_id', 'order_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
