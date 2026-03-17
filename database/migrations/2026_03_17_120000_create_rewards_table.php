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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('service_request_id')->nullable();
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->unsignedBigInteger('used_order_id')->nullable();
            $table->unsignedBigInteger('used_service_request_id')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('set null');
            $table->foreign('used_order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('used_service_request_id')->references('id')->on('service_requests')->onDelete('set null');

            // Indexes for better query performance
            $table->index('customer_id');
            $table->index('coupon_id');
            $table->index('order_id');
            $table->index('service_request_id');
            $table->index('status');
            $table->unique(['customer_id', 'coupon_id', 'order_id'], 'unique_reward_per_order');
            $table->unique(['customer_id', 'coupon_id', 'service_request_id'], 'unique_reward_per_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
