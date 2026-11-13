<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->string('withdrawal_no')->unique();
            $table->unsignedBigInteger('staff_id')->index();
            $table->string('requester_role')->index();
            $table->decimal('amount', 12, 2);
            $table->string('reason', 500);
            $table->enum('payout_method', ['cash', 'upi', 'bank_transfer']);
            $table->string('payout_details', 500)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending')->index();
            $table->text('rejection_reason')->nullable();
            $table->string('payment_reference', 255)->nullable();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
