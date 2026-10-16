<?php

namespace Tests\Feature;

use App\Http\Controllers\ServiceRequestController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateAmcRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('covered_items', function (Blueprint $table) {
            $table->id();
        });
        $tables = [
            'customers' => ['email', 'deleted_at'],
            'amc_plans' => ['duration', 'total_visits', 'support_type', 'deleted_at'],
            'amcs' => ['request_id', 'service_type', 'amc_type', 'customer_id', 'customer_address_id', 'amc_plan_id', 'request_date', 'request_source', 'status', 'created_by', 'admin_viewed_at'],
            'amc_schedule_meetings' => ['amc_id', 'service_request_id', 'scheduled_at', 'completed_at', 'remarks', 'report', 'visits_count', 'status'],
            'amc_products' => ['amc_id', 'name', 'type', 'model_no', 'sku', 'hsn', 'purchase_date', 'brand', 'description'],
            'service_requests' => ['request_id', 'service_type', 'customer_id', 'customer_address_id', 'request_date', 'request_source', 'visit_date', 'reschedule_date', 'created_by', 'is_engineer_assigned', 'status', 'amc_plan_id'],
            'service_request_products' => ['service_requests_id', 'item_code_id', 'name', 'type', 'model_no', 'sku', 'hsn', 'purchase_date', 'brand', 'description', 'service_charge'],
        ];
        foreach ($tables as $name => $columns) {
            Schema::create($name, function (Blueprint $table) use ($columns, $name) {
                $table->id();
                foreach ($columns as $column) {
                    if ($name === 'service_request_products' && $column === 'item_code_id') {
                        $table->foreignId('item_code_id')->nullable()->constrained('covered_items')->nullOnDelete();
                        continue;
                    }
                    $table->string($column)->nullable();
                }
                $table->timestamps();
            });
        }
        DB::table('customers')->insert(['id' => 1, 'email' => 'amc@example.test']);
        DB::table('amc_plans')->insert(['id' => 1, 'duration' => 12, 'total_visits' => 2, 'support_type' => 'remote']);
    }

    public function test_creates_amc_products_and_visits_without_a_service_request(): void
    {
        $request = Request::create('/demo/crm/store-amc-request', 'POST', [
            'context' => 'amc',
            'email' => 'amc@example.test',
            'service_type' => 'amc',
            'amc_plan_id' => 1,
            'visit_date' => '2026-10-16',
            'products' => [['product_name' => 'Laptop']],
        ]);
        $response = Model::withoutEvents(fn () => app(ServiceRequestController::class)->storeAmcServiceRequest($request));
        $this->assertSame(route('amcs-lists.index'), $response->getTargetUrl());
        $amc = DB::table('amcs')->first();
        $this->assertNotNull($amc);
        $this->assertSame('remote', $amc->amc_type);
        $this->assertNull($amc->admin_viewed_at);
        $visits = DB::table('amc_schedule_meetings')->orderBy('visits_count')->get();
        $this->assertCount(2, $visits);
        foreach ($visits as $visit) {
            $this->assertSame((string) $amc->id, $visit->amc_id);
            $this->assertNull($visit->service_request_id);
        }
        $this->assertStringStartsWith('2027-04-16', $visits[0]->scheduled_at);
        $this->assertStringStartsWith('2027-10-16', $visits[1]->scheduled_at);
        $this->assertSame((string) $amc->id, DB::table('amc_products')->first()->amc_id);
        $this->assertSame('Laptop', DB::table('amc_products')->first()->name);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('serviceRequestContexts')]
    public function test_service_request_context_creates_service_request_not_amc(?string $context): void
    {
        $payload = [
            'email' => 'amc@example.test',
            'service_type' => 'amc', 'amc_plan_id' => 1, 'visit_date' => '2026-10-16',
            'products' => [['product_name' => 'Laptop']],
        ];
        if ($context !== null) {
            $payload['context'] = $context;
        }
        $request = Request::create('/demo/crm/store-amc-request', 'POST', $payload);
        $response = Model::withoutEvents(fn () => app(ServiceRequestController::class)->storeAmcServiceRequest($request));
        $this->assertSame(route('service-request.index'), $response->getTargetUrl());
        $this->assertSame(0, DB::table('amcs')->count());
        $this->assertSame(1, DB::table('service_requests')->count());
        $this->assertSame(1, DB::table('service_request_products')->count());
        $this->assertSame('1', DB::table('service_requests')->first()->amc_plan_id);
        $this->assertNull(DB::table('service_request_products')->first()->item_code_id);
        $list = app(ServiceRequestController::class)->index()->getData()['amcServices'];
        $this->assertCount(1, $list);
        $this->assertSame(1, $list->first()->id);
        $this->assertStringEndsWith('/demo/crm/service-request/view-amc-service-request/1', route('service-request.view-amc-service-request', $list->first()->id));
        $visits = DB::table('amc_schedule_meetings')->get();
        $this->assertCount(2, $visits);
        foreach ($visits as $visit) {
            $this->assertNull($visit->amc_id);
            $this->assertSame('1', $visit->service_request_id);
        }
    }

    public static function serviceRequestContexts(): array
    {
        return ['explicit service request' => ['service_request'], 'direct or older form' => [null]];
    }

    public function test_amc_edit_loads_and_updates_amc_without_changing_service_request_with_same_id(): void
    {
        DB::table('amcs')->insert(['id' => 1, 'customer_id' => 1, 'amc_plan_id' => 1, 'status' => 'active']);
        DB::table('amc_products')->insert(['id' => 1, 'amc_id' => 1, 'name' => 'Old laptop']);
        DB::table('service_requests')->insert(['id' => 1, 'status' => 'pending']);
        $controller = app(\App\Http\Controllers\AmcController::class);
        $view = $controller->editAmcsRequest(1);
        $this->assertSame('crm.active-amcs.edit', $view->name());
        $this->assertSame('Old laptop', $view->getData()['amc']->amcProducts->first()->name);
        $response = Model::withoutEvents(fn () => $controller->updateAmcsRequest(Request::create('/', 'PUT', [
            'amc_type' => 'onsite', 'request_date' => '2026-10-16', 'status' => 'completed',
            'products' => [['id' => 1, 'name' => 'Updated laptop', 'model_no' => 'New model']],
        ]), 1));
        $this->assertSame(route('amcs-lists.index'), $response->getTargetUrl());
        $this->assertSame('completed', DB::table('amcs')->find(1)->status);
        $this->assertSame('Updated laptop', DB::table('amc_products')->find(1)->name);
        $this->assertSame('pending', DB::table('service_requests')->find(1)->status);
    }

    public function test_amc_edit_cannot_update_product_owned_by_another_amc(): void
    {
        DB::table('amcs')->insert(['id' => 1, 'status' => 'active']);
        DB::table('amc_products')->insert(['id' => 2, 'amc_id' => 2, 'name' => 'Other laptop']);
        try {
            Model::withoutEvents(fn () => app(\App\Http\Controllers\AmcController::class)->updateAmcsRequest(Request::create('/', 'PUT', [
                'amc_type' => 'onsite', 'request_date' => '2026-10-16', 'status' => 'completed',
                'products' => [['id' => 2, 'name' => 'Wrong update']],
            ]), 1));
            $this->fail('A product belonging to another AMC must be rejected.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $this->assertSame('active', DB::table('amcs')->find(1)->status);
            $this->assertSame('Other laptop', DB::table('amc_products')->find(2)->name);
        }
    }
}
