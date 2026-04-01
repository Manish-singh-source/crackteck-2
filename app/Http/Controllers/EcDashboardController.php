<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderFeedback;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\ParentCategory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariantAttribute;
use App\Models\ProductVariantAttributeValue;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EcDashboardController extends Controller
{
    private ?string $resolvedOrderStatusColumn = null;

    public function index(Request $request)
    {
        $filters = $this->resolveFilters($request);
        $data = $this->buildDashboardData($filters);

        return view('e-commerce.index', [
            'data' => $data,
            'filters' => array_merge($filters, [
                'categories' => ParentCategory::where('status', 'active')->orderBy('name')->get(['id', 'name']),
                'subCategories' => SubCategory::where('status', 'active')->orderBy('name')->get(['id', 'parent_category_id', 'name']),
                'brands' => Brand::where('status', 'active')->orderBy('name')->get(['id', 'name']),
                'orderStatuses' => [
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                    'returned' => 'Returned',
                ],
                'paymentMethods' => OrderPayment::query()
                    ->select('payment_method')
                    ->distinct()
                    ->orderBy('payment_method')
                    ->pluck('payment_method')
                    ->filter()
                    ->values(),
                'reviewStatuses' => [
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ],
                'customerTypes' => [
                    'new' => 'New',
                    'returning' => 'Returning',
                ],
            ]),
        ]);
    }

    public function filter(Request $request)
    {
        return response()->json($this->buildDashboardData($this->resolveFilters($request)));
    }

    private function resolveFilters(Request $request): array
    {
        $preset = $request->string('date_preset')->value() ?: 'last_30_days';
        [$defaultFrom, $defaultTo] = $this->resolveDatePreset($preset);

        $dateFrom = $request->input('date_from', $defaultFrom->toDateString());
        $dateTo = $request->input('date_to', $defaultTo->toDateString());

        $start = Carbon::parse($dateFrom)->startOfDay();
        $end = Carbon::parse($dateTo)->endOfDay();

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        return [
            'date_preset' => $preset,
            'date_from' => $start->toDateString(),
            'date_to' => $end->toDateString(),
            'start' => $start,
            'end' => $end,
            'category_id' => $request->filled('category_id') ? (int) $request->input('category_id') : null,
            'sub_category_id' => $request->filled('sub_category_id') ? (int) $request->input('sub_category_id') : null,
            'brand_id' => $request->filled('brand_id') ? (int) $request->input('brand_id') : null,
            'order_status' => $request->input('order_status') ?: null,
            'payment_method' => $request->input('payment_method') ?: null,
            'review_status' => $request->input('review_status') ?: null,
            'customer_type' => $request->input('customer_type') ?: null,
        ];
    }

    private function resolveDatePreset(string $preset): array
    {
        $today = now();

        return match ($preset) {
            'today' => [$today->copy(), $today->copy()],
            'last_7_days' => [$today->copy()->subDays(6), $today->copy()],
            'this_month' => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
            default => [$today->copy()->subDays(29), $today->copy()],
        };
    }

    private function buildDashboardData(array $filters): array
    {
        return [
            'meta' => [
                'range' => [
                    'from' => $filters['date_from'],
                    'to' => $filters['date_to'],
                    'days' => $filters['start']->diffInDays($filters['end']) + 1,
                    'preset' => $filters['date_preset'],
                ],
                'assumptions' => [
                    'Order sales are joined through order_items.product_id -> products.id, while reviews use order_feedback.product_id -> ecommerce_products.id via ecommerce_products.product_id.',
                    'Processing and shipped dashboard buckets are normalized from the project-specific delivery flow statuses.',
                    'Payment mix prefers order_payments.payment_method and falls back to payments.method only when payment records are missing.',
                ],
            ],
            'summary_cards' => $this->getSummaryCards($filters),
            'sales_analytics' => $this->getSalesAnalytics($filters),
            'order_insights' => $this->getOrderInsights($filters),
            'recent_orders' => $this->getRecentOrders($filters),
            'product_insights' => $this->getProductInsights($filters),
            'category_insights' => $this->getCategoryInsights($filters),
            'brand_insights' => $this->getBrandInsights($filters),
            'variant_insights' => $this->getVariantInsights($filters),
            'customer_insights' => $this->getCustomerInsights($filters),
            'revenue_breakdown' => $this->getRevenueBreakdown($filters),
            'review_insights' => $this->getReviewInsights($filters),
            'inventory_overview' => $this->getInventoryOverview($filters),
            'contact_overview' => $this->getContactOverview($filters),
        ];
    }

    private function getSummaryCards(array $filters): array
    {
        [$previousStart, $previousEnd] = $this->previousPeriod($filters['start'], $filters['end']);

        $currentOrders = $this->orderQuery($filters);
        $previousFilters = array_merge($filters, ['start' => $previousStart, 'end' => $previousEnd]);
        $previousOrders = $this->orderQuery($previousFilters);

        $currentRevenue = (clone $currentOrders)->sum('orders.total_amount');
        $previousRevenue = (clone $previousOrders)->sum('orders.total_amount');
        $currentOrderCount = (clone $currentOrders)->count('orders.id');
        $previousOrderCount = (clone $previousOrders)->count('orders.id');

        $customerCurrent = $this->customerQuery($filters);
        $customerPrevious = $this->customerQuery($previousFilters);

        $newCustomersCurrent = (clone $customerCurrent)->count('customers.id');
        $newCustomersPrevious = (clone $customerPrevious)->count('customers.id');
        $totalCustomers = Customer::count();

        $productCount = (clone $this->productQuery($filters))->count('products.id');
        $pendingOrders = (clone $currentOrders)->whereRaw($this->normalizedStatusCase().' = ?', ['pending'])->count('orders.id');
        $deliveredOrders = (clone $currentOrders)->whereRaw($this->normalizedStatusCase().' = ?', ['delivered'])->count('orders.id');
        $previousDelivered = (clone $previousOrders)->whereRaw($this->normalizedStatusCase().' = ?', ['delivered'])->count('orders.id');

        $trendSeries = $this->buildSparklineSeries($filters, 7);

        return [
            'cards' => [
                $this->summaryCard('revenue', 'Total Revenue', $currentRevenue, 'currency', $this->percentChange($currentRevenue, $previousRevenue), 'fa-solid fa-wallet', $trendSeries['revenue']),
                $this->summaryCard('orders', 'Total Orders', $currentOrderCount, 'number', $this->percentChange($currentOrderCount, $previousOrderCount), 'fa-solid fa-bag-shopping', $trendSeries['orders']),
                $this->summaryCard('customers', 'Total Customers', $totalCustomers, 'number', $this->percentChange($newCustomersCurrent, $newCustomersPrevious), 'fa-solid fa-users', $trendSeries['customers']),
                $this->summaryCard('products', 'Total Products', $productCount, 'number', 0, 'fa-solid fa-box-open', $trendSeries['products']),
                $this->summaryCard('pending', 'Pending Orders', $pendingOrders, 'number', 0, 'fa-solid fa-hourglass-half', $trendSeries['pending']),
                $this->summaryCard('delivered', 'Delivered Orders', $deliveredOrders, 'number', $this->percentChange($deliveredOrders, $previousDelivered), 'fa-solid fa-truck-fast', $trendSeries['delivered']),
            ],
        ];
    }

    private function summaryCard(string $key, string $label, float|int $value, string $format, float $change, string $icon, array $trend): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'value' => $value,
            'format' => $format,
            'change' => round($change, 1),
            'direction' => $change >= 0 ? 'up' : 'down',
            'icon' => $icon,
            'trend' => $trend,
        ];
    }

    private function getSalesAnalytics(array $filters): array
    {
        $currentSeries = $this->buildDailySalesSeries($filters['start'], $filters['end'], $filters);
        [$previousStart, $previousEnd] = $this->previousPeriod($filters['start'], $filters['end']);
        $previousSeries = $this->buildDailySalesSeries($previousStart, $previousEnd, array_merge($filters, [
            'start' => $previousStart,
            'end' => $previousEnd,
        ]));

        $currentRevenue = array_sum($currentSeries['revenue']);
        $previousRevenue = array_sum($previousSeries['revenue']);
        $currentOrders = array_sum($currentSeries['orders']);
        $previousOrders = array_sum($previousSeries['orders']);

        return [
            'labels' => $currentSeries['labels'],
            'revenue_series' => $currentSeries['revenue'],
            'orders_series' => $currentSeries['orders'],
            'previous_revenue_series' => $previousSeries['revenue'],
            'previous_orders_series' => $previousSeries['orders'],
            'overview' => [
                'revenue' => $currentRevenue,
                'orders' => $currentOrders,
                'avg_order_value' => $currentOrders > 0 ? round($currentRevenue / $currentOrders, 2) : 0,
                'avg_daily_revenue' => count($currentSeries['revenue']) > 0 ? round($currentRevenue / count($currentSeries['revenue']), 2) : 0,
                'revenue_change' => $this->percentChange($currentRevenue, $previousRevenue),
                'order_change' => $this->percentChange($currentOrders, $previousOrders),
            ],
            'comparison_tiles' => [
                $this->periodTile('Today', $this->rangeTotals(now()->startOfDay(), now()->endOfDay(), $filters)),
                $this->periodTile('Last 7 Days', $this->rangeTotals(now()->subDays(6)->startOfDay(), now()->endOfDay(), $filters)),
                $this->periodTile('Last 30 Days', $this->rangeTotals(now()->subDays(29)->startOfDay(), now()->endOfDay(), $filters)),
                $this->periodTile('This Month', $this->rangeTotals(now()->startOfMonth(), now()->endOfMonth(), $filters)),
            ],
        ];
    }

    private function periodTile(string $label, array $totals): array
    {
        return [
            'label' => $label,
            'revenue' => $totals['revenue'],
            'orders' => $totals['orders'],
            'change' => $totals['change'],
        ];
    }

    private function rangeTotals(Carbon $start, Carbon $end, array $filters): array
    {
        $periodFilters = array_merge($filters, ['start' => $start, 'end' => $end]);
        [$previousStart, $previousEnd] = $this->previousPeriod($start, $end);
        $previousFilters = array_merge($filters, ['start' => $previousStart, 'end' => $previousEnd]);

        $currentRevenue = (clone $this->orderQuery($periodFilters))->sum('orders.total_amount');
        $previousRevenue = (clone $this->orderQuery($previousFilters))->sum('orders.total_amount');
        $currentOrders = (clone $this->orderQuery($periodFilters))->count('orders.id');

        return [
            'revenue' => $currentRevenue,
            'orders' => $currentOrders,
            'change' => $this->percentChange($currentRevenue, $previousRevenue),
        ];
    }

    private function getOrderInsights(array $filters): array
    {
        $orders = $this->orderQuery($filters);

        $statusRaw = (clone $orders)
            ->selectRaw($this->normalizedStatusCase().' as normalized_status, COUNT(*) as total')
            ->groupBy('normalized_status')
            ->pluck('total', 'normalized_status');

        $distribution = collect(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'])
            ->mapWithKeys(fn ($status) => [$status => (int) ($statusRaw[$status] ?? 0)])
            ->all();

        $baseOrders = clone $orders;
        $deliveredOrders = (clone $orders)->whereRaw($this->normalizedStatusCase().' = ?', ['delivered']);
        $deliveredWithTiming = (clone $deliveredOrders)
            ->whereNotNull('orders.delivered_at')
            ->whereNotNull('orders.created_at')
            ->get(['orders.created_at', 'orders.delivered_at']);

        $avgDeliveryHours = $deliveredWithTiming->count() > 0
            ? round($deliveredWithTiming->avg(fn ($order) => Carbon::parse($order->created_at)->diffInHours(Carbon::parse($order->delivered_at))), 1)
            : 0;

        $highestOrder = (clone $baseOrders)->max('orders.total_amount') ?? 0;
        $lowestOrder = (clone $baseOrders)->where('orders.total_amount', '>', 0)->min('orders.total_amount') ?? 0;
        $totalOrders = (clone $baseOrders)->count('orders.id');
        $totalItemsSold = (clone $baseOrders)->join('order_items', 'orders.id', '=', 'order_items.order_id')->sum('order_items.quantity');
        $deliveryRate = $totalOrders > 0 ? round((($distribution['delivered'] ?? 0) / $totalOrders) * 100, 1) : 0;

        return [
            'status_distribution' => $distribution,
            'average_order_value' => round((clone $baseOrders)->avg('orders.total_amount') ?? 0, 2),
            'total_items_sold' => (int) $totalItemsSold,
            'highest_order_value' => $highestOrder,
            'lowest_order_value' => $lowestOrder,
            'delivery_performance' => [
                'delivery_rate' => $deliveryRate,
                'cancelled_orders' => $distribution['cancelled'] ?? 0,
                'returned_orders' => $distribution['returned'] ?? 0,
                'avg_delivery_hours' => $avgDeliveryHours,
            ],
        ];
    }

    private function getRecentOrders(array $filters): array
    {
        $orders = $this->orderQuery($filters)
            ->with(['customer:id,first_name,last_name', 'orderPayments:id,order_id,payment_method,status'])
            ->withCount('orderItems')
            ->latest('orders.created_at')
            ->take(6)
            ->get([
                'orders.id',
                'orders.customer_id',
                'orders.order_number',
                'orders.total_amount',
                'orders.created_at',
                'orders.status',
                'orders.order_status',
                'orders.total_items',
            ]);

        return $orders->map(function (Order $order) {
            $payment = $order->orderPayments->sortByDesc('id')->first();

            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => trim(($order->customer?->first_name ?? '').' '.($order->customer?->last_name ?? '')) ?: 'Guest Customer',
                'product_count' => $order->order_items_count ?: $order->total_items,
                'amount' => (float) $order->total_amount,
                'payment_type' => $payment?->payment_method ?? 'unpaid',
                'status' => $this->normalizeStatusValue($order->status ?? $order->order_status),
                'date' => optional($order->created_at)->format('d M Y, h:i A'),
                'view_url' => route('order.view', $order->id),
            ];
        })->all();
    }

    private function getProductInsights(array $filters): array
    {
        $productSales = $this->productSalesQuery($filters)->get();
        $productIds = $productSales->pluck('product_id')->filter()->values();
        $reviewStats = $this->reviewProductStats()->keyBy('warehouse_product_id');

        $products = Product::with(['brand:id,name', 'parentCategorie:id,name', 'subCategorie:id,name', 'ecommerceProduct:id,product_id'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $topSelling = $productSales->sortByDesc('quantity_sold')->take(5)->map(function ($row) use ($products, $reviewStats) {
            $product = $products->get($row->product_id);
            $review = $reviewStats->get($row->product_id);

            return $this->productCardPayload($product, $row, $review);
        })->values();

        $worstPerforming = Product::with(['brand:id,name', 'parentCategorie:id,name', 'ecommerceProduct:id,product_id'])
            ->when($filters['category_id'], fn ($query) => $query->where('parent_category_id', $filters['category_id']))
            ->when($filters['sub_category_id'], fn ($query) => $query->where('sub_category_id', $filters['sub_category_id']))
            ->when($filters['brand_id'], fn ($query) => $query->where('brand_id', $filters['brand_id']))
            ->leftJoinSub($this->productSalesQuery($filters), 'sales', fn ($join) => $join->on('products.id', '=', 'sales.product_id'))
            ->select('products.*', DB::raw('COALESCE(sales.quantity_sold, 0) as quantity_sold'), DB::raw('COALESCE(sales.revenue, 0) as revenue'))
            ->orderBy('quantity_sold')
            ->take(5)
            ->get()
            ->map(function (Product $product) use ($reviewStats) {
                $review = $reviewStats->get($product->id);

                return $this->productCardPayload($product, (object) [
                    'quantity_sold' => $product->quantity_sold,
                    'revenue' => $product->revenue,
                ], $review);
            });

        $mostReviewed = $reviewStats->sortByDesc('review_count')->take(5)->map(function ($review) {
            $product = Product::with(['brand:id,name', 'parentCategorie:id,name'])
                ->find($review->warehouse_product_id);

            return $this->productCardPayload($product, (object) [
                'quantity_sold' => $review->quantity_sold ?? 0,
                'revenue' => $review->revenue ?? 0,
            ], $review);
        })->values();

        return [
            'top_selling' => $topSelling,
            'worst_performing' => $worstPerforming,
            'most_reviewed' => $mostReviewed,
        ];
    }

    private function productCardPayload(?Product $product, object $sales, ?object $review): array
    {
        return [
            'id' => $product?->id,
            'name' => $product?->product_name ?? 'Unknown Product',
            'image' => $product?->main_product_image,
            'quantity_sold' => (int) ($sales->quantity_sold ?? 0),
            'revenue' => (float) ($sales->revenue ?? 0),
            'rating' => round((float) ($review->avg_rating ?? 0), 1),
            'review_count' => (int) ($review->review_count ?? 0),
            'stock_quantity' => (int) ($product?->stock_quantity ?? 0),
            'stock_status' => $product?->stock_status ?? 'unknown',
            'brand' => $product?->brand?->name ?? 'Unassigned',
            'category' => $product?->parentCategorie?->name ?? 'Unassigned',
            'subcategory' => $product?->subCategorie?->name ?? null,
            'price' => (float) ($product?->final_price ?? $product?->selling_price ?? 0),
        ];
    }

    private function getCategoryInsights(array $filters): array
    {
        $totalParent = ParentCategory::count();
        $totalSub = SubCategory::count();

        $productCountByCategory = Product::query()
            ->select('parent_category_id', DB::raw('COUNT(*) as total_products'))
            ->when($filters['brand_id'], fn ($query) => $query->where('brand_id', $filters['brand_id']))
            ->groupBy('parent_category_id')
            ->get()
            ->keyBy('parent_category_id');

        $sales = DB::query()
            ->fromSub($this->productSalesQuery($filters), 'product_sales')
            ->join('products as category_products', 'product_sales.product_id', '=', 'category_products.id')
            ->join('parent_categories', 'category_products.parent_category_id', '=', 'parent_categories.id')
            ->select(
                'parent_categories.id',
                'parent_categories.name',
                DB::raw('SUM(product_sales.revenue) as revenue'),
                DB::raw('SUM(product_sales.quantity_sold) as quantity_sold')
            )
            ->groupBy('parent_categories.id', 'parent_categories.name')
            ->orderByDesc('revenue')
            ->get();

        $totalRevenue = $sales->sum('revenue');
        $categorySales = $sales->map(function ($row) use ($productCountByCategory, $totalRevenue) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'products' => (int) ($productCountByCategory[$row->id]->total_products ?? 0),
                'revenue' => (float) $row->revenue,
                'quantity_sold' => (int) $row->quantity_sold,
                'contribution' => $totalRevenue > 0 ? round(($row->revenue / $totalRevenue) * 100, 1) : 0,
            ];
        })->values();

        $subCategorySales = DB::query()
            ->fromSub($this->productSalesQuery($filters), 'product_sales')
            ->join('products as sub_products', 'product_sales.product_id', '=', 'sub_products.id')
            ->join('sub_categories', 'sub_products.sub_category_id', '=', 'sub_categories.id')
            ->select(
                'sub_categories.id',
                'sub_categories.name',
                DB::raw('SUM(product_sales.revenue) as revenue')
            )
            ->groupBy('sub_categories.id', 'sub_categories.name')
            ->orderByDesc('revenue')
            ->take(6)
            ->get()
            ->map(fn ($row) => [
                'id' => $row->id,
                'name' => $row->name,
                'revenue' => (float) $row->revenue,
            ]);

        return [
            'total_parent_categories' => $totalParent,
            'total_sub_categories' => $totalSub,
            'best_category' => $categorySales->first(),
            'best_subcategory' => $subCategorySales->first(),
            'category_sales' => $categorySales->take(8),
            'subcategory_sales' => $subCategorySales,
        ];
    }

    private function getBrandInsights(array $filters): array
    {
        $brandSales = DB::query()
            ->fromSub($this->productSalesQuery($filters), 'product_sales')
            ->join('products as brand_products', 'product_sales.product_id', '=', 'brand_products.id')
            ->join('brands', 'brand_products.brand_id', '=', 'brands.id')
            ->select(
                'brands.id',
                'brands.name',
                DB::raw('COUNT(DISTINCT brand_products.id) as product_count'),
                DB::raw('SUM(product_sales.revenue) as revenue'),
                DB::raw('SUM(product_sales.quantity_sold) as quantity_sold')
            )
            ->groupBy('brands.id', 'brands.name')
            ->orderByDesc('revenue')
            ->get();

        $totalRevenue = $brandSales->sum('revenue');
        $brandPayload = $brandSales->map(fn ($row) => [
            'id' => $row->id,
            'name' => $row->name,
            'product_count' => (int) $row->product_count,
            'revenue' => (float) $row->revenue,
            'quantity_sold' => (int) $row->quantity_sold,
            'contribution' => $totalRevenue > 0 ? round(($row->revenue / $totalRevenue) * 100, 1) : 0,
        ])->values();

        $leastActive = Brand::query()
            ->withCount('products')
            ->when($filters['category_id'], function ($query) use ($filters) {
                $query->whereHas('products', fn ($productQuery) => $productQuery->where('parent_category_id', $filters['category_id']));
            })
            ->orderBy('products_count')
            ->first();

        return [
            'total_brands' => Brand::count(),
            'brands' => $brandPayload->take(8),
            'top_performing' => $brandPayload->first(),
            'most_ordered' => $brandPayload->sortByDesc('quantity_sold')->first(),
            'least_active' => $leastActive ? [
                'name' => $leastActive->name,
                'product_count' => (int) $leastActive->products_count,
            ] : null,
        ];
    }

    private function getVariantInsights(array $filters): array
    {
        $attributes = ProductVariantAttribute::withCount('values')->orderByDesc('values_count')->get(['id', 'name']);
        $values = ProductVariantAttributeValue::with('attribute:id,name')->get(['id', 'attribute_id', 'value']);

        $products = $this->productQuery($filters)
            ->whereNotNull('products.variation_options')
            ->get(['products.id', 'products.variation_options']);

        $attributeUsage = [];
        $valueUsage = [];
        $combinationUsage = [];

        foreach ($products as $product) {
            $variations = $product->variation_options;
            if (! is_array($variations) || $variations === []) {
                continue;
            }

            $comboParts = [];
            foreach ($variations as $attributeId => $valueIds) {
                $attributeId = (int) $attributeId;
                $valueIds = array_values(array_filter((array) $valueIds));

                $attributeUsage[$attributeId] = ($attributeUsage[$attributeId] ?? 0) + 1;
                $attribute = $attributes->firstWhere('id', $attributeId);
                $valueLabels = [];

                foreach ($valueIds as $valueId) {
                    $valueId = (int) $valueId;
                    $value = $values->firstWhere('id', $valueId);
                    if (! $value) {
                        continue;
                    }

                    $valueUsage[$valueId] = ($valueUsage[$valueId] ?? 0) + 1;
                    $valueLabels[] = $value->value;
                }

                if ($attribute && $valueLabels !== []) {
                    $comboParts[] = $attribute->name.': '.implode(', ', $valueLabels);
                }
            }

            if ($comboParts !== []) {
                sort($comboParts);
                $comboKey = implode(' | ', $comboParts);
                $combinationUsage[$comboKey] = ($combinationUsage[$comboKey] ?? 0) + 1;
            }
        }

        $attributePayload = collect($attributeUsage)
            ->map(function ($usage, $attributeId) use ($attributes) {
                $attribute = $attributes->firstWhere('id', (int) $attributeId);

                return [
                    'id' => (int) $attributeId,
                    'name' => $attribute?->name ?? 'Unknown',
                    'usage' => (int) $usage,
                    'value_count' => (int) ($attribute?->values_count ?? 0),
                ];
            })
            ->sortByDesc('usage')
            ->values()
            ->take(6);

        $valuePayload = collect($valueUsage)
            ->map(function ($usage, $valueId) use ($values) {
                $value = $values->firstWhere('id', (int) $valueId);

                return [
                    'id' => (int) $valueId,
                    'value' => $value?->value ?? 'Unknown',
                    'attribute' => $value?->attribute?->name ?? 'Unknown',
                    'usage' => (int) $usage,
                ];
            })
            ->sortByDesc('usage')
            ->values()
            ->take(8);

        arsort($combinationUsage);
        $topCombination = array_key_first($combinationUsage);

        return [
            'total_attributes' => ProductVariantAttribute::count(),
            'total_attribute_values' => ProductVariantAttributeValue::count(),
            'most_used_attributes' => $attributePayload,
            'most_used_values' => $valuePayload,
            'products_with_variants' => $products->count(),
            'catalog_coverage' => Product::count() > 0 ? round(($products->count() / Product::count()) * 100, 1) : 0,
            'top_combination' => $topCombination ? [
                'label' => $topCombination,
                'usage' => $combinationUsage[$topCombination],
            ] : null,
        ];
    }

    private function getCustomerInsights(array $filters): array
    {
        $allCustomers = Customer::count();
        $newCustomers = (clone $this->customerQuery($filters))->count('customers.id');
        $returningCustomers = $this->returningCustomerIds()->count();
        $growthStart = $filters['start']->copy()->subDays(29);
        $growthSeries = $this->customerGrowthSeries($growthStart, $filters['end']);

        $topByOrders = Customer::query()
            ->leftJoin('orders', 'customers.id', '=', 'orders.customer_id')
            ->select(
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'customers.email',
                'customers.phone',
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy('customers.id', 'customers.first_name', 'customers.last_name', 'customers.email', 'customers.phone')
            ->orderByDesc('order_count')
            ->take(5)
            ->get()
            ->map(fn ($customer) => [
                'id' => $customer->id,
                'name' => trim($customer->first_name.' '.$customer->last_name),
                'email' => $customer->email,
                'phone' => $customer->phone,
                'order_count' => (int) $customer->order_count,
            ]);

        $topBySpend = Customer::query()
            ->leftJoin('orders', 'customers.id', '=', 'orders.customer_id')
            ->select(
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'customers.email',
                DB::raw('COALESCE(SUM(orders.total_amount), 0) as total_spend')
            )
            ->groupBy('customers.id', 'customers.first_name', 'customers.last_name', 'customers.email')
            ->orderByDesc('total_spend')
            ->take(5)
            ->get()
            ->map(fn ($customer) => [
                'id' => $customer->id,
                'name' => trim($customer->first_name.' '.$customer->last_name),
                'email' => $customer->email,
                'total_spend' => (float) $customer->total_spend,
            ]);

        $recentlyActive = Customer::query()
            ->whereHas('orders', fn ($query) => $query->whereBetween('created_at', [$filters['start'], $filters['end']]))
            ->with(['orders' => fn ($query) => $query->latest()->take(1)])
            ->take(5)
            ->get()
            ->map(fn ($customer) => [
                'id' => $customer->id,
                'name' => trim($customer->first_name.' '.$customer->last_name),
                'email' => $customer->email,
                'last_order' => optional($customer->orders->first()?->created_at)->format('d M Y'),
            ]);

        return [
            'total_customers' => $allCustomers,
            'new_customers' => $newCustomers,
            'returning_customers' => $returningCustomers,
            'growth' => $growthSeries,
            'top_by_orders' => $topByOrders,
            'top_by_spend' => $topBySpend,
            'recently_active' => $recentlyActive,
        ];
    }

    private function getRevenueBreakdown(array $filters): array
    {
        $paymentDistribution = OrderPayment::query()
            ->join('orders', 'order_payments.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$filters['start'], $filters['end']])
            ->when($filters['category_id'] || $filters['sub_category_id'] || $filters['brand_id'], function ($query) use ($filters) {
                $query->whereExists(function ($exists) use ($filters) {
                    $exists->selectRaw(1)
                        ->from('order_items')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->whereColumn('order_items.order_id', 'orders.id')
                        ->when($filters['category_id'], fn ($sub) => $sub->where('products.parent_category_id', $filters['category_id']))
                        ->when($filters['sub_category_id'], fn ($sub) => $sub->where('products.sub_category_id', $filters['sub_category_id']))
                        ->when($filters['brand_id'], fn ($sub) => $sub->where('products.brand_id', $filters['brand_id']));
                });
            })
            ->select(
                'order_payments.payment_method',
                DB::raw('COUNT(*) as tx_count'),
                DB::raw('SUM(order_payments.amount) as amount')
            )
            ->groupBy('order_payments.payment_method')
            ->orderByDesc('amount')
            ->get()
            ->map(fn ($payment) => [
                'method' => $payment->payment_method ?: 'unknown',
                'count' => (int) $payment->tx_count,
                'amount' => (float) $payment->amount,
            ]);

        if ($paymentDistribution->isEmpty()) {
            $paymentDistribution = Payment::query()
                ->join('orders', 'payments.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', [$filters['start'], $filters['end']])
                ->select('payments.method', DB::raw('COUNT(*) as tx_count'), DB::raw('SUM(payments.amount) / 100 as amount'))
                ->groupBy('payments.method')
                ->orderByDesc('amount')
                ->get()
                ->map(fn ($payment) => [
                    'method' => $payment->method ?: 'online',
                    'count' => (int) $payment->tx_count,
                    'amount' => (float) $payment->amount,
                ]);
        }

        return [
            'total' => (float) $paymentDistribution->sum('amount'),
            'most_used' => $paymentDistribution->sortByDesc('count')->first(),
            'distribution' => $paymentDistribution->values(),
        ];
    }

    private function getReviewInsights(array $filters): array
    {
        $reviews = OrderFeedback::query()
            ->join('ecommerce_products', 'order_feedback.product_id', '=', 'ecommerce_products.id')
            ->join('products', 'ecommerce_products.product_id', '=', 'products.id')
            ->when($filters['category_id'], fn ($query) => $query->where('products.parent_category_id', $filters['category_id']))
            ->when($filters['sub_category_id'], fn ($query) => $query->where('products.sub_category_id', $filters['sub_category_id']))
            ->when($filters['brand_id'], fn ($query) => $query->where('products.brand_id', $filters['brand_id']))
            ->when($filters['review_status'], fn ($query) => $query->where('order_feedback.status', $filters['review_status']));

        $avgRating = round((clone $reviews)->avg('order_feedback.star') ?? 0, 1);
        $totalReviews = (clone $reviews)->count('order_feedback.id');
        $activeReviews = (clone $reviews)->where('order_feedback.status', 'active')->count('order_feedback.id');
        $inactiveReviews = (clone $reviews)->where('order_feedback.status', 'inactive')->count('order_feedback.id');

        $ratingDistribution = (clone $reviews)
            ->select('order_feedback.star', DB::raw('COUNT(*) as total'))
            ->groupBy('order_feedback.star')
            ->pluck('total', 'order_feedback.star');

        $latest = OrderFeedback::query()
            ->with(['customer:id,first_name,last_name', 'product:id,product_id', 'product.warehouseProduct:id,product_name,main_product_image'])
            ->when($filters['review_status'], fn ($query) => $query->where('status', $filters['review_status']))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($review) => [
                'id' => $review->id,
                'customer_name' => trim(($review->customer?->first_name ?? '').' '.($review->customer?->last_name ?? '')),
                'product_name' => $review->product?->warehouseProduct?->product_name ?? 'Unknown Product',
                'image' => $review->product?->warehouseProduct?->main_product_image,
                'rating' => (int) $review->star,
                'status' => $review->status,
                'feedback' => $review->feedback,
                'date' => optional($review->created_at)->format('d M Y'),
            ]);

        $reviewAgg = OrderFeedback::query()
            ->join('ecommerce_products', 'order_feedback.product_id', '=', 'ecommerce_products.id')
            ->join('products', 'ecommerce_products.product_id', '=', 'products.id')
            ->when($filters['category_id'], fn ($query) => $query->where('products.parent_category_id', $filters['category_id']))
            ->when($filters['sub_category_id'], fn ($query) => $query->where('products.sub_category_id', $filters['sub_category_id']))
            ->when($filters['brand_id'], fn ($query) => $query->where('products.brand_id', $filters['brand_id']))
            ->when($filters['review_status'], fn ($query) => $query->where('order_feedback.status', $filters['review_status']))
            ->select(
                'products.id as product_id',
                'products.product_name',
                DB::raw('AVG(order_feedback.star) as avg_rating'),
                DB::raw('COUNT(order_feedback.id) as review_count')
            )
            ->groupBy('products.id', 'products.product_name')
            ->get();

        return [
            'average_rating' => $avgRating,
            'total_reviews' => $totalReviews,
            'active_reviews' => $activeReviews,
            'inactive_reviews' => $inactiveReviews,
            'rating_distribution' => collect([5, 4, 3, 2, 1])->map(fn ($star) => [
                'star' => $star,
                'count' => (int) ($ratingDistribution[$star] ?? 0),
            ]),
            'most_reviewed' => $reviewAgg->sortByDesc('review_count')->take(5)->values()->map(fn ($row) => [
                'product_name' => $row->product_name,
                'review_count' => (int) $row->review_count,
                'rating' => round((float) $row->avg_rating, 1),
            ]),
            'best_rated' => $reviewAgg->sortByDesc('avg_rating')->take(5)->values()->map(fn ($row) => [
                'product_name' => $row->product_name,
                'review_count' => (int) $row->review_count,
                'rating' => round((float) $row->avg_rating, 1),
            ]),
            'poor_rated' => $reviewAgg->sortBy('avg_rating')->take(5)->values()->map(fn ($row) => [
                'product_name' => $row->product_name,
                'review_count' => (int) $row->review_count,
                'rating' => round((float) $row->avg_rating, 1),
            ]),
            'latest_reviews' => $latest,
        ];
    }

    private function getInventoryOverview(array $filters): array
    {
        $products = $this->productQuery($filters);
        $inStock = (clone $products)->where('products.stock_status', 'in_stock')->count('products.id');
        $lowStock = (clone $products)->where('products.stock_status', 'low_stock')->count('products.id');
        $outOfStock = (clone $products)->where('products.stock_status', 'out_of_stock')->count('products.id');
        $totalProducts = (clone $products)->count('products.id');

        $nearingDepletion = (clone $products)
            ->with(['brand:id,name', 'parentCategorie:id,name'])
            ->whereIn('products.stock_status', ['low_stock', 'out_of_stock'])
            ->orderBy('products.stock_quantity')
            ->take(6)
            ->get(['products.*'])
            ->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->product_name,
                'stock_quantity' => (int) $product->stock_quantity,
                'stock_status' => $product->stock_status,
                'brand' => $product->brand?->name ?? 'Unassigned',
                'category' => $product->parentCategorie?->name ?? 'Unassigned',
            ]);

        return [
            'in_stock' => $inStock,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock,
            'distribution' => [
                ['label' => 'In Stock', 'value' => $inStock],
                ['label' => 'Low Stock', 'value' => $lowStock],
                ['label' => 'Out of Stock', 'value' => $outOfStock],
            ],
            'stock_health' => $totalProducts > 0 ? round(($inStock / $totalProducts) * 100, 1) : 0,
            'nearing_depletion' => $nearingDepletion,
        ];
    }

    private function getContactOverview(array $filters): array
    {
        $total = Contact::count();
        $newInRange = Contact::whereBetween('created_at', [$filters['start'], $filters['end']])->count();
        $trendStart = $filters['start']->copy()->subDays(29);
        $trendMap = [];
        $cursor = $trendStart->copy();

        while ($cursor->lte($filters['end'])) {
            $trendMap[$cursor->toDateString()] = [
                'label' => $cursor->format('d M'),
                'count' => 0,
            ];
            $cursor->addDay();
        }

        Contact::query()
            ->selectRaw('DATE(created_at) as contact_date, COUNT(*) as total')
            ->whereBetween('created_at', [$trendStart, $filters['end']])
            ->groupBy('contact_date')
            ->orderBy('contact_date')
            ->get()
            ->each(function ($row) use (&$trendMap) {
                if (isset($trendMap[$row->contact_date])) {
                    $trendMap[$row->contact_date]['count'] = (int) $row->total;
                }
            });

        $latest = Contact::latest()->take(5)->get()->map(fn ($contact) => [
            'id' => $contact->id,
            'name' => trim($contact->first_name.' '.$contact->last_name),
            'email' => $contact->email,
            'phone' => $contact->phone,
            'subject' => $contact->subject,
            'description' => $contact->description,
            'date' => optional($contact->created_at)->format('d M Y'),
        ]);

        return [
            'total_inquiries' => $total,
            'new_inquiries' => $newInRange,
            'recent_inquiries' => $latest,
            'trend' => array_values($trendMap),
            'growth' => $this->percentChange($newInRange, max($total - $newInRange, 0)),
        ];
    }

    private function orderQuery(array $filters): Builder
    {
        return Order::query()
            ->whereBetween('orders.created_at', [$filters['start'], $filters['end']])
            ->when($filters['order_status'], function ($query) use ($filters) {
                $query->whereRaw($this->normalizedStatusCase().' = ?', [$filters['order_status']]);
            })
            ->when($filters['payment_method'], function ($query) use ($filters) {
                $query->where(function ($paymentQuery) use ($filters) {
                    $paymentQuery->whereExists(function ($exists) use ($filters) {
                        $exists->selectRaw(1)
                            ->from('order_payments')
                            ->whereColumn('order_payments.order_id', 'orders.id')
                            ->where('order_payments.payment_method', $filters['payment_method']);
                    })->orWhereExists(function ($exists) use ($filters) {
                        $exists->selectRaw(1)
                            ->from('payments')
                            ->whereColumn('payments.order_id', 'orders.id')
                            ->where('payments.method', $filters['payment_method']);
                    });
                });
            })
            ->when($filters['category_id'] || $filters['sub_category_id'] || $filters['brand_id'], function ($query) use ($filters) {
                $query->whereExists(function ($exists) use ($filters) {
                    $exists->selectRaw(1)
                        ->from('order_items')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->whereColumn('order_items.order_id', 'orders.id')
                        ->when($filters['category_id'], fn ($sub) => $sub->where('products.parent_category_id', $filters['category_id']))
                        ->when($filters['sub_category_id'], fn ($sub) => $sub->where('products.sub_category_id', $filters['sub_category_id']))
                        ->when($filters['brand_id'], fn ($sub) => $sub->where('products.brand_id', $filters['brand_id']));
                });
            })
            ->when($filters['customer_type'], function ($query) use ($filters) {
                $query->whereIn('orders.customer_id', $this->customerSegmentIds($filters['customer_type']));
            });
    }

    private function productQuery(array $filters): Builder
    {
        return Product::query()
            ->when($filters['category_id'], fn ($query) => $query->where('products.parent_category_id', $filters['category_id']))
            ->when($filters['sub_category_id'], fn ($query) => $query->where('products.sub_category_id', $filters['sub_category_id']))
            ->when($filters['brand_id'], fn ($query) => $query->where('products.brand_id', $filters['brand_id']));
    }

    private function customerQuery(array $filters): Builder
    {
        return Customer::query()
            ->whereBetween('customers.created_at', [$filters['start'], $filters['end']])
            ->when($filters['customer_type'], function ($query) use ($filters) {
                if ($filters['customer_type'] === 'new') {
                    $query->whereIn('customers.id', $this->customerSegmentIds('new'));
                }

                if ($filters['customer_type'] === 'returning') {
                    $query->whereIn('customers.id', $this->customerSegmentIds('returning'));
                }
            });
    }

    private function customerSegmentIds(string $segment): Builder
    {
        $operator = $segment === 'returning' ? '>' : '=';
        $count = 1;

        return Order::query()
            ->select('customer_id')
            ->groupBy('customer_id')
            ->havingRaw('COUNT(*) '.$operator.' ?', [$count]);
    }

    private function returningCustomerIds(): Builder
    {
        return $this->customerSegmentIds('returning');
    }

    private function productSalesQuery(array $filters): Builder
    {
        return OrderItem::query()
            ->from('order_items as order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$filters['start'], $filters['end']])
            ->when($filters['category_id'], fn ($query) => $query->where('products.parent_category_id', $filters['category_id']))
            ->when($filters['sub_category_id'], fn ($query) => $query->where('products.sub_category_id', $filters['sub_category_id']))
            ->when($filters['brand_id'], fn ($query) => $query->where('products.brand_id', $filters['brand_id']))
            ->when($filters['order_status'], fn ($query) => $query->whereRaw($this->normalizedStatusCase().' = ?', [$filters['order_status']]))
            ->select(
                'products.id as product_id',
                DB::raw('SUM(order_items.quantity) as quantity_sold'),
                DB::raw('SUM(order_items.line_total) as revenue')
            )
            ->groupBy('products.id');
    }

    private function reviewProductStats(): Collection
    {
        return OrderFeedback::query()
            ->join('ecommerce_products', 'order_feedback.product_id', '=', 'ecommerce_products.id')
            ->join('products', 'ecommerce_products.product_id', '=', 'products.id')
            ->leftJoinSub(
                OrderItem::query()
                    ->select('product_id', DB::raw('SUM(quantity) as quantity_sold'), DB::raw('SUM(line_total) as revenue'))
                    ->groupBy('product_id'),
                'sales',
                fn ($join) => $join->on('products.id', '=', 'sales.product_id')
            )
            ->select(
                'products.id as warehouse_product_id',
                DB::raw('AVG(order_feedback.star) as avg_rating'),
                DB::raw('COUNT(order_feedback.id) as review_count'),
                DB::raw('COALESCE(MAX(sales.quantity_sold), 0) as quantity_sold'),
                DB::raw('COALESCE(MAX(sales.revenue), 0) as revenue')
            )
            ->groupBy('products.id')
            ->get();
    }

    private function buildDailySalesSeries(Carbon $start, Carbon $end, array $filters): array
    {
        $seriesMap = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $seriesMap[$cursor->toDateString()] = [
                'label' => $cursor->format('d M'),
                'revenue' => 0,
                'orders' => 0,
            ];
            $cursor->addDay();
        }

        $query = $this->orderQuery(array_merge($filters, ['start' => $start, 'end' => $end]))
            ->selectRaw('DATE(orders.created_at) as order_date, COUNT(*) as total_orders, SUM(orders.total_amount) as total_revenue')
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get();

        foreach ($query as $row) {
            if (isset($seriesMap[$row->order_date])) {
                $seriesMap[$row->order_date]['revenue'] = (float) $row->total_revenue;
                $seriesMap[$row->order_date]['orders'] = (int) $row->total_orders;
            }
        }

        return [
            'labels' => array_column($seriesMap, 'label'),
            'revenue' => array_column($seriesMap, 'revenue'),
            'orders' => array_column($seriesMap, 'orders'),
        ];
    }

    private function buildSparklineSeries(array $filters, int $days): array
    {
        $start = now()->subDays($days - 1)->startOfDay();
        $end = now()->endOfDay();
        $base = array_merge($filters, ['start' => $start, 'end' => $end]);
        $sales = $this->buildDailySalesSeries($start, $end, $base);

        return [
            'revenue' => $sales['revenue'],
            'orders' => $sales['orders'],
            'customers' => $this->customerGrowthSeries($start, $end)['series'],
            'products' => array_fill(0, $days, (int) Product::count()),
            'pending' => $this->statusSparkline('pending', $start, $end, $base),
            'delivered' => $this->statusSparkline('delivered', $start, $end, $base),
        ];
    }

    private function statusSparkline(string $status, Carbon $start, Carbon $end, array $filters): array
    {
        $seriesMap = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $seriesMap[$cursor->toDateString()] = 0;
            $cursor->addDay();
        }

        $query = $this->orderQuery(array_merge($filters, ['start' => $start, 'end' => $end]))
            ->whereRaw($this->normalizedStatusCase().' = ?', [$status])
            ->selectRaw('DATE(orders.created_at) as order_date, COUNT(*) as total')
            ->groupBy('order_date')
            ->get();

        foreach ($query as $row) {
            if (isset($seriesMap[$row->order_date])) {
                $seriesMap[$row->order_date] = (int) $row->total;
            }
        }

        return array_values($seriesMap);
    }

    private function customerGrowthSeries(Carbon $start, Carbon $end): array
    {
        $seriesMap = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $seriesMap[$cursor->toDateString()] = [
                'label' => $cursor->format('d M'),
                'count' => 0,
            ];
            $cursor->addDay();
        }

        Customer::query()
            ->selectRaw('DATE(created_at) as signup_date, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('signup_date')
            ->orderBy('signup_date')
            ->get()
            ->each(function ($row) use (&$seriesMap) {
                if (isset($seriesMap[$row->signup_date])) {
                    $seriesMap[$row->signup_date]['count'] = (int) $row->total;
                }
            });

        return [
            'labels' => array_column($seriesMap, 'label'),
            'series' => array_column($seriesMap, 'count'),
        ];
    }

    private function previousPeriod(Carbon $start, Carbon $end): array
    {
        $days = $start->diffInDays($end) + 1;
        $previousEnd = $start->copy()->subDay()->endOfDay();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return [$previousStart, $previousEnd];
    }

    private function percentChange(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return (float) $current > 0 ? 100.0 : 0.0;
        }

        return round(((($current - $previous) / $previous) * 100), 1);
    }

    private function normalizedStatusCase(): string
    {
        $statusColumn = $this->resolvedOrderStatusColumn();

        return "CASE
            WHEN {$statusColumn} = 'pending' THEN 'pending'
            WHEN {$statusColumn} IN ('admin_approved', 'assigned_delivery_man', 'order_accepted', 'confirmed', 'processing') THEN 'processing'
            WHEN {$statusColumn} IN ('product_taken', 'shipped') THEN 'shipped'
            WHEN {$statusColumn} = 'delivered' THEN 'delivered'
            WHEN {$statusColumn} = 'cancelled' THEN 'cancelled'
            WHEN {$statusColumn} = 'returned' THEN 'returned'
            ELSE COALESCE({$statusColumn}, 'pending')
        END";
    }

    private function normalizeStatusValue(?string $status): string
    {
        return match ($status) {
            'admin_approved', 'assigned_delivery_man', 'order_accepted', 'confirmed', 'processing' => 'processing',
            'product_taken', 'shipped' => 'shipped',
            default => $status ?: 'pending',
        };
    }

    private function resolvedOrderStatusColumn(): string
    {
        if ($this->resolvedOrderStatusColumn !== null) {
            return $this->resolvedOrderStatusColumn;
        }

        if (Schema::hasColumn('orders', 'status')) {
            return $this->resolvedOrderStatusColumn = 'orders.status';
        }

        if (Schema::hasColumn('orders', 'order_status')) {
            return $this->resolvedOrderStatusColumn = 'orders.order_status';
        }

        return $this->resolvedOrderStatusColumn = "'pending'";
    }
}
