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
        Schema::table('amcs', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])
                ->default('pending')
                ->after('status');
            $table->unsignedBigInteger('payment_amount')->default(0)->after('payment_status');
            $table->string('payment_currency', 10)->default('INR')->after('payment_amount');
            $table->timestamp('paid_at')->nullable()->after('payment_currency');

            $table->index(['amc_type', 'payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amcs', function (Blueprint $table) {
            $table->dropIndex(['amc_type', 'payment_status']);
            $table->dropColumn([
                'payment_status',
                'payment_amount',
                'payment_currency',
                'paid_at',
            ]);
        });
    }
};
