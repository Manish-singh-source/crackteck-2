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
        Schema::table('quotation_invoice_items', function (Blueprint $table) {
            //
            // Snapshot of product details at time of invoice            
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('model_no')->nullable();
            $table->string('sku')->nullable();
            $table->string('hsn')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();

            $table->dropColumn(['product_name', 'product_sku', 'product_description']); // drop old columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_invoice_items', function (Blueprint $table) {
            //
            $table->string('product_name')->nullable()->after('quotation_products_id');
            $table->string('product_sku')->nullable()->after('product_name');
            $table->text('product_description')->nullable()->after('product_sku');

            $table->dropColumn(['name', 'type', 'model_no', 'sku', 'hsn', 'purchase_date', 'brand', 'description', 'images']); // drop new columns
        });
    }
};
