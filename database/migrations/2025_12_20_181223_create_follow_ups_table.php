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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->date('followup_date');
            $table->time('followup_time')->nullable();
            $table->enum('followup_type', ['call', 'email', 'meeting', 'sms'])->default('call')->comment('0 - Call, 1 - Email, 2 - Meeting, 3 - SMS');
            $table->enum('status', ['pending', 'completed', 'rescheduled', 'cancelled'])->default('pending')->comment('0 - Pending, 1 - Completed, 2 - Rescheduled, 3 - Cancelled');
            $table->text('remarks')->nullable();
            $table->text('next_action')->nullable();
            $table->timestamp('next_followup_date')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['lead_id', 'status']);
            $table->index('followup_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
