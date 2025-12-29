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
        Schema::create('staff_pan_card_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('pan_number', 10)->unique();
            $table->string('pan_card_front_path')->nullable();
            $table->string('pan_card_back_path')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('staff_id');
            $table->index('pan_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_pan_card_details');
    }
};
