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
        Schema::table('staff_work_skills', function (Blueprint $table) {
            $table->string('qualification')->nullable()->after('languages_known');
            $table->string('qualification_certifications')->nullable()->after('qualification');
            $table->string('address_proof')->nullable()->after('qualification_certifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_work_skills', function (Blueprint $table) {
            $table->dropColumn(['qualification', 'qualification_certifications', 'address_proof']);
        });
    }
};
