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
        Schema::table('quotation_products', function (Blueprint $table) {
            //
            $table->decimal('unit_price', 15, 2)->nullable()->default(0)->change();
            $table->decimal('line_total', 15, 2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_products', function (Blueprint $table) {
            //
            $table->decimal('unit_price', 15, 2)->change();
            $table->decimal('line_total', 15, 2)->change();
        });
    }
};
