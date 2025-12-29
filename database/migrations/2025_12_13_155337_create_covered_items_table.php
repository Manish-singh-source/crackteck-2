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
        Schema::create('covered_items', function (Blueprint $table) {
            $table->id();

            $table->string('item_code')->unique();

            $table->enum('service_type', [0, 1, 2, 3])->default(0)->comment('0 - AMC, 1 - Quick Service, 2 - Installation, 3 - Repair');
            $table->string('service_name');
            $table->decimal('service_charge', 10, 2)->nullable();

            $table->enum('status', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');

            $table->json('diagnosis_list')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('service_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('covered_items');
    }
};
