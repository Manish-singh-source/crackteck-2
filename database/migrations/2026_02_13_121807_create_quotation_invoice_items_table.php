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
        Schema::create('quotation_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_invoice_id');
            $table->unsignedBigInteger('quotation_products_id')->nullable();

            $table->integer('quantity');
            $table->index(['quotation_invoice_id']);
            $table->index(['quotation_products_id']);

            // Snapshot of product details at time of invoice
            $table->string('product_name')->nullable();
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_per_unit', 10, 2)->default(0);
            $table->decimal('tax_rate', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('line_subtotal', 10, 2);
            $table->decimal('line_total', 10, 2);
            $table->timestamps();

            $table->foreign('quotation_invoice_id')
                ->references('id')
                ->on('quotation_invoices')
                ->onDelete('cascade');

            $table->foreign('quotation_products_id')
                ->references('id')
                ->on('quotation_products')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_invoice_items');
    }
};
