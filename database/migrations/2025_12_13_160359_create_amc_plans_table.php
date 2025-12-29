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
        Schema::create('amc_plans', function (Blueprint $table) {
            $table->id();

            $table->string('plan_name');
            $table->string('plan_code')->unique();

            $table->string('description')->nullable();
            $table->integer('duration')->comment('Duration in months');
            $table->integer('total_visits')->nullable();

            $table->decimal('plan_cost', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2);
            $table->enum('pay_terms', [0, 1])->default(0)->comment('0 - Full Payment, 1 - Installments');

            $table->enum('support_type', [0, 1, 2])->default(0)->comment('0 - Onsite, 1 - Remote, 2 - Both');
            $table->json('covered_items')->nullable();

            $table->string('brochure')->nullable();
            $table->string('tandc')->nullable();
            $table->string('replacement_policy')->nullable();

            $table->enum('status', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc_plans');
    }
};
