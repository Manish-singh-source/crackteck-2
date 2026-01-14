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
        Schema::create('scrap_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('cascade');
            $table->string('quantity_scrapped');
            $table->string('reason_for_scrap');
            $table->text('scrap_notes')->nullable();
            $table->text('photos')->nullable();
            $table->foreignId('scrapped_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamp('scrapped_at');

            $table->softDeletes();
            $table->timestamps();

            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrap_items');
    }
};
