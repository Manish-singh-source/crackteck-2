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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('vendor_purchase_order_id')
                ->constrained('vendor_purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('parent_category_id')
                ->constrained('parent_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('sub_category_id')
                ->constrained('sub_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('product_name');
            $table->string('hsn_code');
            $table->string('sku')->unique();
            $table->string('model_no');
            $table->string('short_description')->nullable();
            $table->string('full_description')->nullable();
            $table->string('technical_specification')->nullable();
            $table->string('brand_warranty')->nullable();
            $table->string('company_warranty')->nullable();

            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('tax', 5, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();

            $table->integer('stock_quantity');
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'low_stock', 'scrap'])->default('in_stock');

            $table->string('main_product_image')->nullable();
            $table->text('additional_product_images')->nullable();
            $table->string('datasheet_manual')->nullable();

            $table->text('variation_options')->nullable();

            $table->enum('status', ['inactive', 'active'])->default('active');

            $table->softDeletes();
            $table->timestamps();

            $table->index('product_name');
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
