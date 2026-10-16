<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PaymentLogService
{
    public function query(): Builder
    {
        // One invoice per order prevents multiple invoices from duplicating rows.
        $invoice = DB::table('invoices')->select('invoice_number')
            ->whereColumn('invoices.order_id', 'o.id')->whereNull('invoices.deleted_at')
            ->orderByDesc('invoices.id')->limit(1);

        $gateway = DB::table('payments as p')
            ->leftJoin('orders as o', 'o.id', '=', 'p.order_id')
            ->leftJoin('customers as c', 'c.id', '=', 'o.customer_id')
            ->selectRaw("'order' as source, p.id, COALESCE(p.gateway_payment_id, p.gateway_order_id) as reference,
                COALESCE(p.captured_at, p.failed_at, p.authorized_at, p.created_at) as payment_date,
                c.first_name, c.last_name, o.order_number as description,
                p.amount / 100.0 as amount, p.currency, p.method, p.status as raw_status,
                p.gateway, p.gateway_payment_id as transaction_id")
            ->selectSub(clone $invoice, 'invoice_number');

        $orders = DB::table('order_payments as p')
            ->leftJoin('orders as o', 'o.id', '=', 'p.order_id')
            ->leftJoin('customers as c', 'c.id', '=', 'o.customer_id')
            ->whereNull('p.deleted_at')
            // Razorpay also writes order_payments; prefer the gateway's record.
            ->whereNotExists(function (Builder $query) {
                $query->selectRaw('1')->from('payments as gateway_payment')
                    ->whereColumn('gateway_payment.order_id', 'p.order_id')
                    ->where(function (Builder $match) {
                        $match->whereColumn('gateway_payment.gateway_order_id', 'p.payment_id')
                            ->orWhereColumn('gateway_payment.gateway_payment_id', 'p.transaction_id')
                            ->orWhere(function (Builder $placeholder) {
                                // Suppress the temporary checkout row once a gateway order exists.
                                $placeholder->where('p.payment_gateway', 'razorpay')
                                    ->where('p.payment_id', 'like', 'PMT-%')
                                    ->whereNull('p.transaction_id')
                                    ->whereIn('p.status', ['pending', 'processing']);
                            });
                    });
            })
            ->selectRaw("'order' as source, p.id, p.payment_id as reference,
                COALESCE(p.processed_at, p.created_at) as payment_date,
                c.first_name, c.last_name, o.order_number as description,
                p.amount, p.currency, p.payment_method as method, p.status as raw_status,
                p.payment_gateway as gateway, p.transaction_id")
            ->selectSub(clone $invoice, 'invoice_number');

        $amc = DB::table('remote_amc_payments as p')
            ->leftJoin('customers as c', 'c.id', '=', 'p.customer_id')
            ->leftJoin('amc_plans as plan', 'plan.id', '=', 'p.amc_plan_id')
            ->selectRaw("'amc' as source, p.id, p.payment_reference as reference,
                COALESCE(p.paid_at, p.failed_at, p.created_at) as payment_date,
                c.first_name, c.last_name, plan.plan_name as description,
                p.amount / 100.0 as amount, p.currency, p.method, p.status as raw_status,
                p.gateway, p.gateway_payment_id as transaction_id, NULL as invoice_number");

        $services = DB::table('service_request_payments as p')
            ->leftJoin('service_requests as service', 'service.id', '=', 'p.service_request_id')
            ->leftJoin('customers as c', 'c.id', '=', 'service.customer_id')
            ->whereNull('p.deleted_at')
            ->selectRaw("'service' as source, p.id, p.transaction_id as reference,
                COALESCE(p.payment_date, p.created_at) as payment_date,
                c.first_name, c.last_name, service.request_id as description,
                p.total_amount as amount, 'INR' as currency, p.payment_method as method,
                p.payment_status as raw_status, p.payment_gateway as gateway,
                p.transaction_id, NULL as invoice_number");

        $records = $gateway->unionAll($orders)->unionAll($amc)->unionAll($services);
        $normalized = DB::query()->fromSub($records, 'records')->select('records.*')
            ->selectRaw("CASE
                WHEN raw_status IN ('captured', 'completed', 'paid', 'success') THEN 'completed'
                WHEN raw_status IN ('failed', 'rejected', 'cancelled') THEN 'failed'
                WHEN raw_status = 'refunded' THEN 'refunded'
                ELSE 'pending'
            END as status");

        return DB::query()->fromSub($normalized, 'payment_log');
    }
}
