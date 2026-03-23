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
        Schema::create('remote_amc_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amc_id')->constrained('amcs')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('amc_plan_id')->nullable()->constrained('amc_plans')->nullOnDelete();
            $table->string('payment_reference')->unique();
            $table->string('gateway')->default('razorpay');
            $table->string('gateway_order_id')->nullable()->unique();
            $table->string('gateway_payment_id')->nullable()->unique();
            $table->string('gateway_signature')->nullable();
            $table->unsignedBigInteger('amount');
            $table->string('currency', 10)->default('INR');
            $table->string('status')->default('created');
            $table->string('method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->json('gateway_payload')->nullable();
            $table->timestamps();

            $table->index(['amc_id', 'status']);
            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_amc_payments');
    }
};
