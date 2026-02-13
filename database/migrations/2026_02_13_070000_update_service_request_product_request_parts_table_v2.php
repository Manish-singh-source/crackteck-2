<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Make request_id and product_id nullable using raw SQL
        DB::statement("ALTER TABLE service_request_product_request_parts MODIFY COLUMN request_id BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE service_request_product_request_parts MODIFY COLUMN product_id BIGINT UNSIGNED NULL");

        // Step 2: Update assigned_person_type default to 'engineer' and remove nullable
        DB::statement("ALTER TABLE service_request_product_request_parts MODIFY COLUMN assigned_person_type ENUM('delivery_man', 'engineer') NOT NULL DEFAULT 'engineer'");

        // Step 3: Update status enum with new values
        DB::statement("ALTER TABLE service_request_product_request_parts MODIFY COLUMN status ENUM('pending', 'admin_approved', 'admin_rejected', 'customer_approved', 'customer_rejected', 'warehouse_approved', 'warehouse_rejected', 'assigned', 'ap_approved', 'ap_rejected', 'picked', 'in_transit', 'delivered', 'used') DEFAULT 'pending'");

        // Step 4: Rename approved_at and rejected_at columns if they exist
        Schema::table('service_request_product_request_parts', function (Blueprint $table) {
            if (Schema::hasColumn('service_request_product_request_parts', 'approved_at')) {
                $table->renameColumn('approved_at', 'admin_approved_at');
            }
            if (Schema::hasColumn('service_request_product_request_parts', 'rejected_at')) {
                $table->renameColumn('rejected_at', 'admin_rejected_at');
            }
        });

        // Step 5: Add missing timestamp columns using ALTER TABLE
        $columnsToAdd = [
            ['name' => 'assigned_approved_at', 'after' => 'assigned_at'],
            ['name' => 'assigned_rejected_at', 'after' => 'assigned_approved_at'],
            ['name' => 'warehouse_approved_at', 'after' => 'assigned_rejected_at'],
            ['name' => 'warehouse_rejected_at', 'after' => 'warehouse_approved_at'],
        ];

        foreach ($columnsToAdd as $column) {
            if (!Schema::hasColumn('service_request_product_request_parts', $column['name'])) {
                $afterColumn = $column['after'];
                DB::statement("ALTER TABLE service_request_product_request_parts ADD COLUMN {$column['name']} TIMESTAMP NULL AFTER {$afterColumn}");
            }
        }

        // Step 6: Reorganize columns - Drop and recreate table with correct column order
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $tableName = 'service_request_product_request_parts';
        $tempTable = 'temp_' . $tableName;
        
        if (Schema::hasTable($tableName)) {
            // Create temporary table with correct column order
            Schema::create($tempTable, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('request_id')->nullable();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->unsignedBigInteger('engineer_id')->nullable();
                $table->unsignedBigInteger('part_id')->nullable();
                $table->integer('requested_quantity')->nullable();
                $table->text('reason')->nullable();
                $table->string('request_type')->nullable();
                $table->enum('assigned_person_type', ['delivery_man', 'engineer'])->default('engineer');
                $table->unsignedBigInteger('assigned_person_id')->nullable();
                $table->enum('status', ['pending', 'admin_approved', 'admin_rejected', 'customer_approved', 'customer_rejected', 'warehouse_approved', 'warehouse_rejected', 'assigned', 'ap_approved', 'ap_rejected', 'picked', 'in_transit', 'delivered', 'used'])->default('pending');
                $table->string('otp', 10)->nullable();
                $table->timestamp('otp_expiry')->nullable();
                $table->timestamp('admin_approved_at')->nullable();
                $table->timestamp('admin_rejected_at')->nullable();
                $table->timestamp('customer_approved_at')->nullable();
                $table->timestamp('customer_rejected_at')->nullable();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('assigned_approved_at')->nullable();
                $table->timestamp('assigned_rejected_at')->nullable();
                $table->timestamp('warehouse_approved_at')->nullable();
                $table->timestamp('warehouse_rejected_at')->nullable();
                $table->timestamp('picked_at')->nullable();
                $table->timestamp('in_transit_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamp('used_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamps();
            });
            
            // Copy data from old table to temp table with dynamic column check
            $columns = ['id', 'request_id', 'product_id', 'engineer_id', 'part_id', 'requested_quantity', 'reason', 'request_type', 
                 'assigned_person_type', 'assigned_person_id', 'status', 'otp', 'otp_expiry'];
            
            $timestampColumns = ['admin_approved_at', 'admin_rejected_at', 'customer_approved_at', 'customer_rejected_at', 
                'assigned_at', 'assigned_approved_at', 'assigned_rejected_at', 'warehouse_approved_at', 'warehouse_rejected_at',
                'picked_at', 'in_transit_at', 'delivered_at', 'used_at', 'cancelled_at', 'deleted_at', 'created_at', 'updated_at'];
            
            foreach ($timestampColumns as $col) {
                if (Schema::hasColumn($tableName, $col)) {
                    $columns[] = $col;
                }
            }
            
            $columnsList = implode(', ', $columns);
            DB::statement("INSERT INTO $tempTable ($columnsList) SELECT $columnsList FROM $tableName");
            
            // Drop the original table
            Schema::drop($tableName);
            
            // Rename temp table to original name
            Schema::rename($tempTable, $tableName);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $tableName = 'service_request_product_request_parts';
        $tempTable = 'temp_' . $tableName;
        $originalTable = 'original_' . $tableName;
        
        if (Schema::hasTable($tableName)) {
            // Create original table with old structure
            Schema::create($originalTable, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('request_id')->nullable();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->unsignedBigInteger('engineer_id')->nullable();
                $table->unsignedBigInteger('part_id')->nullable();
                $table->integer('requested_quantity')->nullable();
                $table->text('reason')->nullable();
                $table->string('request_type')->nullable();
                $table->enum('assigned_person_type', ['delivery_man', 'engineer'])->nullable();
                $table->unsignedBigInteger('assigned_person_id')->nullable();
                $table->enum('status', ['requested', 'approved', 'rejected', 'customer_approved', 'customer_rejected', 'picked', 'in_transit', 'delivered', 'used', 'cancelled'])->default('requested');
                $table->string('otp', 10)->nullable();
                $table->timestamp('otp_expiry')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('rejected_at')->nullable();
                $table->timestamp('customer_approved_at')->nullable();
                $table->timestamp('customer_rejected_at')->nullable();
                $table->timestamp('assigned_at')->nullable();
                $table->timestamp('picked_at')->nullable();
                $table->timestamp('in_transit_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamp('used_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->timestamps();
            });
            
            // Copy data from current table to original table with column mapping
            $columns = ['id', 'request_id', 'product_id', 'engineer_id', 'part_id', 'requested_quantity', 'reason', 'request_type', 
                 'assigned_person_type', 'assigned_person_id', 'status', 'otp', 'otp_expiry'];
            
            $columnMapping = [
                'approved_at' => 'admin_approved_at',
                'rejected_at' => 'admin_rejected_at',
                'customer_approved_at' => 'customer_approved_at',
                'customer_rejected_at' => 'customer_rejected_at',
                'assigned_at' => 'assigned_at',
                'picked_at' => 'picked_at',
                'in_transit_at' => 'in_transit_at',
                'delivered_at' => 'delivered_at',
                'used_at' => 'used_at',
                'cancelled_at' => 'cancelled_at',
                'deleted_at' => 'deleted_at',
                'created_at' => 'created_at',
                'updated_at' => 'updated_at',
            ];
            
            $selectColumns = [];
            foreach ($columns as $col) {
                $selectColumns[] = $col;
            }
            foreach ($columnMapping as $newCol => $oldCol) {
                if (Schema::hasColumn($tableName, $oldCol)) {
                    $selectColumns[] = "$oldCol AS $newCol";
                } else {
                    $selectColumns[] = "NULL AS $newCol";
                }
            }
            
            $selectList = implode(', ', $selectColumns);
            DB::statement("INSERT INTO $originalTable ($selectList) SELECT * FROM (SELECT $selectList FROM $tableName) AS temp");
            
            // Drop the current table
            Schema::drop($tableName);
            
            // Rename original table to current name
            Schema::rename($originalTable, $tableName);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
