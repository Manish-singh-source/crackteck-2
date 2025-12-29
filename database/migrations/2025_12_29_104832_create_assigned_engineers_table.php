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
        Schema::create('assigned_engineers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('service_requests')->cascadeOnDelete();
            $table->foreignId('engineer_id')->constrained('staff')->cascadeOnDelete();

            $table->enum('assignment_type', [0, 1])->default(0)->comment('0 - Individual, 1 - Group');
            $table->timestamp('assigned_at')->nullable();

            $table->foreignId('transferred_to')->nullable()->constrained('staff')->cascadeOnDelete();
            $table->timestamp('transferred_at')->nullable();
            $table->text('notes')->nullable();

            $table->string('group_name')->nullable();
            $table->boolean('is_supervisor')->default(false);
            
            $table->enum('status', [0, 1])->default(0)->comment('0 - Active, 1 - Inactive');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['service_request_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_engineers');
    }
};
