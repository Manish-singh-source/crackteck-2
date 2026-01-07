<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $subs = [
            ['email' => 'newsletter1@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'newsletter2@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'newsletter3@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'john.sub@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'jane.sub@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'vip@example.com', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Insert and ignore duplicates if any
        DB::table('subscribers')->insertOrIgnore($subs);
    }
}
