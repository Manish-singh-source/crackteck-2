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
        Schema::create('assigned_engineer_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assigned_engineers')->cascadeOnDelete();
            $table->foreignId('engineer_id')->constrained('staff')->cascadeOnDelete();
            $table->boolean('is_supervisor')->default(false);
            $table->timestamps();

            $table->index(['assignment_id', 'engineer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_engineer_group');
    }
};

