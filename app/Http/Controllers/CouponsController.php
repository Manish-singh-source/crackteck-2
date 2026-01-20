<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\EcommerceProduct;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Illuminate\Support\Facades\{Auth, DB, Log, Validator};

class CouponsController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request)
    {
        $status = $request->get('status') ?? 'all';
        $query = Coupon::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status != 'all') {
            $query->where('status', $status);
        }
        $coupons = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('e-commerce.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('e-commerce.coupons.create');
    }

    /**
     * Store a newly created coupon.
     */
    public function store(StoreCouponRequest $request)
    {
        DB::beginTransaction();

        try {
            $coupon = Coupon::create([
                'code' => strtoupper($request->code),
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'discount_value' => $request->discount_value,
                'max_discount' => $request->max_discount,
                'min_purchase_amount' => $request->min_purchase_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'usage_limit' => $request->usage_limit ?? 0,
                'used_count' => 0,
                'usage_per_customer' => $request->usage_per_customer ?? 1,
                'status' => $request->status,
                'stackable' => $request->stackable ?? 0,
                'applicable_categories' => $request->applicable_categories,
                'applicable_brands' => $request->applicable_brands,
                'excluded_products' => $request->excluded_products,
            ]);

            DB::commit();

            activity()
                ->performedOn($coupon)
                ->causedBy(Auth::user())
                ->log('Coupon created');

            return redirect()
                ->route('coupon.index')
                ->with('success', 'Coupon created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon Store Error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a coupon.
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('e-commerce.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon.
     */

    public function update(UpdateCouponRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $coupon = Coupon::findOrFail($id);

            $coupon->update([
                'code' => $request->code,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'discount_value' => $request->discount_value,
                'max_discount' => $request->max_discount,
                'min_purchase_amount' => $request->min_purchase_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'usage_limit' => $request->usage_limit ?? 0,
                'usage_per_customer' => $request->usage_per_customer ?? 1,
                'status' => $request->status,
                'stackable' => $request->stackable ?? 0,
                'applicable_categories' => $request->applicable_categories,
                'applicable_brands' => $request->applicable_brands,
                'excluded_products' => $request->excluded_products,
            ]);

            DB::commit();

            return redirect()
                ->route('coupon.index')
                ->with('success', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Remove the specified coupon.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $coupon = Coupon::findOrFail($id);

            // Check if coupon has been used
            if ($coupon->used_count > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete coupon that has been used by customers.',
                ], 400);
            }

            activity()->performedOn($coupon)->causedBy(Auth::user())->log('Coupon deleted');
            $coupon->delete();

            DB::commit();

            return redirect()->route('coupons.index')
                ->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon Delete Error: ' . $e->getMessage());
            return redirect()->back()->with([
                'success' => false,
                'message' => 'Error deleting coupon: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search categories for AJAX requests
     */
    public function searchCategories(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');

            $categories = ParentCategory::where('name', 'LIKE', "%$query%")
                ->where('status', "active")
                ->select('id', 'name')
                ->get();

            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Category Search Error: ' . $e->getMessage());
            return response()->json(['error' => 'Search failed'], 500);
        }
    }

    /**
     * Search brands for AJAX requests
     */
    public function searchBrands(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');

            $brands = Brand::where('name', 'LIKE', "%$query%")
                ->where('status', "active")
                ->select('id', 'name')
                ->limit(20)
                ->get();

            return response()->json($brands);
        } catch (\Exception $e) {
            Log::error('Brand Search Error: ' . $e->getMessage());
            return response()->json(['error' => 'Search failed'], 500);
        }
    }

    /**
     * Search products for coupon assignment (AJAX).
     */
    public function searchProducts(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');

            $products = EcommerceProduct::with(['warehouseProduct'])
                ->whereHas('warehouseProduct', function ($q) use ($query) {
                    $q->where('product_name', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%");
                })
                ->where('status', "active") // 1 = Active
                ->limit(20)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->warehouseProduct->product_name ?? 'N/A',
                        'sku' => $product->warehouseProduct->sku ?? 'N/A',
                    ];
                });

            return response()->json($products);
        } catch (\Exception $e) {
            Log::error('Product Search Error: ' . $e->getMessage());
            return response()->json(['error' => 'Search failed'], 500);
        }
    }
}
