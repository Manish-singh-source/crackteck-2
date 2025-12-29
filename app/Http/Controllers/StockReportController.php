<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequestRequest;
use App\Models\Product;
use App\Models\StockRequest;
use App\Models\StockRequestItem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class StockReportController extends Controller
{
    /**
     * Display a listing of stock requests.
     */
    public function warehouse_index(Request $request): View
    {
        $query = StockRequest::with(['requestedBy', 'stockRequestItems.product'])
            ->orderBy('created_at', 'desc');

        // Handle search
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('requestedBy', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('reason', 'like', "%{$search}%");
        }

        $stockRequests = $query->paginate(15);

        return view('warehouse.stock-request.index', compact('stockRequests'));
    }

    /**
     * Show the form for creating a new stock request.
     */
    public function warehouse_create(): View
    {
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('warehouse.stock-request.create', compact('users'));
    }

    /**
     * Store a newly created stock request.
     */
    public function warehouse_store(StoreStockRequestRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Create the stock request
            $stockRequest = StockRequest::create([
                'requested_by' => $request->requested_by,
                'request_date' => $request->request_date,
                'reason' => $request->reason,
                'urgency_level' => $request->urgency_level,
                'approval_status' => 'Pending',
                'final_status' => 'Pending',
            ]);

            // Create stock request items
            foreach ($request->products as $productData) {
                StockRequestItem::create([
                    'stock_request_id' => $stockRequest->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                ]);
            }

            DB::commit();

            return redirect()->route('stock-request.index')
                ->with('success', 'Stock request created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating stock request: '.$e->getMessage());

            return back()->withInput()
                ->with('error', 'Failed to create stock request. Please try again.');
        }
    }

    /**
     * Remove the specified stock request.
     */
    public function warehouse_destroy(StockRequest $stockRequest): JsonResponse
    {
        try {
            $stockRequest->delete(); // Cascade will handle stock_request_items

            return response()->json([
                'success' => true,
                'message' => 'Stock request deleted successfully.',
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting stock request: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete stock request.',
            ], 500);
        }
    }

    /**
     * Search products for AJAX requests.
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $products = Product::where('status', 'Active')
            ->where(function ($query) use ($search) {
                $query->where('product_name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('model_no', 'like', "%{$search}%");
            })
            ->with(['brand', 'parentCategorie'])
            ->limit(20)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'text' => $product->product_name.' ('.$product->sku.')',
                    'product_name' => $product->product_name,
                    'sku' => $product->sku,
                    'brand' => $product->brand?->brand_name ?? 'N/A',
                    'category' => $product->parentCategorie?->parent_category_name ?? 'N/A',
                    'stock_quantity' => $product->stock_quantity ?? 0,
                ];
            });

        return response()->json($products);
    }

    /**
     * Get specific product details for AJAX requests.
     */
    public function getProduct(Product $product): JsonResponse
    {
        $product->load(['brand', 'parentCategorie']);

        return response()->json([
            'id' => $product->id,
            'product_name' => $product->product_name,
            'sku' => $product->sku,
            'brand' => $product->brand?->brand_name ?? 'N/A',
            'category' => $product->parentCategorie?->parent_category_name ?? 'N/A',
            'stock_quantity' => $product->stock_quantity ?? 0,
            'model_no' => $product->model_no,
        ]);
    }

    // Legacy methods for CRM (keeping for backward compatibility)
    public function index()
    {
        return view('/crm/accounts/stock-request/index');
    }

    public function create()
    {
        return view('/crm/accounts/stock-request/create');
    }

    public function warehouse_edit()
    {
        return view('/warehouse/stock-request/edit');
    }

    public function delete($id)
    {
        dd($id, 'delete');
        $stockRequest = StockRequest::findOrFail($id);
        $stockRequest->delete();

        return redirect()->route('stock-request.index')->with('success', 'Stock Request deleted successfully.');
    }
}
