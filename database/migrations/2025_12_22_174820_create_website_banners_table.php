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
        Schema::create('website_banners', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image_url');

            $table->enum('type', [0, 1])->default(0)->comment('0 - Website, 1 - Promotional');

            $table->enum('channel', [0, 1])->default(0)->comment('0 - Website, 1 - Mobile');

            $table->enum('promotion_type', [0, 1, 2, 3])->comment('0 - Discount, 1 - Coupon, 2 - Flash Sale, 3 - Event')->nullable();

            $table->decimal('discount_value', 8, 2)->nullable();
            $table->enum('discount_type', [0, 1])->comment('0 - Percentage, 1 - Fixed')->nullable();

            $table->string('promo_code')->nullable();

            $table->string('link_url')->nullable();
            $table->enum('link_target', [0, 1])->default(1)->comment('0 - Self, 1 - Blank');

            $table->enum('position', [0, 1, 2, 3, 4, 5])->default(0)->comment('0 - Homepage, 1 - Category, 2 - Product, 3 - Slider, 4 - Checkout, 5 - Cart');

            $table->integer('display_order')->default(0);

            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->boolean('is_active')->default(true);
            $table->integer('click_count')->default(0);
            $table->integer('view_count')->default(0);

            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'channel', 'position', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_banners');
    }
};
