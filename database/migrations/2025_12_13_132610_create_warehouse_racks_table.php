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
        Schema::create('warehouse_racks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('rack_name');
            $table->string('zone_area');
            $table->string('rack_no');
            $table->string('level_no')->nullable();
            $table->string('position_no')->nullable();
            $table->string('floor')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('filled_quantity')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_racks');
    }
};
