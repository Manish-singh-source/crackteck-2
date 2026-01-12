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

            $table->enum('service_type', ['amc', 'quick_service', 'installation', 'repair'])->default('quick_service');
            $table->string('service_name');
            $table->decimal('service_charge', 10, 2)->nullable();

            $table->enum('status', ['inactive', 'active'])->default('active');

            $table->text('diagnosis_list')->nullable();

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
