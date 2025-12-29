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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('ticket_id')->unique();
            $table->string('title');
            $table->longText('description');
            $table->enum('category', [0, 1, 2, 3, 4])->default(0)->comment('0 - Product, 1 - Service, 2 - Billing, 3 - Technical, 4 - Other');
            $table->string('subcategory')->nullable();
            $table->enum('priority', [0, 1, 2, 3])->default(0)->comment('0 - Low, 1 - Medium, 2 - High, 3 - Critical');
            $table->enum('status', [0, 1, 2, 3, 4, 5])->default(0)->comment('0 - Open, 1 - In Progress, 2 - Pending, 3 - Resolved, 4 - Closed, 5 - Reopened');
            $table->foreignId('assigned_to')->nullable()->constrained('staff')->onDelete('cascade');
            $table->integer('response_time_minutes')->nullable(); // SLA
            $table->integer('resolution_time_minutes')->nullable(); // SLA
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
