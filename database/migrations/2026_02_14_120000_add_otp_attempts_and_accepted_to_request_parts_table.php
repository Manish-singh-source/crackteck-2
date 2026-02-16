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
        Schema::table('service_request_product_request_parts', function (Blueprint $table) {
            $table->integer('otp_attempts')->default(0)->after('otp_expiry');
            $table->timestamp('accepted_at')->nullable()->after('otp_attempts');
            $table->unsignedBigInteger('accepted_by')->nullable()->after('accepted_at');
            $table->foreign('accepted_by')->references('id')->on('staff')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_request_product_request_parts', function (Blueprint $table) {
            $table->dropForeign(['accepted_by']);
            $table->dropColumn(['otp_attempts', 'accepted_at', 'accepted_by']);
        });
    }
};
