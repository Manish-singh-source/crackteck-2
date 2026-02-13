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
        Schema::create('quotation_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date');

            $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('amc_plan_id')->nullable();

            $table->index(['quote_id']);
            $table->index(['customer_id']);
            $table->index(['staff_id']);
            $table->index(['amc_plan_id']);

            $table->integer('total_items');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('round_off', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            $table->string('currency');
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected', 'cancelled'])->default('draft');

            $table->text('notes')->nullable();
            $table->boolean('terms_and_conditions')->default(false);
            // Payment / snapshot fields
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_invoices');
    }
};
