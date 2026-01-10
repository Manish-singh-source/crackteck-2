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
        if (! Schema::hasTable('stock_in_hand_products')) {
            Schema::create('stock_in_hand_products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('stock_in_hand_id')->constrained('stock_in_hands')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->foreignId('product_serial_id')->nullable()->constrained('product_serials')->onDelete('cascade');
                $table->integer('requested_quantity');
                $table->integer('delivered_quantity')->default(0);
                $table->decimal('unit_price', 15, 2);
                $table->enum('status', ['pending', 'approved', 'rejected', 'picked', 'used', 'returned', 'cancelled'])->default('pending')->comment('0 - Pending, 1 - Approved, 2 - Rejected, 3 - Picked, 4 - Used, 5 - Returned, 6 - Cancelled'); // pending, approved, rejected, picked, used, returned, cancelled
                $table->text('notes')->nullable();
                $table->timestamp('picked_at')->nullable();
                $table->timestamp('returned_at')->nullable();

                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_hand_products');
    }
};
