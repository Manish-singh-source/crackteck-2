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

            $table->enum('vehicle_type', [0, 1, 2, 3])->nullable()->comment('0 - Two-wheeler, 1 - Three-wheeler, 2 - Four-wheeler, 3 - Other');
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
