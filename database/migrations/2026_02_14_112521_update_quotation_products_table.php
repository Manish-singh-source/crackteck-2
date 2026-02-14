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
        Schema::table('quotation_products', function (Blueprint $table) {
            //
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('model_no')->nullable();
            $table->string('sku')->nullable();
            $table->string('hsn')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();

            $table->dropColumn(['product_name', 'product_description', 'hsn_code']); // drop old columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_products', function (Blueprint $table) {
            //
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->string('hsn_code')->nullable();

            $table->dropColumn(['name', 'type', 'model_no', 'hsn', 'purchase_date', 'brand', 'description', 'images']);
        });
    }
};
