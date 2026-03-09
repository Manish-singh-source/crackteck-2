<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->text('avatar')->nullable()->change();
            $table->string('phone', 10)->nullable()->change();
            $table->string('password')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('avatar')->nullable()->change();
            $table->string('phone', 10)->unique()->change();
            $table->string('password')->default(Hash::make('123456789'))->nullable()->change();
        });
    }
};
