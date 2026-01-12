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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed', 'buy_x_get_y'])->default('percentage')->comment('0 - Percentage, 1 - Fixed, 2 - Buy X Get Y'); // percentage, fixed, buy_x_get_y
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount', 15, 2)->nullable();
            $table->decimal('min_purchase_amount', 15, 2)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->integer('usage_per_customer')->default(1);
            $table->boolean('is_active')->default(true);
            $table->text('applicable_categories')->nullable();
            $table->text('applicable_brands')->nullable();
            $table->text('excluded_products')->nullable();
            $table->boolean('stackable')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index('code', 'is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
