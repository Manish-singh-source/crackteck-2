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
            $table->decimal('weight', 10, 2)->nullable()->after('shipping_class');
            $table->string('dimensions')->nullable()->after('weight');
            $table->string('shipping_time')->nullable()->after('dimensions');
            $table->boolean('cod')->default(false)->after('shipping_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ecommerce_products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'dimensions', 'shipping_time', 'cod']);
        });
    }
};
