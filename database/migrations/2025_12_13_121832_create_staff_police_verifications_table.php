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
        Schema::create('staff_police_verifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->enum('police_verification', [0, 1])->default('0')->comment('0 - No, 1 - Yes');
            $table->enum('police_verification_status', [0, 1])->default(0)->comment('0 - Pending, 1 - Completed');
            $table->string('police_certificate')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_police_verifications');
    }
};
