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
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('dob')->nullable();
            $table->enum('document_type', ['aadhar', 'pan', 'driving_license', 'police_verification_certificate'])->nullable();
            $table->string('document_file')->nullable();
            $table->string('document_no')->nullable();
            $table->enum('status', ['pending', 'submitted', 'under_review', 'approved', 'rejected', 'resubmit_required'])->default('pending');
            $table->text('reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            
            // Add indexes for better query performance
            $table->index('status');
            $table->index('phone');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kycs');
    }
};
