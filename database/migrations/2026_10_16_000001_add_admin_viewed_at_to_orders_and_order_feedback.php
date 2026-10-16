<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['orders', 'order_feedback'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->timestamp('admin_viewed_at')->nullable()->index();
            });

            // Start notifications with new records, rather than historical data.
            DB::table($name)->update(['admin_viewed_at' => now()]);
        }
    }

    public function down(): void
    {
        foreach (['orders', 'order_feedback'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropIndex(['admin_viewed_at']);
                $table->dropColumn('admin_viewed_at');
            });
        }
    }
};
