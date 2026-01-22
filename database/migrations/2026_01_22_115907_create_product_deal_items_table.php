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
        Schema::create('product_deal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_deal_id')->constrained('product_deals')->onDelete('cascade');
            $table->foreignId('ecommerce_product_id')->constrained('ecommerce_products')->onDelete('cascade');
            $table->decimal('original_price', 15, 2);
            $table->enum('discount_type', ['percentage', 'flat']);
            $table->decimal('discount_value', 15, 2);
            $table->decimal('offer_price', 15, 2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_deal_items');
    }
};
