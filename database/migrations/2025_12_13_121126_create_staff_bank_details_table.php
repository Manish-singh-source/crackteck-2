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
        Schema::create('staff_bank_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_id')
                ->constrained('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('bank_acc_holder_name');
            $table->string('bank_acc_number')->unique();
            $table->string('bank_name');
            $table->string('ifsc_code');
            $table->string('passbook_pic')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index('staff_id');
            $table->index('bank_acc_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_bank_details');
    }
};
