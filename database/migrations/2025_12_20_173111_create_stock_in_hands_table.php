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
        Schema::create('stock_in_hands', function (Blueprint $table) {
            $table->id();
            $table->string('stock_in_hand_id')->unique();
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->foreignId('engineer_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->timestamp('requested_at');
            $table->foreignId('assigned_delivery_man_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6])->default(0)->comment('0 - Pending, 1 - Approved, 2 - Rejected, 3 - Picked, 4 - Used, 5 - Returned, 6 - Cancelled'); // pending, approved, rejected, picked, used, returned, cancelled
            $table->text('request_notes')->nullable();
            $table->json('delivery_photos')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->integer('requested_quantity');
            $table->integer('delivered_quantity')->default(0);

            $table->date('requested_date');
            $table->timestamp('approved_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['engineer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_hands');
    }
};
