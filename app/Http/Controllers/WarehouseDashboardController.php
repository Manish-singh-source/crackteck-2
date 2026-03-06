<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorPurchaseOrder;
use App\Models\ScrapItem;
use App\Models\ServiceRequestProductRequestPart;
use Carbon\Carbon;

class WarehouseDashboardController extends Controller
{
    /**
     * Display the warehouse dashboard with comprehensive metrics.
     */
    public function index(Request $request)
    {
        // Get date range filter
        $dateRange = $request->get('date_range', '30days');
        $warehouseId = $request->get('warehouse', 'all');
        $vendorId = $request->get('vendor', 'all');

        // Calculate date filter
        $startDate = $this->getStartDate($dateRange);

        // Base queries with filters
        $warehouseQuery = Warehouse::query();
        $productQuery = Product::query();
        $vendorQuery = Vendor::query();
        $purchaseOrderQuery = VendorPurchaseOrder::query();
        $scrapItemQuery = ScrapItem::query();
        $requestedPartsQuery = ServiceRequestProductRequestPart::query();

        // Apply date filters
        if ($startDate) {
            $purchaseOrderQuery->where('created_at', '>=', $startDate);
            $scrapItemQuery->where('created_at', '>=', $startDate);
            $requestedPartsQuery->where('created_at', '>=', $startDate);
        }

        // Apply warehouse filter
        if ($warehouseId !== 'all') {
            $productQuery->where('warehouse_id', $warehouseId);
        }

        // Apply vendor filter
        if ($vendorId !== 'all') {
            $purchaseOrderQuery->where('vendor_id', $vendorId);
        }

        // ==================== KPI DATA ====================
        
        // Total Warehouses
        $warehouses = $warehouseQuery->get();
        $totalWarehouses = $warehouses->count();

        // Total Products
        $products = $productQuery->get();
        $totalProducts = $products->count();

        // Total Vendors
        $vendors = $vendorQuery->get();
        $totalVendors = $vendors->count();

        // Total Purchase Orders
        $purchaseOrders = $purchaseOrderQuery->get();
        $totalPurchaseOrders = $purchaseOrders->count();

        // Low Stock Products (stock_status = 'low_stock' or stock_quantity is low)
        $lowStockCount = Product::where('stock_status', 'low_stock')
            ->when($warehouseId !== 'all', function($query) use ($warehouseId) {
                return $query->where('warehouse_id', $warehouseId);
            })
            ->count();

        // Low Stock Products for table
        $lowStockProducts = Product::where('stock_status', 'low_stock')
            ->when($warehouseId !== 'all', function($query) use ($warehouseId) {
                return $query->where('warehouse_id', $warehouseId);
            })
            ->limit(10)
            ->get();

        // Total Scrap Items
        $scrapItems = $scrapItemQuery->get();
        $totalScrapItems = $scrapItems->count();

        // Scrap Value (using cost_price from related product or default)
        $scrapValue = $scrapItems->sum(function($item) {
            return $item->product ? $item->product->cost_price * ($item->quantity_scrapped ?? 1) : 0;
        });

        // Scrap Categories count
        $scrapCategories = $scrapItems->groupBy('category')->count();

        // Total Requested Parts
        $requestedParts = $requestedPartsQuery->get();
        $totalRequestedParts = $requestedParts->count();

        // ==================== FINANCIAL DATA ====================

        // Total Purchase Amount
        $totalPurchaseAmount = $purchaseOrders->sum('po_amount') ?? 0;

        // Total Paid Amount
        $totalPaidAmount = $purchaseOrders->sum('po_amount_paid') ?? 0;

        // Total Pending Amount
        $totalPendingAmount = $purchaseOrders->sum('po_amount_pending') ?? 0;

        // Overdue Amount
        $overdueAmount = $purchaseOrders->where('po_amount_due_date', '<', Carbon::now())
            ->where('po_status', '!=', 'completed')
            ->sum('po_amount') ?? 0;

        // ==================== MONTHLY TRENDS DATA ====================

        // Monthly spending for last 12 months
        $monthlySpending = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlySpending[] = VendorPurchaseOrder::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('po_amount') ?? 0;
        }

        // ==================== WAREHOUSE ANALYTICS ====================

        // Products per warehouse
        $warehouseProductCounts = Warehouse::withCount('products')->get()
            ->pluck('products_count')
            ->toArray();

