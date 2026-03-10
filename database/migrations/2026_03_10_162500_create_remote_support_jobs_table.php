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
        Schema::create('remote_support_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('amc_schedule_meeting_id')->nullable();
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamp('assigned_at')->nullable();
            $table->integer('escalate_to')->nullable();
            $table->timestamp('escalate_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('client_feedback')->nullable();
            $table->string('time_spent')->nullable();
            $table->enum('status', ['pending', 'assigned_remote_support', 'in_progress', 'resolved', 'unresolved'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_support_jobs');
    }
};
