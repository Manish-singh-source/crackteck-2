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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_category_id')
                ->constrained('parent_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('slug')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('icon_image')->nullable();
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
        Schema::dropIfExists('sub_categories');
    }
};
