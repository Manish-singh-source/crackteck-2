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
        Schema::table('scrap_items', function (Blueprint $table) {
            $table->string('serial_number')->nullable()->after('product_serial_id');
            $table->string('product_name')->nullable()->after('serial_number');
            $table->string('product_sku')->nullable()->after('product_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scrap_items', function (Blueprint $table) {
            $table->dropColumn(['serial_number', 'product_name', 'product_sku']);
        });
    }
};

