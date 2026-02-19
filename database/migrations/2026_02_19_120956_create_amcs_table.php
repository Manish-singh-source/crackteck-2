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
        Schema::create('amcs', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->enum('service_type', ['amc', 'quick_service', 'installation', 'repair'])->default('amc');

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('customer_address_id')->nullable()->constrained('customer_address_details')->nullOnDelete();
            
            $table->foreignId('amc_plan_id')->nullable()->constrained('amc_plans')->onDelete('cascade');

            $table->date('request_date');
            $table->enum('request_source', ['customer', 'system', 'lead_won'])->default('customer');
            $table->enum('status', ['active', 'completed', 'expired', 'cancelled'])->default('active');

            $table->string('created_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amcs');
    }
};
