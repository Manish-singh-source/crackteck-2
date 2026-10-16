<?php

namespace Tests\Feature;

use App\Http\Controllers\PaymentController;
use App\Models\Staff;
use App\Services\PaymentLogService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PaymentLogTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Isolated query fixtures: never run migrations or modify the application's database.
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        $tables = [
            'customers' => ['first_name', 'last_name'],
            'orders' => ['customer_id', 'order_number'],
            'invoices' => ['order_id', 'invoice_number', 'deleted_at'],
            'amc_plans' => ['plan_name'],
            'service_requests' => ['customer_id', 'request_id'],
            'payments' => ['order_id', 'gateway_payment_id', 'gateway_order_id', 'captured_at', 'failed_at', 'authorized_at', 'created_at', 'amount', 'currency', 'method', 'status', 'gateway'],
            'order_payments' => ['order_id', 'payment_id', 'transaction_id', 'processed_at', 'created_at', 'deleted_at', 'amount', 'currency', 'payment_method', 'status', 'payment_gateway'],
            'remote_amc_payments' => ['customer_id', 'amc_plan_id', 'payment_reference', 'paid_at', 'failed_at', 'created_at', 'amount', 'currency', 'method', 'status', 'gateway', 'gateway_payment_id'],
            'service_request_payments' => ['service_request_id', 'transaction_id', 'payment_date', 'created_at', 'deleted_at', 'total_amount', 'payment_method', 'payment_status', 'payment_gateway'],
        ];
        foreach ($tables as $name => $columns) {
            Schema::create($name, function (Blueprint $table) use ($columns) {
                $table->id();
                foreach ($columns as $column) {
                    $table->string($column)->nullable();
                }
            });
        }
        DB::table('customers')->insert(['id' => 1, 'first_name' => 'Test', 'last_name' => 'Customer']);
        DB::table('orders')->insert(['id' => 1, 'customer_id' => 1, 'order_number' => 'ORD-TEST']);
        DB::table('amc_plans')->insert(['id' => 1, 'plan_name' => 'Remote Plan']);
        DB::table('service_requests')->insert(['id' => 1, 'customer_id' => 1, 'request_id' => 'SERVICE-TEST']);
    }

    private function payment(string $table, array $data): void
    {
        DB::table($table)->insert($data + ['created_at' => '2026-10-15 10:00:00']);
    }

    private function page(array $filters = [])
    {
        return app(PaymentController::class)->index(
            Request::create('/crm/payments', 'GET', $filters), app(PaymentLogService::class)
        );
    }

    public function test_combines_sources_and_converts_only_gateway_amounts_from_paise(): void
    {
        $this->payment('payments', ['order_id' => 1, 'gateway_order_id' => 'order-gateway', 'amount' => 12345, 'currency' => 'INR', 'status' => 'captured']);
        $this->payment('order_payments', ['order_id' => 1, 'payment_id' => 'cod-payment', 'amount' => '200.50', 'currency' => 'INR', 'status' => 'pending', 'payment_method' => 'cod']);
        $this->payment('remote_amc_payments', ['customer_id' => 1, 'amc_plan_id' => 1, 'payment_reference' => 'AMC-TEST', 'amount' => 9999, 'currency' => 'INR', 'status' => 'authorized']);
        $this->payment('service_request_payments', ['service_request_id' => 1, 'transaction_id' => 'SERVICE-PAY', 'total_amount' => '150.25', 'payment_status' => 'completed']);

        $rows = app(PaymentLogService::class)->query()->get()->keyBy('reference');
        $this->assertCount(4, $rows);
        $this->assertEquals(123.45, $rows['order-gateway']->amount);
        $this->assertEquals(200.50, $rows['cod-payment']->amount);
        $this->assertEquals(99.99, $rows['AMC-TEST']->amount);
        $this->assertEquals(150.25, $rows['SERVICE-PAY']->amount);
        $this->assertSame('completed', $rows['order-gateway']->status);
        $this->assertSame('pending', $rows['AMC-TEST']->status);
        $this->assertSame('Test', $rows['SERVICE-PAY']->first_name);
    }

    public function test_deduplicates_gateway_mirrors_and_checkout_placeholders_and_ignores_deleted_records(): void
    {
        $this->payment('payments', ['order_id' => 1, 'gateway_order_id' => 'order-gateway', 'gateway_payment_id' => 'pay-gateway', 'amount' => 10000, 'status' => 'captured']);
        $this->payment('order_payments', ['order_id' => 1, 'payment_id' => 'order-gateway', 'transaction_id' => 'pay-gateway', 'status' => 'completed']);
        $this->payment('order_payments', ['order_id' => 1, 'payment_id' => 'PMT-checkout-placeholder', 'payment_gateway' => 'razorpay', 'status' => 'processing']);
        $this->payment('order_payments', ['order_id' => 1, 'payment_id' => 'deleted', 'deleted_at' => now()]);
        $this->payment('service_request_payments', ['service_request_id' => 1, 'transaction_id' => 'deleted-service', 'deleted_at' => now()]);
        DB::table('invoices')->insert([
            ['order_id' => 1, 'invoice_number' => 'INV-OLD'],
            ['order_id' => 1, 'invoice_number' => 'INV-LATEST'],
        ]);
        $rows = app(PaymentLogService::class)->query()->get();
        $this->assertCount(1, $rows);
        $this->assertSame('INV-LATEST', $rows->first()->invoice_number);
    }

    public function test_status_filters_counts_search_and_dates_use_database_records(): void
    {
        foreach (['captured', 'failed', 'refunded', 'created'] as $index => $status) {
            $this->payment('remote_amc_payments', ['customer_id' => 1, 'amc_plan_id' => 1, 'payment_reference' => 'AMC-'.$index, 'status' => $status, 'amount' => 10000]);
        }
        $data = $this->page(['status' => 'completed', 'source' => 'amc', 'search' => 'Remote Plan', 'from' => '2026-10-15', 'to' => '2026-10-15'])->getData();
        $this->assertSame(1, $data['payments']->total());
        $this->assertSame('AMC-0', $data['payments']->first()->reference);
        $this->assertEquals(4, $data['counts']['all']);
        foreach (['completed', 'failed', 'refunded', 'pending'] as $status) {
            $this->assertEquals(1, $data['counts'][$status]);
            $this->assertSame($status, $this->page(['status' => $status])->getData()['payments']->first()->status);
        }
        $this->assertSame(0, $this->page(['search' => 'no-match'])->getData()['payments']->total());
        $this->assertSame(4, $this->page(['search' => 'Test Customer'])->getData()['payments']->total());
        $this->assertSame(0, $this->page(['from' => '2026-10-16'])->getData()['payments']->total());
    }

    public function test_paginates_and_renders_an_empty_page_without_dummy_rows(): void
    {
        view()->share('errors', new \Illuminate\Support\ViewErrorBag);
        Auth::guard('staff_web')->setUser(new Staff(['first_name' => 'Test', 'last_name' => 'Staff']));
        $html = $this->page()->render();
        $this->assertStringContainsString('No payments found.', $html);
        $this->assertStringNotContainsString('Alice Brown', $html);
        for ($i = 0; $i < 26; $i++) {
            $this->payment('order_payments', ['order_id' => 1, 'payment_id' => 'COD-'.$i, 'amount' => 10, 'currency' => 'INR', 'status' => 'pending']);
        }
        $page = $this->page();
        $this->assertSame(26, $page->getData()['payments']->total());
        $this->assertCount(25, $page->getData()['payments']);
        $this->assertStringContainsString('COD-', $page->render());
    }

    public function test_rejects_invalid_status_filters(): void
    {
        $this->expectException(ValidationException::class);
        $this->page(['status' => 'invalid']);
    }
}
