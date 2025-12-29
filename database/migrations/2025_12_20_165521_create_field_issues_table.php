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
        if (! Schema::hasTable('field_issues')) {
            Schema::create('field_issues', function (Blueprint $table) {
                $table->id();
                $table->string('issue_id')->unique();
                $table->foreignId('field_executive_id')->constrained('staff')->onDelete('cascade');
                $table->string('issue_type');
                $table->text('issue_description');
                $table->enum('priority', [0, 1, 2, 3])->default(1)->comment('0 - Low, 1 - Medium, 2 - High, 3 - Critical'); // low, medium, high, critical
                $table->enum('status', [0, 1, 2, 3])->default(0)->comment('0 - Pending, 1 - In Progress, 2 - Resolved, 3 - Closed'); // pending, in_progress, resolved, closed
                $table->foreignId('assigned_remote_engineer_id')->nullable()->constrained('staff')->onDelete('cascade');
                $table->timestamp('resolved_at')->nullable();
                $table->text('resolution_notes')->nullable();
                $table->json('attachments')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_issues');
    }
};
