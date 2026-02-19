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
        Schema::create('amc_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('amc_id')
                ->constrained('amcs')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('type')->nullable();
            $table->string('model_no')->nullable();
            $table->string('sku')->nullable();
            $table->string('hsn')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('brand')->nullable();
            $table->text('images')->nullable();
            $table->string('description')->nullable();  

            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc_products');
    }
};
