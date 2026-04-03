<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderFeedback;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductSerial;
use App\Models\ScrapItem;
use App\Models\SubCategory;
use App\Models\Vendor;
use App\Models\VendorPurchaseOrder;
use App\Models\Warehouse;
use App\Models\WarehouseRack;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WarehouseDashboardController extends Controller
{
    private const LOW_STOCK_THRESHOLD = 10;

    public function index(Request $request)
    {
        $filters = $this->filters($request);

        return view('warehouse.index', [
            'filterOptions' => $this->options(),
            'initialFilters' => $filters,
            'dashboardData' => $this->buildData($filters),
            'dashboardDataUrl' => route('warehouse.dashboard.data'),
            'dashboardAssumptions' => $this->assumptions(),
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $filters = $this->filters($request);

        return response()->json([
            'filters' => $filters,
            'data' => $this->buildData($filters),
            'generated_at' => now()->toIso8601String(),
        ]);
    }

    private function buildData(array $filters): array
    {
        [$from, $to, $previousFrom, $previousTo] = $this->periods($filters);

        $products = $this->productQuery($filters)
            ->with(['brand:id,name', 'parentCategorie:id,name', 'warehouse:id,name'])
            ->get(['products.id', 'products.vendor_id', 'products.brand_id', 'products.parent_category_id', 'products.sub_category_id', 'products.warehouse_id', 'products.product_name', 'products.sku', 'products.stock_quantity', 'products.stock_status', 'products.cost_price', 'products.selling_price', 'products.final_price', 'products.created_at', 'products.updated_at']);

        $warehouses = $this->warehouseQuery($filters)->get(['warehouses.id', 'warehouses.name', 'warehouses.city', 'warehouses.state', 'warehouses.max_store_capacity', 'warehouses.created_at']);

        $purchaseOrders = $this->purchaseOrderQuery($filters, $from, $to)
            ->with('vendor:id,first_name,last_name')
            ->get(['id', 'vendor_id', 'purchase_date', 'po_amount', 'po_amount_paid', 'po_amount_pending', 'po_status', 'created_at']);

        $scrapItems = $this->scrapQuery($filters, $from, $to)
            ->with(['product:id,brand_id,parent_category_id,product_name,cost_price', 'product.brand:id,name', 'product.parentCategorie:id,name'])
            ->get(['id', 'product_id', 'quantity_scrapped', 'reason_for_scrap', 'scrapped_at', 'created_at']);

        $serials = $this->serialQuery($filters)->get(['product_serials.id', 'product_serials.product_id', 'product_serials.status', 'product_serials.final_price', 'product_serials.created_at']);

        $orderItems = $this->orderItemQuery($filters, $from, $to)
            ->select('order_items.id', 'order_items.product_id', 'order_items.quantity', 'order_items.line_total', 'order_items.item_status', 'order_items.created_at', 'products.product_name', 'products.brand_id', 'products.parent_category_id')
            ->get();

        $feedback = $this->feedbackQuery($filters, $from, $to)->get(['order_feedback.id', 'order_feedback.status', 'order_feedback.star', 'order_feedback.created_at']);

        $currentRevenue = round((float) $orderItems->sum('line_total'), 2);
        $previousRevenue = round((float) $this->orderItemQuery($filters, $previousFrom, $previousTo)->sum('order_items.line_total'), 2);
        $currentScrap = (int) $scrapItems->count();
        $previousScrap = (int) $this->scrapQuery($filters, $previousFrom, $previousTo)->count();
        $currentLow = $products->filter(fn ($item) => $item->stock_status === 'low_stock' || ($item->stock_quantity > 0 && $item->stock_quantity <= self::LOW_STOCK_THRESHOLD))->count();
        $currentOut = $products->filter(fn ($item) => $item->stock_status === 'out_of_stock' || $item->stock_quantity <= 0)->count();

        $previousLow = $this->productQuery($filters)->whereBetween('products.updated_at', [$previousFrom, $previousTo])->where(function ($query) {
            $query->where('products.stock_status', 'low_stock')->orWhereBetween('products.stock_quantity', [1, self::LOW_STOCK_THRESHOLD]);
        })->count();

        $previousOut = $this->productQuery($filters)->whereBetween('products.updated_at', [$previousFrom, $previousTo])->where(function ($query) {
            $query->where('products.stock_status', 'out_of_stock')->orWhere('products.stock_quantity', '<=', 0);
        })->count();

        $summaryCards = [
            ['key' => 'warehouses', 'label' => 'Total Warehouses', 'value' => $warehouses->count(), 'icon' => 'fas fa-warehouse', 'tone' => 'primary', 'trend' => $this->trend($this->warehouseQuery($filters)->whereBetween('warehouses.created_at', [$from, $to])->count(), $this->warehouseQuery($filters)->whereBetween('warehouses.created_at', [$previousFrom, $previousTo])->count())],
            ['key' => 'products', 'label' => 'Total Products', 'value' => $products->count(), 'icon' => 'fas fa-boxes-stacked', 'tone' => 'info', 'trend' => $this->trend($this->productQuery($filters)->whereBetween('products.created_at', [$from, $to])->count(), $this->productQuery($filters)->whereBetween('products.created_at', [$previousFrom, $previousTo])->count())],
            ['key' => 'scrap', 'label' => 'Total Scrap Items', 'value' => $currentScrap, 'icon' => 'fas fa-recycle', 'tone' => 'warning', 'trend' => $this->trend($currentScrap, $previousScrap)],
            ['key' => 'out', 'label' => 'Total Out of Stock Items', 'value' => $currentOut, 'icon' => 'fas fa-triangle-exclamation', 'tone' => 'danger', 'trend' => $this->trend($currentOut, $previousOut)],
            ['key' => 'low', 'label' => 'Pending Low Stock Alerts', 'value' => $currentLow, 'icon' => 'fas fa-bell', 'tone' => 'secondary', 'trend' => $this->trend($currentLow, $previousLow)],
            ['key' => 'revenue', 'label' => 'Products Revenue', 'value' => $currentRevenue, 'type' => 'currency', 'icon' => 'fas fa-indian-rupee-sign', 'tone' => 'success', 'trend' => $this->trend($currentRevenue, $previousRevenue)],
        ];

        $productsByCategory = $products->groupBy(fn ($item) => $item->parentCategorie->name ?? 'Uncategorised')->map->count()->sortDesc()->take(6);
        $productsByBrand = $products->groupBy(fn ($item) => $item->brand->name ?? 'Unknown')->map->count()->sortDesc()->take(6);
        $poStatus = $purchaseOrders->groupBy('po_status')->map->count()->sortKeys();
        $topVendors = $purchaseOrders->groupBy('vendor_id')->map(function (Collection $group) {
            $vendor = $group->first()->vendor;
            return ['label' => trim(($vendor->first_name ?? 'Unknown') . ' ' . ($vendor->last_name ?? 'Vendor')), 'orders' => $group->count(), 'amount' => round((float) $group->sum('po_amount'), 2)];
        })->sortByDesc('amount')->take(5)->values();
        $bestSellers = $orderItems->groupBy('product_id')->map(function (Collection $group) {
            $first = $group->first();
            return ['label' => $first->product_name, 'quantity' => (int) $group->sum('quantity'), 'revenue' => round((float) $group->sum('line_total'), 2)];
        })->sortByDesc('quantity')->take(5)->values();

        $topRevenueProducts = $orderItems->groupBy('product_id')->map(function (Collection $group) {
            $first = $group->first();
            return ['label' => $first->product_name, 'quantity' => (int) $group->sum('quantity'), 'revenue' => round((float) $group->sum('line_total'), 2)];
        })->sortByDesc('revenue')->take(5)->values();

        $stockStatus = collect([
            'In Stock' => $products->filter(fn ($item) => $item->stock_status === 'in_stock' && $item->stock_quantity > self::LOW_STOCK_THRESHOLD)->count(),
            'Low Stock' => $currentLow,
            'Out of Stock' => $currentOut,
            'Scrap' => $products->where('stock_status', 'scrap')->count(),
        ]);

        $scrapByBrand = $scrapItems->groupBy(fn ($item) => $item->product?->brand?->name ?? 'Unknown')->map(fn ($group) => (int) $group->sum('quantity_scrapped'))->sortDesc()->take(6);
        $scrapByCategory = $scrapItems->groupBy(fn ($item) => $item->product?->parentCategorie?->name ?? 'Uncategorised')->map(fn ($group) => (int) $group->sum('quantity_scrapped'))->sortDesc()->take(6);
        $lowByBrand = $products->filter(fn ($item) => $item->stock_status === 'low_stock' || ($item->stock_quantity > 0 && $item->stock_quantity <= self::LOW_STOCK_THRESHOLD))->groupBy(fn ($item) => $item->brand->name ?? 'Unknown')->map->count()->sortDesc()->take(6);
        $outByBrand = $products->filter(fn ($item) => $item->stock_status === 'out_of_stock' || $item->stock_quantity <= 0)->groupBy(fn ($item) => $item->brand->name ?? 'Unknown')->map->count()->sortDesc()->take(6);
        $revenueByCategory = $orderItems->groupBy(fn ($item) => optional($products->firstWhere('id', $item->product_id)?->parentCategorie)->name ?? 'Uncategorised')->map(fn ($group) => round((float) $group->sum('line_total'), 2))->sortDesc()->take(6);
        $revenueByBrand = $orderItems->groupBy(fn ($item) => optional($products->firstWhere('id', $item->product_id)?->brand)->name ?? 'Unknown')->map(fn ($group) => round((float) $group->sum('line_total'), 2))->sortDesc()->take(6);

        $warehousePerformance = Warehouse::query()
            ->whereNull('warehouses.deleted_at')
            ->when($filters['warehouse_id'], fn ($query) => $query->where('warehouses.id', $filters['warehouse_id']))
            ->when($filters['vendor_id'] || $filters['category_id'] || $filters['subcategory_id'] || $filters['brand_id'], function ($query) use ($filters) {
                $query->whereHas('products', function (Builder $builder) use ($filters) { $this->applyProductFilters($builder, $filters); });
            })
            ->withCount(['products as products_count' => function (Builder $query) use ($filters) { $this->applyProductFilters($query, $filters); }])
            ->withSum(['products as stock_units' => function (Builder $query) use ($filters) { $this->applyProductFilters($query, $filters); }], 'stock_quantity')
            ->with(['racks:id,warehouse_id,quantity,filled_quantity'])
            ->get(['warehouses.id', 'warehouses.name', 'warehouses.city', 'warehouses.state', 'warehouses.max_store_capacity', 'warehouses.verification_status'])
            ->map(function (Warehouse $warehouse) {
                $rackCapacity = (int) $warehouse->racks->sum('quantity');
                $rackFilled = (int) $warehouse->racks->sum('filled_quantity');
                $capBase = $rackCapacity > 0 ? $rackCapacity : (int) ($warehouse->max_store_capacity ?: 0);
                $stockUnits = (int) ($warehouse->stock_units ?: 0);
                return [
                    'name' => $warehouse->name,
                    'location' => trim($warehouse->city . ', ' . $warehouse->state, ', '),
                    'products_count' => (int) $warehouse->products_count,
                    'stock_units' => $stockUnits,
                    'rack_capacity' => $rackCapacity,
                    'rack_filled' => $rackFilled,
                    'capacity_usage' => $capBase > 0 ? round(($stockUnits / $capBase) * 100, 1) : 0,
                    'rack_usage' => $rackCapacity > 0 ? round(($rackFilled / $rackCapacity) * 100, 1) : 0,
                    'verification_status' => $warehouse->verification_status,
                ];
            })->sortByDesc('products_count')->values();

        $racks = $this->rackQuery($filters);
        $rackCapacity = (int) (clone $racks)->sum('warehouse_racks.quantity');
        $rackFilled = (int) (clone $racks)->sum('warehouse_racks.filled_quantity');
        $inventoryValue = round((float) $products->sum(fn ($item) => ((float) ($item->final_price ?: $item->selling_price ?: $item->cost_price)) * (int) $item->stock_quantity), 2);
        $returnRate = $orderItems->sum('quantity') > 0 ? round(($orderItems->where('item_status', 'returned')->sum('quantity') / max(1, $orderItems->sum('quantity'))) * 100, 1) : 0;
        $paymentMix = $this->paymentMix($filters, $from, $to);
        $customerMix = $this->customerMix($filters, $from, $to);
        $reviewMix = $feedback->groupBy('status')->map->count()->sortKeys();
        $reviewAverage = $feedback->count() ? round((float) $feedback->avg('star'), 1) : null;

        return [
            'summary_cards' => array_map(function ($card) { $card['sparkline'] = [$card['trend']['previous'], $card['trend']['current']]; return $card; }, $summaryCards),
            'meta' => ['range' => ['date_from' => $from->toDateString(), 'date_to' => $to->toDateString(), 'days' => $from->diffInDays($to) + 1], 'last_updated' => now()->format('d M Y, h:i A'), 'currency' => 'INR', 'low_stock_threshold' => self::LOW_STOCK_THRESHOLD],
            'overview' => ['inventory_value' => $inventoryValue, 'rack_capacity' => $rackCapacity, 'rack_filled' => $rackFilled, 'rack_utilization' => $rackCapacity > 0 ? round(($rackFilled / $rackCapacity) * 100, 1) : 0, 'inventory_turnover' => $inventoryValue > 0 ? round($currentRevenue / $inventoryValue, 2) : 0, 'active_serials' => $serials->where('status', 'active')->count(), 'sold_serials' => $serials->where('status', 'sold')->count(), 'scrap_value' => round((float) $scrapItems->sum(fn ($item) => ((float) optional($item->product)->cost_price) * (int) $item->quantity_scrapped), 2), 'return_rate' => $returnRate, 'review_average' => $reviewAverage, 'payment_mix' => $paymentMix, 'customer_mix' => $customerMix, 'review_mix' => $reviewMix],
            'charts' => [
                'purchase_orders_timeline' => $this->series($purchaseOrders, fn ($item) => Carbon::parse($item->purchase_date), fn () => 1, $from, $to, 'Purchase Orders', true),
                'purchase_order_status' => $this->donut($poStatus),
                'top_vendors' => ['labels' => $topVendors->pluck('label')->all(), 'series' => [['name' => 'Purchase Value', 'data' => $topVendors->pluck('amount')->all()]]],
                'purchase_order_value' => $this->series($purchaseOrders, fn ($item) => Carbon::parse($item->purchase_date), fn ($item) => (float) $item->po_amount, $from, $to, 'PO Value'),
                'products_by_category' => ['labels' => $productsByCategory->keys()->values()->all(), 'series' => [['name' => 'Products', 'data' => $productsByCategory->values()->all()]]],
                'stock_status' => $this->donut($stockStatus),
                'best_sellers' => ['labels' => $bestSellers->pluck('label')->all(), 'series' => [['name' => 'Units Sold', 'data' => $bestSellers->pluck('quantity')->all()]]],
                'top_product_trend' => $this->topProductTrend($orderItems, $from, $to),
                'serial_status' => $this->donut($serials->groupBy(fn ($item) => ucfirst((string) $item->status))->map->count()->sortKeys()),
                'scrap_trend' => $this->series($scrapItems, fn ($item) => Carbon::parse($item->scrapped_at ?? $item->created_at), fn ($item) => (int) $item->quantity_scrapped, $from, $to, 'Scrapped Qty'),
                'stock_alert_trend' => $this->stockAlertTrend($filters, $from, $to),
                'revenue_trend' => $this->series($orderItems, fn ($item) => Carbon::parse($item->created_at), fn ($item) => (float) $item->line_total, $from, $to, 'Revenue'),
                'revenue_contribution' => $this->donut($revenueByCategory),
            ],
            'lists' => [
                'warehouse_performance' => $warehousePerformance,
                'top_vendors' => $topVendors,
                'low_stock_products' => $products->filter(fn ($item) => $item->stock_status === 'low_stock' || ($item->stock_quantity > 0 && $item->stock_quantity <= self::LOW_STOCK_THRESHOLD))->sortBy('stock_quantity')->take(6)->values()->map(fn ($item) => ['name' => $item->product_name, 'brand' => $item->brand->name ?? 'Unknown', 'category' => $item->parentCategorie->name ?? 'Uncategorised', 'quantity' => (int) $item->stock_quantity, 'warehouse' => $item->warehouse->name ?? 'Unassigned']),
                'out_of_stock_products' => $products->filter(fn ($item) => $item->stock_status === 'out_of_stock' || $item->stock_quantity <= 0)->take(6)->values()->map(fn ($item) => ['name' => $item->product_name, 'brand' => $item->brand->name ?? 'Unknown', 'category' => $item->parentCategorie->name ?? 'Uncategorised', 'quantity' => (int) $item->stock_quantity, 'warehouse' => $item->warehouse->name ?? 'Unassigned']),
                'best_sellers' => $bestSellers,
                'top_revenue_products' => $topRevenueProducts,
                'scrap_by_brand' => $this->metricList($scrapByBrand),
                'scrap_by_category' => $this->metricList($scrapByCategory),
                'low_stock_by_brand' => $this->metricList($lowByBrand),
                'out_of_stock_by_brand' => $this->metricList($outByBrand),
                'products_by_brand' => $this->metricList($productsByBrand),
                'revenue_by_brand' => $this->currencyList($revenueByBrand),
                'revenue_by_category' => $this->currencyList($revenueByCategory),
            ],
        ];
    }

    private function filters(Request $request): array
    {
        return ['date_from' => $request->input('date_from', now()->subDays(29)->toDateString()), 'date_to' => $request->input('date_to', now()->toDateString()), 'warehouse_id' => $this->nullableInt($request->input('warehouse_id')), 'vendor_id' => $this->nullableInt($request->input('vendor_id')), 'category_id' => $this->nullableInt($request->input('category_id')), 'subcategory_id' => $this->nullableInt($request->input('subcategory_id')), 'brand_id' => $this->nullableInt($request->input('brand_id')), 'order_status' => $this->nullableString($request->input('order_status')), 'payment_method' => $this->nullableString($request->input('payment_method')), 'review_status' => $this->nullableString($request->input('review_status')), 'customer_type' => $this->nullableString($request->input('customer_type'))];
    }

    private function periods(array $filters): array
    {
        $from = Carbon::parse($filters['date_from'])->startOfDay();
        $to = Carbon::parse($filters['date_to'])->endOfDay();
        if ($to->lt($from)) { [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()]; }
        $days = $from->diffInDays($to) + 1; $previousTo = $from->copy()->subDay()->endOfDay(); $previousFrom = $previousTo->copy()->subDays($days - 1)->startOfDay();
        return [$from, $to, $previousFrom, $previousTo];
    }

    private function options(): array
    {
        return ['warehouses' => Warehouse::orderBy('name')->get(['id', 'name']), 'vendors' => Vendor::orderBy('first_name')->get(['id', 'first_name', 'last_name']), 'categories' => ParentCategory::orderBy('name')->get(['id', 'name']), 'subcategories' => SubCategory::orderBy('name')->get(['id', 'parent_category_id', 'name']), 'brands' => Brand::orderBy('name')->get(['id', 'name']), 'order_statuses' => ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'returned' => 'Returned'], 'payment_methods' => ['online' => 'Online', 'cod' => 'COD', 'cheque' => 'Cheque', 'bank_transfer' => 'Bank Transfer'], 'review_statuses' => ['active' => 'Active', 'inactive' => 'Inactive'], 'customer_types' => Customer::select('customer_type')->whereNotNull('customer_type')->distinct()->pluck('customer_type', 'customer_type')->mapWithKeys(fn ($value, $key) => [$key => ucfirst(str_replace('_', ' ', $value))])->all()];
    }

    private function productQuery(array $filters): Builder
    {
        $query = Product::query()->whereNull('products.deleted_at'); $this->applyProductFilters($query, $filters); return $query;
    }
    private function warehouseQuery(array $filters): Builder
    {
        return Warehouse::query()->whereNull('warehouses.deleted_at')->when($filters['warehouse_id'], fn ($query) => $query->where('warehouses.id', $filters['warehouse_id']))->when($filters['vendor_id'] || $filters['category_id'] || $filters['subcategory_id'] || $filters['brand_id'], function ($query) use ($filters) { $query->whereHas('products', function (Builder $builder) use ($filters) { $this->applyProductFilters($builder, $filters); }); });
    }
    private function rackQuery(array $filters): Builder
    {
        return WarehouseRack::query()->join('warehouses', 'warehouses.id', '=', 'warehouse_racks.warehouse_id')->whereNull('warehouse_racks.deleted_at')->whereNull('warehouses.deleted_at')->when($filters['warehouse_id'], fn ($query) => $query->where('warehouse_racks.warehouse_id', $filters['warehouse_id']));
    }
    private function purchaseOrderQuery(array $filters, Carbon $from, Carbon $to): Builder
    {
        return VendorPurchaseOrder::query()->whereNull('vendor_purchase_orders.deleted_at')->whereBetween('vendor_purchase_orders.purchase_date', [$from->toDateString(), $to->toDateString()])->when($filters['vendor_id'], fn ($query) => $query->where('vendor_purchase_orders.vendor_id', $filters['vendor_id']))->when(in_array($filters['order_status'], ['pending', 'approved', 'rejected', 'cancelled'], true), fn ($query) => $query->where('vendor_purchase_orders.po_status', $filters['order_status']))->when($filters['warehouse_id'] || $filters['category_id'] || $filters['subcategory_id'] || $filters['brand_id'], function ($query) use ($filters) { $query->whereHas('products', function (Builder $builder) use ($filters) { $this->applyProductFilters($builder, $filters); }); });
    }
    private function scrapQuery(array $filters, Carbon $from, Carbon $to): Builder
    {
        return ScrapItem::query()->whereNull('scrap_items.deleted_at')->whereBetween(DB::raw('DATE(COALESCE(scrapped_at, created_at))'), [$from->toDateString(), $to->toDateString()])->whereHas('product', function (Builder $builder) use ($filters) { $this->applyProductFilters($builder, $filters); });
    }
    private function serialQuery(array $filters): Builder
    {
        $query = ProductSerial::query()->join('products', 'products.id', '=', 'product_serials.product_id')->whereNull('product_serials.deleted_at')->whereNull('products.deleted_at'); $this->applyProductFilters($query, $filters, 'products'); return $query->select('product_serials.*');
    }
    private function orderItemQuery(array $filters, Carbon $from, Carbon $to): Builder
    {
        $query = OrderItem::query()->join('orders', 'orders.id', '=', 'order_items.order_id')->join('products', 'products.id', '=', 'order_items.product_id')->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')->whereNull('order_items.deleted_at')->whereNull('orders.deleted_at')->whereNull('products.deleted_at')->whereBetween('orders.created_at', [$from, $to])->where('order_items.item_status', '!=', 'cancelled'); $this->applyProductFilters($query, $filters, 'products'); if (in_array($filters['order_status'], ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'], true)) { $query->where('orders.order_status', $filters['order_status']); } if ($filters['payment_method']) { $query->whereExists(function ($sub) use ($filters) { $sub->select(DB::raw(1))->from('order_payments')->whereColumn('order_payments.order_id', 'orders.id')->whereNull('order_payments.deleted_at')->where('order_payments.payment_method', $filters['payment_method']); }); } if ($filters['customer_type']) { $query->where('customers.customer_type', $filters['customer_type']); } return $query;
    }
    private function feedbackQuery(array $filters, Carbon $from, Carbon $to): Builder
    {
        $query = OrderFeedback::query()->join('ecommerce_products', 'ecommerce_products.id', '=', 'order_feedback.product_id')->join('products', 'products.id', '=', 'ecommerce_products.product_id')->join('orders', 'orders.id', '=', 'order_feedback.order_id')->leftJoin('customers', 'customers.id', '=', 'order_feedback.customer_id')->whereNull('order_feedback.deleted_at')->whereNull('ecommerce_products.deleted_at')->whereNull('products.deleted_at')->whereNull('orders.deleted_at')->whereBetween('order_feedback.created_at', [$from, $to]); $this->applyProductFilters($query, $filters, 'products'); if ($filters['review_status']) { $query->where('order_feedback.status', $filters['review_status']); } if ($filters['customer_type']) { $query->where('customers.customer_type', $filters['customer_type']); } return $query;
    }
    private function applyProductFilters($query, array $filters, string $table = 'products'): void
    {
        if ($filters['warehouse_id']) { $query->where("{$table}.warehouse_id", $filters['warehouse_id']); }
        if ($filters['vendor_id']) { $query->where("{$table}.vendor_id", $filters['vendor_id']); }
        if ($filters['category_id']) { $query->where("{$table}.parent_category_id", $filters['category_id']); }
        if ($filters['subcategory_id']) { $query->where("{$table}.sub_category_id", $filters['subcategory_id']); }
        if ($filters['brand_id']) { $query->where("{$table}.brand_id", $filters['brand_id']); }
    }
    private function paymentMix(array $filters, Carbon $from, Carbon $to): Collection
    {
        $query = OrderPayment::query()->join('orders', 'orders.id', '=', 'order_payments.order_id')->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('products', 'products.id', '=', 'order_items.product_id')->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')->whereNull('order_payments.deleted_at')->whereNull('orders.deleted_at')->whereNull('order_items.deleted_at')->whereNull('products.deleted_at')->whereBetween('orders.created_at', [$from, $to]); $this->applyProductFilters($query, $filters, 'products'); if ($filters['customer_type']) { $query->where('customers.customer_type', $filters['customer_type']); } if ($filters['payment_method']) { $query->where('order_payments.payment_method', $filters['payment_method']); } return $query->select('order_payments.payment_method', DB::raw('SUM(order_payments.amount) as total_amount'))->groupBy('order_payments.payment_method')->get()->mapWithKeys(fn ($row) => [$row->payment_method => round((float) $row->total_amount, 2)]);
    }
    private function customerMix(array $filters, Carbon $from, Carbon $to): Collection
    {
        $query = Order::query()->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('products', 'products.id', '=', 'order_items.product_id')->join('customers', 'customers.id', '=', 'orders.customer_id')->whereNull('orders.deleted_at')->whereNull('order_items.deleted_at')->whereNull('products.deleted_at')->whereBetween('orders.created_at', [$from, $to]); $this->applyProductFilters($query, $filters, 'products'); if ($filters['payment_method']) { $query->whereExists(function ($sub) use ($filters) { $sub->select(DB::raw(1))->from('order_payments')->whereColumn('order_payments.order_id', 'orders.id')->whereNull('order_payments.deleted_at')->where('order_payments.payment_method', $filters['payment_method']); }); } if (in_array($filters['order_status'], ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'], true)) { $query->where('orders.order_status', $filters['order_status']); } if ($filters['customer_type']) { $query->where('customers.customer_type', $filters['customer_type']); } $rows = $query->select('customers.id', 'customers.customer_type', DB::raw('COUNT(DISTINCT orders.id) as orders_count'))->groupBy('customers.id', 'customers.customer_type')->get(); return collect(['new' => $rows->filter(fn ($row) => (int) $row->orders_count === 1)->count(), 'returning' => $rows->filter(fn ($row) => (int) $row->orders_count > 1)->count(), 'segments' => $rows->groupBy('customer_type')->map->count()]);
    }
    private function trend(float|int $current, float|int $previous): array
    {
        $current = (float) $current; $previous = (float) $previous; $delta = $current - $previous; $percentage = $previous == 0.0 ? ($current > 0 ? 100.0 : 0.0) : round(($delta / $previous) * 100, 1); return ['current' => $current, 'previous' => $previous, 'delta' => round($delta, 2), 'percentage' => $percentage, 'direction' => $delta >= 0 ? 'up' : 'down'];
    }
    private function buckets(Carbon $from, Carbon $to): array
    {
        $days = $from->diffInDays($to) + 1; $keys = []; $labels = []; if ($days <= 45) { $cursor = $from->copy()->startOfDay(); while ($cursor->lte($to)) { $keys[] = $cursor->format('Y-m-d'); $labels[] = $cursor->format('d M'); $cursor->addDay(); } return ['keys' => $keys, 'labels' => $labels, 'format' => fn (Carbon $date) => $date->format('Y-m-d')]; } $cursor = $from->copy()->startOfMonth(); $limit = $to->copy()->startOfMonth(); while ($cursor->lte($limit)) { $keys[] = $cursor->format('Y-m'); $labels[] = $cursor->format('M Y'); $cursor->addMonth(); } return ['keys' => $keys, 'labels' => $labels, 'format' => fn (Carbon $date) => $date->format('Y-m')];
    }
    private function series(Collection $rows, callable $dateResolver, callable $valueResolver, Carbon $from, Carbon $to, string $name, bool $count = false): array
    {
        $bucket = $this->buckets($from, $to); $data = collect($bucket['keys'])->mapWithKeys(fn ($key) => [$key => 0]); foreach ($rows as $row) { $date = $dateResolver($row); $date = $date instanceof Carbon ? $date : Carbon::parse($date); $key = $bucket['format']($date); if ($data->has($key)) { $data[$key] = round($data[$key] + ($count ? 1 : $valueResolver($row)), 2); } } return ['labels' => $bucket['labels'], 'series' => [['name' => $name, 'data' => $data->values()->all()]]];
    }
    private function topProductTrend(Collection $rows, Carbon $from, Carbon $to): array
    {
        $top = $rows->groupBy('product_id')->map(fn ($group) => ['name' => $group->first()->product_name, 'revenue' => (float) $group->sum('line_total'), 'rows' => $group])->sortByDesc('revenue')->take(3)->values(); $labels = $this->buckets($from, $to)['labels']; $series = $top->map(fn ($item) => ['name' => $item['name'], 'data' => $this->series($item['rows'], fn ($row) => Carbon::parse($row->created_at), fn ($row) => (float) $row->line_total, $from, $to, $item['name'])['series'][0]['data']])->values()->all(); return ['labels' => $labels, 'series' => $series];
    }
    private function stockAlertTrend(array $filters, Carbon $from, Carbon $to): array
    {
        $products = $this->productQuery($filters)->whereBetween('products.updated_at', [$from, $to])->get(['products.updated_at', 'products.stock_status', 'products.stock_quantity']); $low = $this->series($products->filter(fn ($item) => $item->stock_status === 'low_stock' || ($item->stock_quantity > 0 && $item->stock_quantity <= self::LOW_STOCK_THRESHOLD)), fn ($row) => Carbon::parse($row->updated_at), fn () => 1, $from, $to, 'Low Stock', true); $out = $this->series($products->filter(fn ($item) => $item->stock_status === 'out_of_stock' || $item->stock_quantity <= 0), fn ($row) => Carbon::parse($row->updated_at), fn () => 1, $from, $to, 'Out of Stock', true); return ['labels' => $low['labels'], 'series' => [['name' => 'Low Stock', 'data' => $low['series'][0]['data']], ['name' => 'Out of Stock', 'data' => $out['series'][0]['data']]]];
    }
    private function donut(Collection $values): array { return ['labels' => $values->keys()->values()->all(), 'series' => $values->values()->map(fn ($value) => round((float) $value, 2))->all()]; }
    private function metricList(Collection $values): Collection { return $values->map(fn ($value, $label) => ['label' => $label, 'value' => (float) $value])->values(); }
    private function currencyList(Collection $values): Collection { return $values->map(fn ($value, $label) => ['label' => $label, 'value' => round((float) $value, 2), 'type' => 'currency'])->values(); }
    private function assumptions(): array { return ['Low stock alerts use a threshold of 10 units because the schema does not store per-product reorder levels.', 'Revenue analytics come from warehouse-linked ecommerce order items, so payment, review, and customer filters only affect datasets connected to orders.', 'Warranty claims and dedicated turnover logs are not available in the warehouse schema, so the dashboard uses return rate and revenue-to-inventory value as proxies.']; }
    private function nullableInt(mixed $value): ?int { return ($value === null || $value === '' || $value === 'all') ? null : (int) $value; }
    private function nullableString(mixed $value): ?string { return ($value === null || $value === '' || $value === 'all') ? null : (string) $value; }
}

