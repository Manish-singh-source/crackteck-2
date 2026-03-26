<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refund_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('return_order_id')->nullable()->constrained('return_orders')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->enum('refund_context', ['cancelled_order', 'returned_order']);
            $table->text('account_holder_name');
            $table->text('bank_name');
            $table->text('account_number');
            $table->string('ifsc_code', 20);
            $table->string('branch_name')->nullable();
            $table->string('upi_id')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'refund_context']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_bank_details');
    }
};
