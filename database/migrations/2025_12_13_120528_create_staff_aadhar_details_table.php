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
        Schema::create('staff_aadhar_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('aadhar_number', 12)->unique();

            $table->string('aadhar_front_path')->nullable();
            $table->string('aadhar_back_path')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->index('staff_id');
            $table->index('aadhar_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_aadhar_details');
    }
};
