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
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->string('reason_for_escalation')->nullable();
            $table->text('escalation_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->dropColumn('reason_for_escalation');
            $table->dropColumn('escalation_notes');
        });
    }
};
