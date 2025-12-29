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
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_request_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('engineer_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->foreignId('pickup_person_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('pickup_assigned_at')->nullable();
            $table->timestamp('pickup_completed_at')->nullable();

            $table->foreignId('delivery_person_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('delivery_assigned_at')->nullable();
            $table->timestamp('delivery_completed_at')->nullable();

            $table->enum('status', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9])->default(0)->comment('0 - Pending, 1 - Assigned, 2 - Picked , 3 - Received, 4 - In Process, 5 - Processed, 6 - In Transit, 7 - Delivered, 8 - Completed, 9 - Cancelled');
            $table->text('cancellation_reason')->nullable();

            $table->json('before_photos')->nullable();
            $table->json('after_photos')->nullable();

            $table->string('otp')->nullable();
            $table->timestamp('otp_verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_request_id', 'status']);
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_requests');
    }
};
