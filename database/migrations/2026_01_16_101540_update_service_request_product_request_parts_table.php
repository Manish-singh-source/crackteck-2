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
        Schema::table('service_request_product_request_parts', function (Blueprint $table) {
            //
            $table->integer('requested_quantity')->nullable()->after('part_id');
            $table->text('reason')->nullable()->after('requested_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_request_product_request_parts', function (Blueprint $table) {
            //
            $table->dropColumn('requested_quantity');
            $table->dropColumn('reason');
        });
    }
};
