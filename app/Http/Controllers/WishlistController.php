<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWishlistRequest;
use App\Models\EcommerceProduct;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist page.
     */
    public function index()
    {
        // Check if user is authenticated
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your wishlist.');
        }

        // Get user's wishlist items with product relationships
        $wishlistItems = Wishlist::with([
            'ecommerceProduct.warehouseProduct.brand',
            'ecommerceProduct.warehouseProduct.parentCategorie',
            'ecommerceProduct.warehouseProduct.subCategorie',
        ])
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    /**
     * Add a product to the user's wishlist.
     */
    public function store(StoreWishlistRequest $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $ecommerceProductId = $request->validated()['ecommerce_product_id'];

            // Check if the e-commerce product exists and is active
            $ecommerceProduct = EcommerceProduct::active()->find($ecommerceProductId);
            if (! $ecommerceProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or is not available.',
                ], 404);
            }

            // Add to wishlist
            $wishlistItem = Wishlist::create([
                'customer_id' => $userId,
                'ecommerce_product_id' => $ecommerceProductId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to your wishlist successfully!',
                'wishlist_item_id' => $wishlistItem->id,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error adding product to wishlist: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product to your wishlist.',
            ], 500);
        }
    }

    /**
     * Remove a product from the user's wishlist.
     */
    public function destroy($id): JsonResponse
    {
        try {
            // Check if user is authenticated
            if (! Auth::guard('customer_web')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to remove items from wishlist.',
                ], 401);
            }

            $customerId = Auth::guard('customer_web')->id();
            
            // Find the wishlist item and ensure it belongs to the authenticated user
            $wishlistItem = Wishlist::where('id', $id)
                ->where('customer_id', $customerId)
                ->first();

            if (! $wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wishlist item not found. ID: ' . $id . ', Customer ID: ' . $customerId,
                ], 404);
            }

            // Delete the wishlist item
            $wishlistItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product removed from your wishlist successfully!',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error removing product from wishlist: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the product from your wishlist.',
            ], 500);
        }
    }

    /**
     * Move a product from wishlist to cart.
     */
    public function moveToCart($id): JsonResponse
    {
        try {
            // Check if user is authenticated
            if (! Auth::guard('customer_web')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to move items to cart.',
                ], 401);
            }

            $customerId = Auth::guard('customer_web')->id();

            // Find the wishlist item and ensure it belongs to the authenticated user
            $wishlistItem = Wishlist::with('ecommerceProduct')
                ->where('id', $id)
                ->where('customer_id', $customerId)
                ->first();

            if (! $wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wishlist item not found. ID: ' . $id . ', Customer ID: ' . $customerId,
                ], 404);
            }

            // Check if the product is still available
            if (! $wishlistItem->ecommerceProduct || $wishlistItem->ecommerceProduct->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'This product is no longer available.',
                ], 400);
            }

            // Add to cart directly
            $productId = $wishlistItem->ecommerce_product_id;
            
            // Check if already in cart
            $existingCartItem = \App\Models\Cart::where('customer_id', $customerId)
                ->where('ecommerce_product_id', $productId)
                ->first();
            
            if ($existingCartItem) {
                // Update quantity
                $existingCartItem->quantity += 1;
                $existingCartItem->save();
            } else {
                // Add to cart
                \App\Models\Cart::create([
                    'customer_id' => $customerId,
                    'ecommerce_product_id' => $productId,
                    'quantity' => 1,
                ]);
            }

            // Remove from wishlist
            $wishlistItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully!',
                'redirect_to_cart' => true,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error moving product from wishlist to cart: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while moving the product to cart.',
            ], 500);
        }
    }

    /**
     * Get the count of items in user's wishlist.
     */
    public function getWishlistCount(): JsonResponse
    {
        try {
            if (! Auth::guard('customer_web')->check()) {
                return response()->json(['count' => 0]);
            }

            $count = Wishlist::where('customer_id', Auth::id())->count();

            return response()->json(['count' => $count]);

        } catch (\Exception $e) {
            Log::error('Error getting wishlist count: '.$e->getMessage());

            return response()->json(['count' => 0]);
        }
    }

    /**
     * Check if product is in user's wishlist.
     */
    public function checkWishlistStatus(Request $request): JsonResponse
    {
        if (! Auth::guard('customer_web')->check()) {
            return response()->json(['in_wishlist' => false]);
        }

        $validator = Validator::make($request->all(), [
            'ecommerce_product_id' => 'required|exists:ecommerce_products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['in_wishlist' => false]);
        }

        $inWishlist = Wishlist::isInWishlist(Auth::id(), $request->ecommerce_product_id);

        return response()->json(['in_wishlist' => $inWishlist]);
    }

    /**
     * Toggle product in wishlist (add if not exists, remove if exists).
     */
    public function toggleWishlist(Request $request): JsonResponse
    {
        // Check authentication
        $customer = Auth::guard('customer_web')->user();
        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to manage your wishlist.',
                'requires_auth' => true,
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'ecommerce_product_id' => 'required|exists:ecommerce_products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $customerId = $customer->id; // Use the correct customer ID
            $ecommerceProductId = $request->ecommerce_product_id;

            // Check if the e-commerce product exists and is active
            $ecommerceProduct = EcommerceProduct::active()->find($ecommerceProductId);
            if (! $ecommerceProduct) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or is not available.',
                ], 404);
            }

            // Check if product is already in wishlist
            $existingWishlistItem = Wishlist::where('customer_id', $customerId)
                ->where('ecommerce_product_id', $ecommerceProductId)
                ->first();

            if ($existingWishlistItem) {
                // Remove from wishlist
                $existingWishlistItem->delete();
                DB::commit();

                activity()
                    ->performedOn($existingWishlistItem)
                    ->causedBy($customer)
                    ->log('Removed product from wishlist');

                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'message' => 'Product removed from wishlist.',
                    'wishlist_count' => Wishlist::where('customer_id', $customerId)->count(),
                ]);
            } else {
                // Add to wishlist
                $wishlistItem = Wishlist::create([
                    'customer_id' => $customerId,
                    'ecommerce_product_id' => $ecommerceProductId,
                ]);
                DB::commit();

                activity()
                    ->performedOn($wishlistItem)
                    ->causedBy($customer)
                    ->log('Added product to wishlist');

                return response()->json([
                    'success' => true,
                    'action' => 'added',
                    'message' => 'Product added to wishlist successfully!',
                    'wishlist_item_id' => $wishlistItem->id,
                    'wishlist_count' => Wishlist::where('customer_id', $customerId)->count(),
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error toggling wishlist: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }

    }
