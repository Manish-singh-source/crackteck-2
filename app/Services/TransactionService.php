<?php

namespace App\Services;

use App\Models\OrderPayment;
use App\Models\RemoteAmcPayment;
use App\Models\ServiceRequestPayment;
use App\Models\CashReceived;
use App\Models\VendorPurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionService
{
    /**
     * Transaction type constants
     */
    const TYPE_ORDER = 'order';
    const TYPE_AMC = 'amc';
    const TYPE_SERVICE = 'service';
    const TYPE_CASH = 'cash';
    const TYPE_VENDOR_PO = 'vendor_po';

    /**
     * Get all transaction types
     */
    public static function getTransactionTypes(): array
    {
        return [
            self::TYPE_ORDER => 'Order Payment',
            self::TYPE_AMC => 'AMC Payment',
            self::TYPE_SERVICE => 'Service Payment',
            self::TYPE_CASH => 'Cash Received',
            self::TYPE_VENDOR_PO => 'Vendor PO',
        ];
    }

    /**
     * Get all transaction statuses
     */
    public static function getStatuses(): array
    {
        return [
            // Order payment statuses
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            // AMC payment statuses
            'created' => 'Created',
            'captured' => 'Captured',
            // Service request payment statuses
            'partial_paid' => 'Partial Paid',
            // Cash received statuses
            'customer_paid' => 'Customer Paid',
            'received' => 'Received',
            // Vendor PO statuses
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'cancelled' => 'Cancelled',
        ];
    }

    /**
     * Fetch unified transactions with filters
     */
    public function getTransactions(array $filters = [], int $perPage = 25, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->buildUnifiedQuery($filters, $search);
        
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Build the unified query using UNION with customer/vendor names
     */
    private function buildUnifiedQuery(array $filters = [], ?string $search = null)
    {
        // Get base queries for each table with customer/vendor names
        $orderPayments = $this->getOrderPaymentsWithCustomer($filters);
        $amcPayments = $this->getAmcPaymentsWithCustomer($filters);
        $servicePayments = $this->getServicePaymentsWithCustomer($filters);
        $cashReceived = $this->getCashReceivedWithCustomer($filters);
        $vendorPOs = $this->getVendorPurchaseOrdersWithVendor($filters);

        // Union all queries
        $unionedQuery = $orderPayments
            ->unionAll($amcPayments)
            ->unionAll($servicePayments)
            ->unionAll($cashReceived)
            ->unionAll($vendorPOs);

        // Build final query
        $finalQuery = DB::table(DB::raw('(' . $unionedQuery->toSql() . ') as transactions'))
            ->mergeBindings($unionedQuery);

        // Apply type filter
        if (!empty($filters['transaction_type'])) {
            $finalQuery->where('transaction_type', $filters['transaction_type']);
        }

        // Apply status filter
        if (!empty($filters['status'])) {
            $finalQuery->where('status', $filters['status']);
        }

        // Apply date range filter
        if (!empty($filters['date_from'])) {
            $finalQuery->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $finalQuery->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Apply search filter
        if ($search) {
            $finalQuery->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('vendor_name', 'like', "%{$search}%")
                  ->orWhere('reference_id', 'like', "%{$search}%");
            });
        }

        return $finalQuery;
    }

    /**
     * Query for order_payments with customer name (status = 'completed')
     */
    private function getOrderPaymentsWithCustomer(array $filters)
    {
        $query = DB::table('order_payments as op')
            ->select([
                'op.id',
                DB::raw("'order' as transaction_type"),
                'op.order_id as reference_id',
                'o.customer_id',
                DB::raw('NULL as vendor_id'),
                DB::raw('NULL as staff_id'),
                'op.amount',
                'op.status',
                'op.payment_method as payment_mode',
                'op.created_at',
                DB::raw("'order_payments' as source_table"),
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                DB::raw('NULL as vendor_name'),
            ])
            ->join('orders as o', 'op.order_id', '=', 'o.id')
            ->join('customers as c', 'o.customer_id', '=', 'c.id')
            ->where('op.status', 'completed');

        return $query;
    }

    /**
     * Query for remote_amc_payments with customer name (status = 'captured')
     */
    private function getAmcPaymentsWithCustomer(array $filters)
    {
        $query = DB::table('remote_amc_payments as rap')
            ->select([
                'rap.id',
                DB::raw("'amc' as transaction_type"),
                'rap.amc_id as reference_id',
                'rap.customer_id',
                DB::raw('NULL as vendor_id'),
                DB::raw('NULL as staff_id'),
                'rap.amount',
                'rap.status',
                'rap.method as payment_mode',
                'rap.created_at',
                DB::raw("'remote_amc_payments' as source_table"),
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                DB::raw('NULL as vendor_name'),
            ])
            ->join('customers as c', 'rap.customer_id', '=', 'c.id')
            ->where('rap.status', 'captured');

        return $query;
    }

    /**
     * Query for service_request_payments with customer name (payment_status = 'completed')
     */
    private function getServicePaymentsWithCustomer(array $filters)
    {
        $query = DB::table('service_request_payments as srp')
            ->select([
                'srp.id',
                DB::raw("'service' as transaction_type"),
                'srp.service_request_id as reference_id',
                'sr.customer_id',
                DB::raw('NULL as vendor_id'),
                DB::raw('NULL as staff_id'),
                'srp.total_amount as amount',
                'srp.payment_status as status',
                'srp.payment_method as payment_mode',
                'srp.created_at',
                DB::raw("'service_request_payments' as source_table"),
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                DB::raw('NULL as vendor_name'),
            ])
            ->join('service_requests as sr', 'srp.service_request_id', '=', 'sr.id')
            ->join('customers as c', 'sr.customer_id', '=', 'c.id')
            ->where('srp.payment_status', 'completed');

        return $query;
    }

    /**
     * Query for cash_received with customer name (all records, no status filter)
     */
    private function getCashReceivedWithCustomer(array $filters)
    {
        $query = DB::table('cash_received as cr')
            ->select([
                'cr.id',
                DB::raw("'cash' as transaction_type"),
                DB::raw('COALESCE(cr.order_id, cr.service_request_id) as reference_id'),
                'cr.customer_id',
                DB::raw('NULL as vendor_id'),
                'cr.staff_id',
                'cr.amount',
                'cr.status',
                DB::raw("'cash' as payment_mode"),
                'cr.created_at',
                DB::raw("'cash_received' as source_table"),
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                DB::raw('NULL as vendor_name'),
            ])
            ->join('customers as c', 'cr.customer_id', '=', 'c.id');

        return $query;
    }

    /**
     * Query for vendor_purchase_orders with vendor name (all records, no status filter)
     */
    private function getVendorPurchaseOrdersWithVendor(array $filters)
    {
        $query = DB::table('vendor_purchase_orders as vpo')
            ->select([
                'vpo.id',
                DB::raw("'vendor_po' as transaction_type"),
                'vpo.id as reference_id',
                DB::raw('NULL as customer_id'),
                'vpo.vendor_id',
                DB::raw('NULL as staff_id'),
                'vpo.po_amount as amount',
                'vpo.po_status as status',
                DB::raw("'bank_transfer' as payment_mode"),
                'vpo.created_at',
                DB::raw("'vendor_purchase_orders' as source_table"),
                DB::raw('NULL as customer_name'),
                DB::raw("CONCAT(v.first_name, ' ', v.last_name) as vendor_name"),
            ])
            ->join('vendors as v', 'vpo.vendor_id', '=', 'v.id');

        return $query;
    }

    /**
     * Get transaction details by ID and type
     */
    public function getTransactionById(int $id, string $type): ?array
    {
        $transaction = null;

        switch ($type) {
            case self::TYPE_ORDER:
                $transaction = $this->getOrderPaymentDetails($id);
                break;
            case self::TYPE_AMC:
                $transaction = $this->getAmcPaymentDetails($id);
                break;
            case self::TYPE_SERVICE:
                $transaction = $this->getServicePaymentDetails($id);
                break;
            case self::TYPE_CASH:
                $transaction = $this->getCashReceivedDetails($id);
                break;
            case self::TYPE_VENDOR_PO:
                $transaction = $this->getVendorPODetails($id);
                break;
        }

        return $transaction;
    }

    /**
     * Get order payment details with joins
     */
    private function getOrderPaymentDetails(int $id)
    {
        return DB::table('order_payments as op')
            ->select([
                'op.*',
                'o.order_number',
                'o.customer_id',
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                'c.phone as customer_phone',
            ])
            ->join('orders as o', 'op.order_id', '=', 'o.id')
            ->join('customers as c', 'o.customer_id', '=', 'c.id')
            ->where('op.id', $id)
            ->first();
    }

    /**
     * Get AMC payment details
     */
    private function getAmcPaymentDetails(int $id)
    {
        return DB::table('remote_amc_payments as rap')
            ->select([
                'rap.*',
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                'c.phone as customer_phone',
                'a.amc_number',
            ])
            ->join('customers as c', 'rap.customer_id', '=', 'c.id')
            ->join('amcs as a', 'rap.amc_id', '=', 'a.id')
            ->where('rap.id', $id)
            ->first();
    }

    /**
     * Get service payment details
     */
    private function getServicePaymentDetails(int $id)
    {
        return DB::table('service_request_payments as srp')
            ->select([
                'srp.*',
                'sr.service_request_number',
                'sr.customer_id',
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                'c.phone as customer_phone',
            ])
            ->join('service_requests as sr', 'srp.service_request_id', '=', 'sr.id')
            ->join('customers as c', 'sr.customer_id', '=', 'c.id')
            ->where('srp.id', $id)
            ->first();
    }

    /**
     * Get cash received details
     */
    private function getCashReceivedDetails(int $id)
    {
        return DB::table('cash_received as cr')
            ->select([
                'cr.*',
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                'c.phone as customer_phone',
                's.name as staff_name',
            ])
            ->join('customers as c', 'cr.customer_id', '=', 'c.id')
            ->join('staff as s', 'cr.staff_id', '=', 's.id')
            ->where('cr.id', $id)
            ->first();
    }

    /**
     * Get vendor PO details
     */
    private function getVendorPODetails(int $id)
    {
        return DB::table('vendor_purchase_orders as vpo')
            ->select([
                'vpo.*',
                'v.name as vendor_name',
                'v.phone as vendor_phone',
                'v.email as vendor_email',
            ])
            ->join('vendors as v', 'vpo.vendor_id', '=', 'v.id')
            ->where('vpo.id', $id)
            ->first();
    }

    /**
     * Get total transactions count by type
     */
    public function getTransactionCounts(): array
    {
        return [
            'order' => OrderPayment::where('status', 'completed')->count(),
            'amc' => RemoteAmcPayment::where('status', 'captured')->count(),
            'service' => ServiceRequestPayment::where('payment_status', 'completed')->count(),
            'cash' => CashReceived::count(),
            'vendor_po' => VendorPurchaseOrder::count(),
            'total' => 
                OrderPayment::where('status', 'completed')->count() +
                RemoteAmcPayment::where('status', 'captured')->count() +
                ServiceRequestPayment::where('payment_status', 'completed')->count() +
                CashReceived::count() +
                VendorPurchaseOrder::count(),
        ];
    }

    /**
     * Get total amount by type
     */
    public function getTotalAmounts(): array
    {
        return [
            'order' => OrderPayment::where('status', 'completed')->sum('amount'),
            'amc' => RemoteAmcPayment::where('status', 'captured')->sum('amount'),
            'service' => ServiceRequestPayment::where('payment_status', 'completed')->sum('total_amount'),
            'cash' => CashReceived::sum('amount'),
            'vendor_po' => VendorPurchaseOrder::sum('po_amount'),
        ];
    }
}
