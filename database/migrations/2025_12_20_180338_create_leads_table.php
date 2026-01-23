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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade'); // Sales Person
            $table->foreignId('customer_address_id')->constrained('customer_address_details')->nullable()->onDelete('cascade');
            $table->string('lead_number')->unique();

            $table->string('requirement_type')->nullable();
            $table->string('budget_range')->nullable();

            $table->enum('urgency', ['low', 'medium', 'high', 'critical'])->default('medium')->comment('0 - Low, 1 - Medium, 2 - High, 3 - Critical');
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost', 'nurture'])->default('new')->comment('0 - New, 1 - Contacted, 2 - Qualified, 3 - Proposal, 4 - Won, 5 - Lost, 6 - Nurture');

            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
