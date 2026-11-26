<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('vendor_code');
        });

        Schema::table('vendor_purchase_orders', function (Blueprint $table) {
            $table->string('po_number')->nullable()->change();
            $table->dropUnique('vendor_purchase_orders_invoice_number_unique');
            $table->unique(['vendor_id', 'invoice_number'], 'vendor_invoice_vendor_number_unique');
        });

    }

    public function down(): void
    {
        Schema::table('vendor_purchase_orders', function (Blueprint $table) {
            $table->dropUnique('vendor_invoice_vendor_number_unique');
            $table->unique('invoice_number');
            $table->string('po_number')->nullable(false)->change();
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('company_name');
        });
    }
};
