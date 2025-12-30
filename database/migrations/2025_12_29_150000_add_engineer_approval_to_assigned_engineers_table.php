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
        Schema::table('assigned_engineers', function (Blueprint $table) {
            $table->boolean('is_approved_by_engineer')->default(false)->after('status')->comment('Whether engineer has approved the task');
            $table->timestamp('engineer_approved_at')->nullable()->after('is_approved_by_engineer')->comment('When engineer approved the task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assigned_engineers', function (Blueprint $table) {
            $table->dropColumn(['is_approved_by_engineer', 'engineer_approved_at']);
        });
    }
};

