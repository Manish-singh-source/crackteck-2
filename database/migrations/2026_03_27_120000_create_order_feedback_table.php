<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the order_feedback table for storing customer reviews/feedback
     * for delivered order products.
     * 
     * Status defaults to 'inactive' to allow admin review workflow:
     * - Admin can review feedback before making it public
     * - Prevents inappropriate content from appearing immediately
     * - Admin can activate feedback after verification
     */
    public function up(): void
    {
        Schema::create('order_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('customer_id');
            $table->text('feedback')->nullable();
            $table->unsignedTinyInteger('star'); // 1 to 5 rating
            $table->enum('status', ['inactive', 'active'])->default('inactive');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('ecommerce_products')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            // Unique constraint: one feedback per order/product/customer combination
            $table->unique(['order_id', 'product_id', 'customer_id'], 'order_product_customer_unique');

            // Indexes for better query performance
            $table->index('status');
            $table->index('product_id');
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_feedback');
    }
};
