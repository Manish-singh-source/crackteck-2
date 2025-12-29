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
        Schema::create('parent_categories', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status_ecommerce', [0, 1])->default(1)->comment('0 - No, 1 - Yes');
            $table->enum('status', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');

            $table->softDeletes();
            $table->timestamps();

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_categories');
    }
};
