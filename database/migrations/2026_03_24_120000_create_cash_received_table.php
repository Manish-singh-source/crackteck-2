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
        Schema::create('cash_received', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('service_request_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['customer_paid', 'received'])->default('customer_paid');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');

            // Indexes for better query performance
            $table->index('customer_id');
            $table->index('staff_id');
            $table->index('order_id');
            $table->index('service_request_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_received');
    }
};