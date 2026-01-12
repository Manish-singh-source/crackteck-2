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
        Schema::create('staff_work_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->text('primary_skills')->nullable();
            $table->text('certifications')->nullable();
            $table->string('experience')->nullable();
            $table->text('languages_known')->nullable();
            // $table->text('employment_history')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('staff_id');
            $table->index('primary_skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_work_skills');
    }
};
