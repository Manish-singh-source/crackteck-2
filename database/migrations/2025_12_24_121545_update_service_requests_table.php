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
            $table->string('service_type')
                ->nullable()
                ->after('request_id')
                ->comment('0 - AMC, 1 - Quick Service, 2 - Installation, 3 - Repair');

            // status add column
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11])->default(0)->comment('0 - Pending, 1 - Admin Approved, 2 - Assigned Engineer, 3 - Engineer Approved, 4 - Engineer Not Approved, 5 - In Transfer, 6 - Transferred, 7 - In Progress, 8 - Picking, 9 - Picked, 10 - Completed, 11 - On Hold'); 
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('service_type');
            // status drop column
            $table->dropColumn('status');
        });
    }
};
