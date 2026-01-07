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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('customer_code')->unique();

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 10)->unique();
            $table->string('email')->unique();
            $table->date('dob')->nullable(); // Use proper date type
            $table->enum('gender', [0, 1, 2])->nullable()->comment('0 - Male, 1 - Female, 2 - Other');

            $table->enum('customer_type', [0, 1, 2, 3, 4])->default(0)->comment('0 - E-commerce, 1 - AMC, 2 - Non-AMC, 3 - Both, 4 - Offline');
            $table->enum('source_type', [0, 1, 2, 3, 4, 5])->default(0)->comment('0 - E-commerce, 1 - App, 2 - Call, 3 - Walk-in, 4 - Other, 5 - Admin Panel')->nullable();
            $table->string('password')->nullable();
            $table->enum('status', [0, 1, 2, 3])->default(1)->comment('0 - InActive, 1 - Active, 2 - Blocked, 3 - Suspended');

            // Authentication / Verification
            $table->string('otp')->nullable();
            $table->timestamp('otp_expiry')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('created_by');
            $table->index('phone');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
