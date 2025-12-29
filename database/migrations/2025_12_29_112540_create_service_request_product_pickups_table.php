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
        Schema::create('service_request_product_pickups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('service_requests')->cascadeOnDelete();
    $table->foreignId('product_id')->constrained('service_request_products')->cascadeOnDelete();
    $table->foreignId('engineer_id')->constrained('assigned_engineers')->cascadeOnDelete();
            $table->text('reason')->nullable();

            $table->enum('assigned_person_type', [0, 1])->comment('0 - Delivery Man, 1 - Engineer')->nullable();
            $table->foreignId('assigned_person_id')->nullable()->constrained('staff')->cascadeOnDelete();
            
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6, 7])->default(0)->comment('0 - Pending, 1 - Assigned, 2 - Approved, 3 - Picked, 4 - Received, 5 - Cancelled, 6 - Returned, 7 - Completed');

            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('picked_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('returned_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_product_pickups');
    }
};
