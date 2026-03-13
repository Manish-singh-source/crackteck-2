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
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->foreignId('service_request_product_id')
                ->constrained('service_request_products')
                ->onDelete('cascade')
                ->onUpdate('cascade')->after('remote_support_job_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->dropColumn('service_request_product_id');
        });
    }
};
