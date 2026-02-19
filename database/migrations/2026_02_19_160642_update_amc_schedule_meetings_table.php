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
        Schema::table('amc_schedule_meetings', function (Blueprint $table) {

            // Drop existing foreign key first
            $table->dropForeign(['service_request_id']);

            // Modify column to nullable
            $table->unsignedBigInteger('service_request_id')->nullable()->change();

            // Re-add foreign key
            $table->foreign('service_request_id')
                  ->references('id')
                  ->on('service_requests')
                  ->onDelete('cascade');

            // Add new amc_id column
            $table->foreignId('amc_id')
                  ->nullable()
                  ->after('service_request_id')
                  ->constrained('amcs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amc_schedule_meetings', function (Blueprint $table) {

            // Drop amc_id foreign key and column
            $table->dropForeign(['amc_id']);
            $table->dropColumn('amc_id');

            // Drop modified foreign key
            $table->dropForeign(['service_request_id']);

            // Make service_request_id NOT nullable again
            $table->unsignedBigInteger('service_request_id')->nullable(false)->change();

            // Re-add foreign key
            $table->foreign('service_request_id')
                  ->references('id')
                  ->on('service_requests')
                  ->onDelete('cascade');
        });
    }
};
