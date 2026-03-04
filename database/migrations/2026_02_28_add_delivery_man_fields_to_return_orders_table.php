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
        Schema::table('return_orders', function (Blueprint $table) {
            // Add delivery man id field
            $table->foreignId('delivery_man_id')->nullable()->constrained('staff')->onDelete('set null');

            // Add return status timeline fields
            $table->timestamp('return_picked_at')->nullable()->after('return_accepted_at');
            $table->timestamp('return_delivered_at')->nullable()->after('return_picked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_orders', function (Blueprint $table) {
            $table->dropForeign(['delivery_man_id']);
            $table->dropColumn(['delivery_man_id', 'return_picked_at', 'return_delivered_at']);
        });
    }
};
