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
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->enum('customer_type', ['ecommerce', 'amc', 'non_amc', 'both', 'offline'])->default('ecommerce');
            $table->enum('source_type', ['ecommerce', 'app', 'call', 'walk_in', 'other', 'admin_panel'])->default('ecommerce')->nullable();
            $table->string('password')->nullable();
            $table->enum('status', ['inactive', 'active', 'blocked', 'suspended'])->default('active');

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
