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
        Schema::create('ecommerce_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('sku')->unique();

            $table->json('with_installation')->nullable();

            $table->string('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->longText('technical_specification')->nullable();

            $table->integer('min_order_qty')->default(1);
            $table->integer('max_order_qty')->nullable();

            $table->decimal('shipping_charges', 10, 2)->nullable();
            $table->enum('shipping_class', [0, 1, 2, 3])->default(1)->comment('0 - Light, 1 - Medium, 2 - Heavy, 3 - Fragile');

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_suggested')->default(false);
            $table->boolean('is_todays_deal')->default(false);

            $table->json('product_tags')->nullable();

            $table->enum('status', [0, 1, 2])->default(1)->comment('0 - Inactive, 1 - Active, 2 - Draft');

            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_product_url_slug')->nullable()->unique();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_products');
    }
};
