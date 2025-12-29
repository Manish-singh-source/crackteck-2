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
        Schema::create('case_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('requesting_engineer_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('new_engineer_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->text('engineer_reason');
            $table->text('admin_reason')->nullable();
            $table->enum('status', [0, 1, 2])->default(0)->comment('0 - Pending, 1 - Approved, 2 - Rejected');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_request_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_transfer_requests');
    }
};
