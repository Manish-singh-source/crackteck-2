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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->string('request_id')->unique();
            // $table->foreignId('item_code_id')->constrained('covered_items')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('request_date');
            $table->enum('request_status', ['pending', 'approved', 'rejected', 'processing', 'processed', 'picking', 'picked', 'completed'])->default('pending')->index();
            $table->enum('request_source', ['customer', 'system'])->default('customer');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('is_engineer_assigned', ['not_assigned', 'assigned'])->default('not_assigned');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
