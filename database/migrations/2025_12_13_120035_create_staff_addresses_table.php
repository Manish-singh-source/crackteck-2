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
        Schema::create('staff_addresses', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade'); // Ensures updates propagate

            // Address Fields
            $table->string('address1', 150);
            $table->string('address2', 150)->nullable();
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100)->default('India'); // Optional default
            $table->string('pincode'); // Allow alphanumeric pincodes (e.g., international)

            // Metadata
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('staff_id');
            $table->index(['city', 'state']); // Useful for filtering/search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_addresses');
    }
};
