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
        Schema::create('service_request_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_requests_id')
                ->constrained('service_requests')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('model_no')->nullable();
            $table->string('sku')->nullable();
            $table->string('hsn')->nullable();
            $table->string('brand')->nullable();
            $table->json('images')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing', 'in_progress', 'on_hold', 'diagnosis_completed', 'processed', 'picking', 'picked', 'completed'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_products');
    }
};
