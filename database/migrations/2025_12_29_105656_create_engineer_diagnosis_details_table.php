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
        Schema::create('engineer_diagnosis_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('service_request_product_id')->constrained('service_request_products')->cascadeOnDelete();
            $table->foreignId('assigned_engineer_id')->constrained('assigned_engineers')->cascadeOnDelete();

            $table->foreignId('covered_item_id')->constrained('covered_items')->cascadeOnDelete(); 

            $table->json('diagnosis_list')->nullable();

            $table->json('diagnosis_photos')->nullable();

            $table->json('diagnosis_videos')->nullable();

            $table->json('diagnosis_notes')->nullable();

            $table->string('diagnosis_report')->nullable();

            $table->json('after_photos')->nullable();
            $table->json('before_photos')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engineer_diagnosis_details');
    }
};
