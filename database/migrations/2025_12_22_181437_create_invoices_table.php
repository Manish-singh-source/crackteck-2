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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->string('invoice_number')->unique();
            $table->string('invoice_id')->unique();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('currency')->default('INR');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'draft', 'sent', 'viewed', 'partially_paid', 'paid', 'cancelled'])->default('pending')->comment('0 - Draft, 1 - Sent, 2 - Viewed, 3 - Partially Paid, 4 - Paid, 5 - Cancelled'); // draft, sent, viewed, partially_paid, paid, overdue, cancelled
            $table->text('notes')->nullable();
            $table->string('invoice_document_path')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
