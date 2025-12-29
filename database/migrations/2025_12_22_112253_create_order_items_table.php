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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('cascade');
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('hsn_code')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('discount_per_unit', 15, 2)->default(0);
            $table->decimal('tax_per_unit', 15, 2)->default(0);
            $table->decimal('line_total', 15, 2);
            $table->json('variant_details')->nullable();
            $table->json('custom_options')->nullable();
            $table->enum('item_status', [0, 1, 2, 3, 4])->default(0)->comment('0 - Pending, 1 - Shipped, 2 - Delivered, 3 - Cancelled, 4 - Returned'); // pending, shipped, delivered, cancelled, returned
            $table->softDeletes();
            $table->timestamps();

            $table->index(['order_id', 'item_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
