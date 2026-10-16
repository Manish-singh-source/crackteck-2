<?php

namespace Tests\Feature;

use App\Http\Controllers\AmcController;
use App\Services\AmcUnreadService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AmcUnreadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('amcs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('amc_plan_id')->nullable();
            $table->timestamps();
        });
    }

    private function migrateUnreadColumn(): void
    {
        (require database_path('migrations/2026_10_16_000002_add_admin_viewed_at_to_amcs.php'))->up();
    }

    public function test_new_amcs_count_and_only_viewed_record_is_cleared(): void
    {
        DB::table('amcs')->insert(['id' => 1]);
        $this->migrateUnreadColumn();
        $service = app(AmcUnreadService::class);
        $this->assertSame(0, $service->count());
        DB::table('amcs')->insert([
            ['id' => 2, 'updated_at' => '2026-10-16 10:00:00'],
            ['id' => 3, 'updated_at' => '2026-10-16 10:00:00'],
        ]);
        $this->assertSame(2, $service->count());
        $service->markViewed(2);
        $this->assertSame(1, $service->count());
        $viewed = DB::table('amcs')->find(2);
        $this->assertNotNull($viewed->admin_viewed_at);
        $this->assertSame('2026-10-16 10:00:00', $viewed->updated_at);
        $service->markViewed(2);
        $this->assertSame($viewed->admin_viewed_at, DB::table('amcs')->find(2)->admin_viewed_at);
        $this->assertNull(DB::table('amcs')->find(3)->admin_viewed_at);
        $service->markViewed(3);
        $this->assertSame(0, $service->count());
    }

    public function test_opening_amc_list_keeps_new_amcs_unread(): void
    {
        $this->migrateUnreadColumn();
        Schema::create('amc_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amc_id');
        });
        DB::table('amcs')->insert(['id' => 1]);
        app(AmcController::class)->listAmcRequests(Request::create('/demo/crm/amcs-list'));
        $this->assertSame(1, app(AmcUnreadService::class)->count());
    }

    public function test_amc_count_endpoint_requires_staff_login(): void
    {
        $this->getJson(route('amcs-lists.unread-count'))->assertUnauthorized();
    }
}
