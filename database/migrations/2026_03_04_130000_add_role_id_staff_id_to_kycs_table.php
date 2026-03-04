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
        Schema::table('kycs', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('document_no');
            $table->unsignedBigInteger('staff_id')->nullable()->after('role_id');
            
            // Add foreign keys
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null');
            
            // Add indexes
            $table->index('role_id');
            $table->index('staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['role_id', 'staff_id']);
        });
    }
};
