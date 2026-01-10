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
        Schema::create('service_request_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->string('transaction_id');
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_gateway')->nullable();
            $table->enum('payment_method', ['online', 'cod', 'cheque', 'bank_transfer'])->default('online')->comment('0 - Online, 1 - COD, 2 - Cheque, 3 - Bank Transfer'); 
            $table->enum('payment_status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'partial_paid'])->default('pending')->comment('0 - Pending, 1 - Processing, 2 - Completed, 3 - Failed, 4 - Refunded, 5 - Partial Paid'); 
            $table->timestamp('payment_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_payments');
    }
};
