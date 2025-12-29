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
            $table->enum('delivery', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');
            $table->enum('installation', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');
            $table->enum('repair', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');
            $table->enum('quick_service', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');
            $table->enum('amc', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');

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
