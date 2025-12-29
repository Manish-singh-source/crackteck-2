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
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->default(0)->comment('0 - Pending, 1 - Approved, 2 - Rejected, 3 - Processing, 4 - In Progress, 5 - On Hold, 6 - Diagnosis Completed, 7 - Processed, 8 - Picking, 9 - Picked, 10 - Completed');

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
