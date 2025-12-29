<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * STEP 1: Rename columns (EXCEPT country)
         */
        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->renameColumn('address1', 'comp_address1');
            $table->renameColumn('address2', 'comp_address2');
            $table->renameColumn('city', 'comp_city');
            $table->renameColumn('state', 'comp_state');
            $table->renameColumn('pincode', 'comp_pincode');
        });

        /**
         * STEP 2: Rename country using RAW SQL (MariaDB safe)
         */
        DB::statement("
            ALTER TABLE customer_company_details
            CHANGE country comp_country VARCHAR(255)
        ");

        /**
         * STEP 3: Make columns nullable
         */
        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->string('company_name')->nullable()->change();
            $table->string('comp_address1')->nullable()->change();
            $table->string('comp_address2')->nullable()->change();
            $table->string('comp_city')->nullable()->change();
            $table->string('comp_state')->nullable()->change();
            $table->string('comp_country')->nullable()->change();
            $table->string('comp_pincode')->nullable()->change();
        });
    }

    public function down(): void
    {
        /**
         * STEP 1: Revert nullable
         */
        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->string('company_name')->nullable(false)->change();
            $table->string('comp_address1')->nullable(false)->change();
            $table->string('comp_address2')->nullable()->change();
            $table->string('comp_city')->nullable(false)->change();
            $table->string('comp_state')->nullable(false)->change();
            $table->string('comp_country')->nullable(false)->change();
            $table->string('comp_pincode')->nullable(false)->change();
        });

        /**
         * STEP 2: Rename back country using RAW SQL
         */
        DB::statement("
            ALTER TABLE customer_company_details
            CHANGE comp_country country VARCHAR(255)
        ");

        /**
         * STEP 3: Rename other columns back
         */
        Schema::table('customer_company_details', function (Blueprint $table) {
            $table->renameColumn('comp_address1', 'address1');
            $table->renameColumn('comp_address2', 'address2');
            $table->renameColumn('comp_city', 'city');
            $table->renameColumn('comp_state', 'state');
            $table->renameColumn('comp_pincode', 'pincode');
        });
    }
};
