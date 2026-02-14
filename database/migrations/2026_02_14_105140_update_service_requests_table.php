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
        Schema::table('service_requests', function (Blueprint $table) {
            //
            // update request_source to be enum with add extra value 'lead_won' 
            $table->enum('request_source', ['system', 'customer', 'lead_won'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            //
            // update request_source to be enum with remove extra value 'lead_won'
            $table->enum('request_source', ['system', 'customer'])->change();
        });
    }
};
