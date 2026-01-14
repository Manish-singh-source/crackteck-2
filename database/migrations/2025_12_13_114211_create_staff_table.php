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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            $table->string('staff_code')->unique();

            $table->enum('staff_role', ['admin', 'engineer', 'delivery_man', 'sales_person', 'customer'])->default('customer');
            // Personal Information
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 10)->unique();
            $table->string('email')->unique();
            $table->date('dob')->nullable(); // Use proper date type
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->enum('marital_status', ['unmarried', 'married', 'divorced'])->default('unmarried');

            // Employment Details
            $table->enum('employment_type', ['full_time', 'part_time', 'contractual'])->default('full_time');
            $table->date('joining_date')->nullable();
            $table->string('assigned_area', 100)->nullable();

            // Authentication / Verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();

            // Status
            $table->enum('status', ['inactive', 'active', 'resigned', 'terminated', 'blocked', 'suspended', 'pending'])->default('active');

            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['email', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
