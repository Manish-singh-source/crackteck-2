<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Coupon;
use App\Models\EcommerceProduct;
use App\Models\ParentCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log, Validator};

class CouponsController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request)
    {
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
        if ($request->filled('status')) {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:0,1,2', // 0=Percentage, 1=Fixed, 2=Buy X Get Y
            'discount_value' => 'required|numeric|min:0.01',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'usage_per_customer' => 'nullable|integer|min:1',
            'is_active' => 'required|in:0,1',
            'stackable' => 'nullable|in:0,1',
            'applicable_categories' => 'nullable|array',
            'applicable_categories.*' => 'exists:parent_categories,id',
            'applicable_brands' => 'nullable|array',
            'applicable_brands.*' => 'exists:brands,id',
            'excluded_products' => 'nullable|array',
            'excluded_products.*' => 'exists:ecommerce_products,id',
        ]);

        // Additional validation for percentage discount
        if ($request->type == 0) { // Percentage
            $validator->after(function ($validator) use ($request) {
                if ($request->discount_value > 100) {
                    $validator->errors()->add('discount_value', 'Percentage discount cannot exceed 100%.');
                }
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Create coupon
            $coupon = Coupon::create([
                'code' => strtoupper($request->code),
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type, // Already integer from form (0, 1, 2)
                'discount_value' => $request->discount_value,
                'max_discount' => $request->max_discount,
                'min_purchase_amount' => $request->min_purchase_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'usage_limit' => $request->usage_limit ?? 0,
                'used_count' => 0,
                'usage_per_customer' => $request->usage_per_customer ?? 1,
                'is_active' => $request->is_active,
                'stackable' => $request->stackable ?? 0,
                'applicable_categories' => $request->applicable_categories,
                'applicable_brands' => $request->applicable_brands,
                'excluded_products' => $request->excluded_products,
            ]);

            DB::commit();
            activity()->performedOn($coupon)->causedBy(Auth::user())->log('Coupon created');

            return redirect()->route('coupon.index')->with('success', 'Coupon created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
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
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        // ✅ FIXED: Type mapping for form values (0,1,2)
        $typeMapping = [
            '0' => 0, // Percentage
            '1' => 1, // Fixed  
            '2' => 2, // Buy X Get Y
        ];

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:0,1,2', // ✅ FIXED: Same as store (0,1,2)
            'discount_value' => 'required|numeric|min:0.01',
            'max_discount' => 'nullable|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'usage_per_customer' => 'nullable|integer|min:1',
            'is_active' => 'required|in:0,1',
            'stackable' => 'nullable|in:0,1',
            'applicable_categories' => 'nullable|array',
            'applicable_categories.*' => 'exists:parent_categories,id',
            'applicable_brands' => 'nullable|array',
            'applicable_brands.*' => 'exists:brands,id',
            'excluded_products' => 'nullable|array',
            'excluded_products.*' => 'exists:ecommerce_products,id',
        ]);

        // ✅ FIXED: Percentage validation for integer type (0)
        if ($request->type == 0) { // Percentage
            $validator->after(function ($validator) use ($request) {
                if ($request->discount_value > 100) {
                    $validator->errors()->add('discount_value', 'Percentage discount cannot exceed 100%.');
                }
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Update coupon
            $coupon->update([
                'code' => strtoupper($request->code),
                'title' => $request->title,
                'description' => $request->description,
                'type' => (int) $request->type, // ✅ Ensure integer
                'discount_value' => $request->discount_value,
                'max_discount' => $request->max_discount,
                'min_purchase_amount' => $request->min_purchase_amount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'usage_limit' => $request->usage_limit ?? 0,
                'usage_per_customer' => $request->usage_per_customer ?? 1,
                'is_active' => $request->is_active,
                'stackable' => $request->stackable ?? 0,
                'applicable_categories' => $request->applicable_categories,
                'applicable_brands' => $request->applicable_brands,
                'excluded_products' => $request->excluded_products,
            ]);

            DB::commit();
            activity()->performedOn($coupon)->causedBy(Auth::user())->log('Coupon updated');

            return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coupon Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
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
                ->where('status', "1")
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
                ->where('status', "1")
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
                ->where('status', "1") // 1 = Active
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
