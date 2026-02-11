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
        Schema::create('quotation_amc_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('amc_plan_id');
            $table->integer('plan_duration');
            $table->date('plan_start_date');
            $table->date('plan_end_date'); // auto generated based on start date and duration
            $table->decimal('total_amount', 10, 2);
            $table->string('priority_level');
            $table->text('additional_notes')->nullable();
            $table->timestamps();

            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->foreign('amc_plan_id')->references('id')->on('amc_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_amc_details');
    }
};
