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

            $table->enum('staff_role', [0, 1, 2, 3, 4])->default(0)->comment('0 - Admin, 1 - Engineer, 2 - Delivery Man, 3 - Sales Person, 4 - Customer');
            // Personal Information
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 10)->unique();
            $table->string('email')->unique();
            $table->date('dob')->nullable(); // Use proper date type
            $table->enum('gender', [0, 1, 2])->nullable()->comment('0 - Male, 1 - Female, 2 - Other');
            $table->enum('marital_status', [0, 1, 2])->default(0)->comment('0 - Unmarried, 1 - Married, 2 - Divorced');

            // Employment Details
            $table->enum('employment_type', [0, 1])->default(0)->comment('0 - Full-time, 1 - Part-time');
            $table->date('joining_date')->nullable();
            $table->string('assigned_area', 100)->nullable();

            // Authentication / Verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();

            // Status
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6])->default(1)->comment('0 - InActive, 1 - Active, 2 - Resigned, 3 - Terminated, 4 - Blocked, 5 - Suspended', '6 - Pending');

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
