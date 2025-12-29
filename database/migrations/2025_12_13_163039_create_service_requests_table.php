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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();

            $table->string('request_id')->unique();
            // $table->foreignId('item_code_id')->constrained('covered_items')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('request_date');
            $table->enum('request_status', [0, 1, 2, 3, 4, 5, 6, 7])->default(0)->comment('0 - Pending, 1 - Approved, 2 - Rejected, 3 - Processing, 4 - Processed, 5 - Picking, 6 - Picked, 7 - Completed')->index();
            $table->enum('request_source', [0, 1])->default(0)->comment('0 - Customer, 1 - System');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('is_engineer_assigned', [0, 1])->default(0)->comment('0 - Not Assigned, 1 - Assigned');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
