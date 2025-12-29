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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();

            $table->string('warehouse_code')->unique();

            $table->string('name');
            $table->string('type');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('India');
            $table->string('pincode');

            $table->string('contact_person_name');
            $table->string('phone_number', 10);
            $table->string('alternate_phone_number', 10)->nullable();
            $table->string('email')->unique();

            $table->string('working_hours')->nullable();
            $table->string('working_days')->nullable();
            $table->integer('max_store_capacity')->nullable();
            $table->string('supported_operations')->nullable();
            $table->string('zone_conf')->nullable();

            $table->string('gst_no', 15)->nullable()->unique();
            $table->string('licence_no', 50)->nullable()->unique();
            $table->string('licence_doc')->nullable();

            $table->enum('verification_status', [0, 1, 2])->default(0)->comment('0 - Pending, 1 - Verified, 2 - Rejected');
            $table->enum('default_warehouse', [0, 1])->default(0)->comment('0 - No, 1 - Yes');
            $table->enum('status', [0, 1])->default(1)->comment('0 - Inactive, 1 - Active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
