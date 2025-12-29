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
        Schema::create('service_request_quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('request_part_id')->constrained('service_request_product_request_parts')->cascadeOnDelete();
            $table->foreignId('part_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('product_price', 15, 2);
            $table->decimal('service_charge', 15, 2);
            $table->decimal('delivery_charge', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->string('quotation_file')->nullable();
            $table->enum('quotation_status', [0, 1, 2])->default(0)->comment('0 - Pending, 1 - Approved, 2 - Rejected');
            $table->date('quotation_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_request_quotations');
    }
};
