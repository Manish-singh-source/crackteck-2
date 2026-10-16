<?php

namespace Tests\Feature;

use App\Services\EcommerceUnreadService;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderFeedbackController;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EcommerceUnreadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        foreach (['orders', 'order_feedback'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    private function migrateUnreadColumns(): void
    {
        (require database_path('migrations/2026_10_16_000001_add_admin_viewed_at_to_orders_and_order_feedback.php'))->up();
    }

    public function test_historical_records_start_viewed_and_new_records_are_unread(): void
    {
        DB::table('orders')->insert(['id' => 1]);
        DB::table('order_feedback')->insert(['id' => 1]);
        $this->migrateUnreadColumns();
        $service = app(EcommerceUnreadService::class);
        $this->assertSame(['orders' => 0, 'reviews' => 0], $service->counts());
        DB::table('orders')->insert(['id' => 2]);
        DB::table('order_feedback')->insert(['id' => 2]);
        $this->assertSame(['orders' => 1, 'reviews' => 1], $service->counts());
    }

    public function test_only_displayed_records_are_cleared_and_new_arrivals_remain_unread(): void
    {
        $this->migrateUnreadColumns();
        foreach (['orders', 'order_feedback'] as $name) {
            DB::table($name)->insert([
                ['id' => 1, 'updated_at' => '2026-10-16 10:00:00'],
                ['id' => 2, 'updated_at' => '2026-10-16 10:00:00'],
            ]);
        }
        $service = app(EcommerceUnreadService::class);
        $service->markOrdersViewed([1]);
        $service->markReviewsViewed([1]);
        $this->assertSame(['orders' => 1, 'reviews' => 1], $service->counts());
        foreach (['orders', 'order_feedback'] as $name) {
            $record = DB::table($name)->find(1);
            $this->assertNotNull($record->admin_viewed_at);
            $this->assertSame('2026-10-16 10:00:00', $record->updated_at);
            $this->assertNull(DB::table($name)->find(2)->admin_viewed_at);
        }
        $service->markOrdersViewed([2]);
        $service->markReviewsViewed([2]);
        $this->assertSame(['orders' => 0, 'reviews' => 0], $service->counts());
    }

    public function test_deleted_reviews_are_excluded_and_empty_views_do_not_clear_counts(): void
    {
        $this->migrateUnreadColumns();
        DB::table('order_feedback')->insert([
            ['id' => 1, 'deleted_at' => null],
            ['id' => 2, 'deleted_at' => now()],
        ]);
        $service = app(EcommerceUnreadService::class);
        $service->markReviewsViewed([]);
        $this->assertSame(['orders' => 0, 'reviews' => 1], $service->counts());
    }

    public function test_sidebar_shows_red_counts_and_hides_zero_counts(): void
    {
        $this->migrateUnreadColumns();
        DB::table('orders')->insert(['id' => 1]);
        $html = view('e-commerce.layouts.sidebar')->render();
        $this->assertMatchesRegularExpression('/data-unread-count="orders"[^>]*bg-danger[^>]*>1<\/span>/', $html);
        $this->assertMatchesRegularExpression('/data-unread-count="reviews"[^>]*d-none[^>]*>0<\/span>/', $html);
    }

    public function test_live_count_endpoint_requires_staff_login(): void
    {
        $this->getJson(route('e-commerce.sidebar-unread-counts'))->assertUnauthorized();
    }

    public function test_opening_lists_does_not_mark_new_orders_or_reviews_as_viewed(): void
    {
        $this->migrateUnreadColumns();
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('customer_id')->nullable();
        });
        foreach (['invoices', 'order_items'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->softDeletes();
            });
        }
        DB::table('orders')->insert(['id' => 1]);
        DB::table('order_feedback')->insert(['id' => 1]);
        app(OrderController::class)->index(Request::create('/demo/e-commerce/order'));
        app(OrderFeedbackController::class)->index(Request::create('/demo/e-commerce/order-feedback'));
        $this->assertSame(['orders' => 1, 'reviews' => 1], app(EcommerceUnreadService::class)->counts());
    }
}
