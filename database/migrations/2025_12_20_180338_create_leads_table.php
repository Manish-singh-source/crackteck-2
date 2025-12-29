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
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->string('lead_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', [0, 1, 2])->nullable()->comment('0 - Male, 1 - Female, 2 - Other');
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('industry_type')->nullable();
            $table->enum('source', [0, 1, 2, 3, 4])->default(2)->comment('0 - Website, 1 - Referral, 2 - Call, 3 - Walk-in, 4 - Event');
            $table->string('requirement_type')->nullable();
            $table->string('budget_range')->nullable();
            $table->enum('urgency', [0, 1, 2, 3])->default(1)->comment('0 - Low, 1 - Medium, 2 - High, 3 - Critical');
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6])->default(0)->comment('0 - New, 1 - Contacted, 2 - Qualified, 3 - Proposal, 4 - Won, 5 - Lost, 6 - Nurture');

            $table->decimal('estimated_value', 15, 2)->nullable();
            $table->text('notes')->nullable();

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
