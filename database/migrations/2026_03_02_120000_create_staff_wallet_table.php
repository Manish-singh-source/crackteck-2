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
        Schema::create('staff_wallet', function (Blueprint $table) {
            $table->id();
            
            // Staff type (engineer, delivery_man, etc.) - based on role_id
            $table->string('staff_type');
            
            // Staff ID reference (links to staff table)
            $table->unsignedBigInteger('staff_id');
            
            // Amount for the expense
            $table->decimal('amount', 10, 2)->default(0);
            
            // Reason for the expense
            $table->text('reason')->nullable();
            
            // Receipt file path
            $table->string('receipt')->nullable();
            
            // Status: pending, admin_approved, admin_rejected, payed
            $table->enum('status', ['pending', 'admin_approved', 'admin_rejected', 'paid'])->default('pending');
            
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['staff_type', 'staff_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_wallet');
    }
};
