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
        Schema::create('amc_schedule_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            // $table->foreignId('engineer_id')->references('id')->on('engineers')->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->dateTime('completed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->text('report')->nullable();
            $table->integer('visits_count')->default(1);
            $table->enum('status', ['scheduled', 'completed', 'missed'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc_schedule_meetings');
    }
};
