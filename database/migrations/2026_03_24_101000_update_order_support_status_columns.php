<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN return_status ENUM('pending', 'approved', 'rejected', 'picked', 'received', 'refunded') NULL");
        DB::statement("ALTER TABLE orders MODIFY COLUMN refund_status ENUM('pending', 'processing', 'completed', 'failed', 'not_required') NULL");

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('replacement_status', ['pending', 'approved', 'rejected', 'assigned', 'completed'])
                ->nullable()
                ->after('return_status');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['replacement_status', 'cancellation_reason']);
        });

        DB::statement("ALTER TABLE orders MODIFY COLUMN return_status ENUM('pending', 'approved', 'rejected') NULL");
        DB::statement("ALTER TABLE orders MODIFY COLUMN refund_status ENUM('pending', 'processed', 'cancelled') NULL");
    }
};
