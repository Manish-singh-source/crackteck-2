<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\EcommerceProduct;
use App\Models\ParentCategorie;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request)
    {
        $query = Coupon::with(['categories', 'products']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('coupon_code', 'like', "%{$search}%")
                    ->orWhere('coupon_title', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $coupons = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('e-commerce.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        $categories = ParentCategorie::active()->pluck('parent_categories', 'id');

        return view('e-commerce.coupons.create', compact('categories'));
    }

    /**
     * Store a newly created coupon.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'nullable|string|max:50|unique:coupons,coupon_code',
            'coupon_title' => 'required|string|max:255',
            'coupon_description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:parent_categories,id',
            'products' => 'nullable|array',
            'products.*' => 'exists:ecommerce_products,id',
        ]);

        // Additional validation for percentage discount
        if ($request->discount_type === 'percentage') {
            $validator->after(function ($validator) use ($request) {
                if ($request->discount_value > 100) {
                    $validator->errors()->add('discount_value', 'Percentage discount cannot exceed 100%.');
                }
            });
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Create coupon
            $coupon = Coupon::create([
                'coupon_code' => $request->coupon_code ?: Coupon::generateCouponCode(),
                'coupon_title' => $request->coupon_title,
                'coupon_description' => $request->coupon_description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'min_purchase_amount' => $request->min_purchase_amount,
                'start_date' => Carbon::parse($request->start_date),
                'end_date' => Carbon::parse($request->end_date),
                'total_usage_limit' => $request->total_usage_limit,
                'usage_limit_per_customer' => $request->usage_limit_per_customer,
                'status' => $request->status,
            ]);

            // Attach categories if provided
            if ($request->filled('categories')) {
                $coupon->categories()->attach($request->categories);
            }

            // Attach products if provided
            if ($request->filled('products')) {
                $coupon->products()->attach($request->products);
            }

            DB::commit();

            return redirect()->route('coupon.index')->with('success', 'Coupon created successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Error creating coupon: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing a coupon.
     */
    public function edit($id)
    {
        $coupon = Coupon::with(['categories', 'products'])->findOrFail($id);
        $categories = ParentCategorie::active()->pluck('parent_categories', 'id');

        return view('e-commerce.coupons.edit', compact('coupon', 'categories'));
    }

    /**
     * Update the specified coupon.
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|max:50|unique:coupons,coupon_code,'.$id,
            'coupon_title' => 'required|string|max:255',
            'coupon_description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:parent_categories,id',
            'products' => 'nullable|array',
            'products.*' => 'exists:ecommerce_products,id',
        ]);

        // Additional validation for percentage discount
        if ($request->discount_type === 'percentage') {
            $validator->after(function ($validator) use ($request) {
                if ($request->discount_value > 100) {
                    $validator->errors()->add('discount_value', 'Percentage discount cannot exceed 100%.');
                }
            });
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Update coupon
            $coupon->update([
                'coupon_code' => $request->coupon_code,
                'coupon_title' => $request->coupon_title,
                'coupon_description' => $request->coupon_description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'min_purchase_amount' => $request->min_purchase_amount,
                'start_date' => Carbon::parse($request->start_date),
                'end_date' => Carbon::parse($request->end_date),
                'total_usage_limit' => $request->total_usage_limit,
                'usage_limit_per_customer' => $request->usage_limit_per_customer,
                'status' => $request->status,
            ]);

            // Sync categories
            if ($request->filled('categories')) {
                $coupon->categories()->sync($request->categories);
            } else {
                $coupon->categories()->detach();
            }

            // Sync products
            if ($request->filled('products')) {
                $coupon->products()->sync($request->products);
            } else {
                $coupon->products()->detach();
            }

            DB::commit();

            return redirect()->route('coupon.index')->with('success', 'Coupon updated successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Error updating coupon: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified coupon.
     */
    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            // Check if coupon has been used
            if ($coupon->current_usage_count > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete coupon that has been used by customers.',
                ], 400);
            }

            $coupon->delete();

            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting coupon: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search products for coupon assignment (AJAX).
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $products = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->whereHas('warehouseProduct', function ($query) use ($search) {
                $query->where('product_name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->where('ecommerce_status', 'active')
            ->limit(20)
            ->get();

        $results = response()->json([
            'success' => true,
            'products' => $products,
        ]);
        // $results = $products->map(function($product) {
        //     return [
        //         'id' => $product->id,
        //         'text' => $product->warehouseProduct->product_name . ' (' . $product->sku . ')',
        //         'sku' => $product->sku,
        //         'brand' => $product->warehouseProduct->brand->brand_title ?? 'N/A',
        //         'category' => $product->warehouseProduct->parentCategorie->parent_categories ?? 'N/A',
        //         'price' => $product->warehouseProduct->selling_price ?? 0
        //     ];
        // });

        if (! isset($results)) {
            return response()->json([
                'success' => false,
                'message' => 'No products found matching your search',
            ]);
        }

        return $results;

        // response()->json($results);
    }
}
