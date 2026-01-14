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
        if (! Schema::hasTable('remote_jobs')) {
            Schema::create('remote_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('job_id')->unique();
                $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
                $table->foreignId('field_executive_id')->nullable()->constrained('staff')->onDelete('cascade'); // Created by
                $table->foreignId('assigned_engineer_id')->nullable()->constrained('staff')->onDelete('cascade');
                $table->enum('job_type', ['remote_diagnosis', 'troubleshooting', 'guidance'])->default('remote_diagnosis')->comment('0 - Remote Diagnosis, 1 - Troubleshooting, 2 - Guidance'); // remote_diagnosis, troubleshooting, guidance
                $table->text('job_description');
                $table->text('remote_access_details')->nullable();
                $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'escalated'])->default('pending')->comment('0 - Pending, 1 - Assigned, 2 - In Progress, 3 - Completed, 4 - Escalated');
                $table->timestamp('started_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->text('resolution_notes')->nullable();
                $table->string('escalation_reason')->nullable();

                $table->softDeletes();
                $table->timestamps();

                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_jobs');
    }
};
