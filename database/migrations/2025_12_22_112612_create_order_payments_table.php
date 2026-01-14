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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('payment_id')->unique();
            $table->string('transaction_id')->nullable()->unique();
            $table->enum('payment_method', ['online', 'cod', 'cheque', 'bank_transfer'])->default('online')->comment('0 - Online, 1 - COD, 2 - Cheque, 3 - Bank Transfer'); // online, cod, cheque, bank_transfer
            $table->string('payment_gateway')->nullable(); // phonepe, razorpay, etc.
            $table->decimal('amount', 15, 2);
            $table->string('currency')->default('INR');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending')->comment('0 - Pending, 1 - Processing, 2 - Completed, 3 - Failed, 4 - Refunded'); // pending, processing, completed, failed, refunded
            $table->text('response_data')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->index(['order_id', 'status', 'payment_id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
