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
            $table->text('diagnosis_notes')->nullable()->after('diagnosis_list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('remote_support_diagnoses', function (Blueprint $table) {
            //
            $table->dropColumn('diagnosis_notes');
        });
    }
};
