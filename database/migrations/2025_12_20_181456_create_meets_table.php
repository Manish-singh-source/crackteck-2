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
        Schema::create('meets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->string('meet_title');
            $table->enum('meeting_type', [0, 1, 2])->default(0)->comment('0 - In Person, 1 - Virtual, 2 - Phone');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable(); // For virtual meetings
            $table->json('attendees')->nullable();
            $table->string('attachment')->nullable();
            $table->text('meet_agenda')->nullable();
            $table->text('meeting_notes')->nullable();
            $table->text('follow_up_action')->nullable();
            $table->enum('status', [0, 1, 2, 3, 4])->default(0)->comment('0 - Scheduled, 1 - Confirmed, 2 - Completed, 3 - Cancelled', '4 - Rescheduled');

            $table->softDeletes();
            $table->timestamps();

            $table->index(['lead_id', 'status']);
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meets');
    }
};
