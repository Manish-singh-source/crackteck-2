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
        //
        Schema::table('service_request_products', function (Blueprint $table) {
            $table->foreignId('item_code_id')->nullable()->after('description')->constrained('covered_items')->nullOnDelete();
            $table->decimal('service_charge', 15, 2)->nullable()->after('item_code_id');
            $table->string('type')->nullable()->after('name');
            $table->string('purchase_date')->nullable()->after('hsn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('service_request_products', function (Blueprint $table) {
            $table->dropForeign(['item_code_id']);
            $table->dropColumn(['item_code_id', 'service_charge', 'type', 'purchase_date']);
        });
    }
};
