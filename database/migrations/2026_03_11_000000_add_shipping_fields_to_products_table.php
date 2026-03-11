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
        Schema::table('products', function (Blueprint $table) {
            $table->string('weight')->nullable()->after('company_warranty');
            $table->string('dimensions')->nullable()->after('weight');
            $table->string('shipping_time')->nullable()->after('dimensions');
            $table->enum('cod', ['yes', 'no'])->default('no')->nullable()->after('shipping_time');
            $table->enum('installation', ['yes', 'no'])->default('no')->nullable()->after('cod');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'dimensions', 'shipping_time', 'cod', 'installation']);
        });
    }
};
