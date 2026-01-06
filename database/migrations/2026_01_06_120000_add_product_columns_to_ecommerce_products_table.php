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
        Schema::table('ecommerce_products', function (Blueprint $table) {
            $table->string('company_warranty')->nullable()->after('with_installation');
            $table->string('product_weight', 100)->nullable()->after('max_order_qty');
            $table->string('product_dimensions', 255)->nullable()->after('product_weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecommerce_products', function (Blueprint $table) {
            $table->dropColumn(['company_warranty', 'product_weight', 'product_dimensions']);
        });
    }
};
