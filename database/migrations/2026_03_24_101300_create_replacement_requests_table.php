<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('replacement_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('original_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('replacement_product_id')->constrained('ecommerce_products')->cascadeOnDelete();
            $table->string('reason');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'assigned', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->string('assigned_person_type')->nullable();
            $table->foreignId('assigned_person_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
            // $table->index(['assigned_person_type', 'assigned_person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('replacement_requests');
    }
};
