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
        Schema::create('staff_vehicle_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->enum('vehicle_type', ['two_wheeler', 'three_wheeler', 'four_wheeler', 'other'])->default('other');
            $table->string('vehicle_number')->nullable()->unique();
            $table->string('driving_license_no')->nullable()->unique();
            $table->string('driving_license_front_path')->nullable();
            $table->string('driving_license_back_path')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('staff_id');
            $table->index('vehicle_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_vehicle_details');
    }
};
