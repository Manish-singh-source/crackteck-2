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
        Schema::create('remote_support_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remote_support_job_id')
                ->constrained('remote_support_jobs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('client_connected_via')->nullable();
            $table->text('client_confirmation')->nullable();
            $table->string('remote_tool')->nullable();
            $table->string('diagnosis_list')->nullable();
            $table->text('fix_description')->nullable();
            $table->string('before_screenshots')->nullable();
            $table->string('after_screenshots')->nullable();
            $table->string('logs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remote_support_diagnoses');
    }
};
