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
        Schema::create('service_request_product_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('service_request_products')->cascadeOnDelete();
            $table->foreignId('pickups_id')->constrained('service_request_product_pickups')->cascadeOnDelete();

            $table->enum('assigned_person_type', ['delivery_man', 'engineer'])->comment('0 - Delivery Man, 1 - Engineer')->nullable();
            $table->foreignId('assigned_person_id')->nullable()->constrained('staff')->cascadeOnDelete();

            $table->enum('status', ['pending', 'assigned', 'accepted', 'picked', 'delivered', 'cancelled'])->default('pending');

            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();

            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('picked_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_product_returns');
    }
};
