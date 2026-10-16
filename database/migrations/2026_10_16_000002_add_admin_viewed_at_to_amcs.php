<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('amcs', function (Blueprint $table) {
            $table->timestamp('admin_viewed_at')->nullable()->index();
        });
        DB::table('amcs')->update(['admin_viewed_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('amcs', function (Blueprint $table) {
            $table->dropIndex(['admin_viewed_at']);
            $table->dropColumn('admin_viewed_at');
        });
    }
};