        // Stock status per warehouse (available vs reserved)
        $warehouseStockData = Warehouse::with(['products' => function($query) {
            $query->selectRaw('warehouse_id, SUM(stock_quantity) as available_stock')
                ->groupBy('warehouse_id');
        }])->get();

        // Warehouse by region (using state or city field)
        $warehouseRegions = Warehouse::selectRaw('state, COUNT(*) as count')
            ->groupBy('state')
            ->pluck('count', 'state')
            ->toArray();

        $northCount = ($warehouseRegions['Delhi'] ?? 0) + ($warehouseRegions['Punjab'] ?? 0) + ($warehouseRegions['Haryana'] ?? 0);
        $southCount = ($warehouseRegions['Karnataka'] ?? 0) + ($warehouseRegions['Tamil Nadu'] ?? 0) + ($warehouseRegions['Telangana'] ?? 0);
        $eastCount = ($warehouseRegions['West Bengal'] ?? 0) + ($warehouseRegions['Odisha'] ?? 0) + ($warehouseRegions['Bihar'] ?? 0);
        $westCount = ($warehouseRegions['Maharashtra'] ?? 0) + ($warehouseRegions['Gujarat'] ?? 0) + ($warehouseRegions['Rajasthan'] ?? 0);

        // ==================== VENDOR PERFORMANCE ====================

        // Purchase orders per vendor
        $vendorOrderCounts = Vendor::withCount(['purchaseOrders' => function($query) use ($startDate) {
            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
        }])->get()->pluck('purchase_orders_count', 'vendor_name')->toArray();

        // Top vendors by total amount
        $topVendors = Vendor::select('vendors.id', 'vendors.first_name', 'vendors.last_name')
            ->join('vendor_purchase_orders', 'vendors.id', '=', 'vendor_purchase_orders.vendor_id')
            ->selectRaw('COUNT(vendor_purchase_orders.id) as orders_count, SUM(vendor_purchase_orders.po_amount) as total_amount')
            ->when($startDate, function($query) use ($startDate) {
                return $query->where('vendor_purchase_orders.created_at', '>=', $startDate);
            })
            ->groupBy('vendors.id', 'vendors.first_name', 'vendors.last_name')
            ->orderByDesc('total_amount')
            ->limit(5)
            ->get();

        // ==================== SCRAP TRENDS ====================

        // Monthly scrap trend
        $monthlyScrap = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyScrap[] = ScrapItem::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Scrap by category
        $scrapByCategory = ScrapItem::selectRaw('reason_for_scrap as category, COUNT(*) as count')
            ->groupBy('reason_for_scrap')
            ->pluck('count', 'category')
            ->toArray();

        // ==================== INVENTORY INSIGHTS ====================

        // Most used products (from service requests)
        $mostUsedProducts = ServiceRequestProductRequestPart::selectRaw('product_id, COUNT(*) as usage_count')
            ->groupBy('product_id')
            ->orderByDesc('usage_count')
            ->limit(10)
            ->get();

        // Product usage trend
        $monthlyUsage = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyUsage[] = ServiceRequestProductRequestPart::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Return view with all data
        return view('warehouse.index', compact(
            // KPI Data
            'warehouses', 'products', 'vendors', 'purchaseOrders', 'scrapItems', 'requestedParts',
            'totalWarehouses', 'totalProducts', 'totalVendors', 'totalPurchaseOrders',
            'lowStockCount', 'lowStockProducts', 'totalScrapItems', 'scrapValue', 'scrapCategories', 'totalRequestedParts',
            
            // Financial Data
            'totalPurchaseAmount', 'totalPaidAmount', 'totalPendingAmount', 'overdueAmount',
            'monthlySpending',
            
            // Warehouse Analytics
            'warehouseProductCounts', 'northCount', 'southCount', 'eastCount', 'westCount',
            
            // Vendor Performance
            'vendorOrderCounts', 'topVendors',
            
            // Scrap Trends
            'monthlyScrap', 'scrapByCategory',
            
            // Inventory Insights
            'mostUsedProducts', 'monthlyUsage'
        ));
    }

    /**
     * Calculate start date based on date range filter.
     */
    private function getStartDate($dateRange)
    {
        switch ($dateRange) {
            case 'today':
                return Carbon::today();
            case '7days':
                return Carbon::now()->subDays(7);
            case '30days':
                return Carbon::now()->subDays(30);
            case '90days':
                return Carbon::now()->subDays(90);
            default:
                return Carbon::now()->subDays(30);
        }
    }
}
