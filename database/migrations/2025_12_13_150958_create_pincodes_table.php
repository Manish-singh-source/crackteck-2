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
        Schema::create('pincodes', function (Blueprint $table) {
            $table->id();

            $table->string('pincode')->unique();
            $table->enum('delivery', ['inactive', 'active'])->default('active');
            $table->enum('installation', ['inactive', 'active'])->default('active');
            $table->enum('repair', ['inactive', 'active'])->default('active');
            $table->enum('quick_service', ['inactive', 'active'])->default('active');
            $table->enum('amc', ['inactive', 'active'])->default('active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pincodes');
    }
};
