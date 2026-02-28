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
        Schema::create('return_orders', function (Blueprint $table) {
            $table->id();
            $table->string('return_order_number')->unique();
            $table->string('order_number');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            
            // Return person (who initiated the return)
            $table->foreignId('return_person_id')->nullable()->constrained('customers')->onDelete('set null');
            
            // Status tracking
            $table->enum('status', ['pending', 'assigned', 'accepted', 'picked', 'received'])->default('pending');
            
            // Date tracking
            $table->timestamp('return_assigned_at')->nullable();
            $table->timestamp('return_accepted_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->timestamp('return_completed_at')->nullable();
            
            // OTP for return verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();
            
            // Return reason
            $table->text('return_reason')->nullable();
            
            // Refund info
            $table->decimal('refund_amount', 15, 2)->nullable();
            $table->enum('refund_status', ['pending', 'processed', 'cancelled'])->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            $table->index(['order_number', 'status']);
            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};
