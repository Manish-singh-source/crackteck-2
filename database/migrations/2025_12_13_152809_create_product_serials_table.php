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
        Schema::create('product_serials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('auto_generated_serial')->unique();
            $table->string('manual_serial')->nullable()->unique();

            $table->decimal('cost_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2);

            $table->string('main_product_image')->nullable();
            $table->json('additional_product_images')->nullable();

            $table->json('variations')->nullable();

            $table->enum('status', [0, 1, 2, 3])->default(1)->comment('0 - Inactive, 1 - Active, 2 - Sold, 3 - Scrap');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serials');
    }
};
