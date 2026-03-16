<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\EcommerceProduct;
use App\Models\ParentCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontendEcommerceController extends Controller
{
    /**
     * Display the e-commerce shop page with products from ecommerce_products table
     */
    public function shop()
    {
        $products = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])
            ->where('status', 'active')
            ->paginate(12);

        $categories = ParentCategory::where('status_ecommerce', 'active')
            ->whereHas('products', function ($query) {
                $query->whereHas('ecommerceProduct', function ($q) {
                    $q->where('status_ecommerce', 'active')
                        ->whereNull('deleted_at');
                });
            })
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'image']);

        $brands = Brand::where('status', 'active')
            ->whereHas('products', function ($query) {
                $query->whereHas('ecommerceProduct', function ($q) {
                    $q->where('status_ecommerce', 'active')
                        ->whereNull('deleted_at');
                });
            })
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'image']);

        // dd($brands);

        return view('frontend.ecommerce-shop', compact('products', 'categories', 'brands'));
    }

    /**
     * Display individual product detail page
     */
    public function productDetail($id)
    {
        // Get the specific e-commerce product with all relationships
        $product = EcommerceProduct::with([
            'warehouseProduct',
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])
            ->where('status', 'active')
            ->findOrFail($id);

        // dd($product);

        // Track recently viewed products
        $this->trackRecentlyViewed($id);

        // Get recently viewed products (excluding current product)
        $recentlyViewed = $this->getRecentlyViewedProducts($id);

        // Get related products based on category
        $relatedProducts = $this->getRelatedProducts($product, 8);

        // Generate product features list from description
        $productFeatures = $this->extractProductFeatures($product);

        return view('frontend.ecommerce-product-detail', compact(
            'product',
            'recentlyViewed',
            'relatedProducts',
            'productFeatures'
        ));
    }

    /**
     * Track recently viewed products in session
     */
    private function trackRecentlyViewed($productId)
    {
        $recentlyViewed = Session::get('recently_viewed', []);

        // Remove product if it already exists to avoid duplicates
        $recentlyViewed = array_filter($recentlyViewed, function ($id) use ($productId) {
            return $id != $productId;
        });

        // Add current product to the beginning of the array
        array_unshift($recentlyViewed, $productId);

        // Keep only the last 10 viewed products
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);

        Session::put('recently_viewed', $recentlyViewed);
    }

    /**
     * Get recently viewed products (excluding current product)
     */
    private function getRecentlyViewedProducts($currentProductId, $limit = 6)
    {
        $recentlyViewedIds = Session::get('recently_viewed', []);

        // Remove current product from recently viewed
        $recentlyViewedIds = array_filter($recentlyViewedIds, function ($id) use ($currentProductId) {
            return $id != $currentProductId;
        });

        // Limit the results
        $recentlyViewedIds = array_slice($recentlyViewedIds, 0, $limit);

        if (empty($recentlyViewedIds)) {
            return collect();
        }

        return EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])
            ->whereIn('id', $recentlyViewedIds)
            ->active()
            ->get()
            ->sortBy(function ($product) use ($recentlyViewedIds) {
                return array_search($product->id, $recentlyViewedIds);
            });
    }

    /**
     * Get related products based on category and brand
     */
    private function getRelatedProducts($product, $limit = 8)
    {
        $query = EcommerceProduct::with([
            'warehouseProduct.brand',
            'warehouseProduct.parentCategorie',
            'warehouseProduct.subCategorie',
        ])
            ->where('id', '!=', $product->id)
            ->where('status', 'active');

        // First try to get products from same sub-category
        if ($product->warehouseProduct && $product->warehouseProduct->sub_category_id) {
            $relatedProducts = $query->whereHas('warehouseProduct', function ($q) use ($product) {
                $q->where('sub_category_id', $product->warehouseProduct->sub_category_id);
            })->limit($limit)->get();

            if ($relatedProducts->count() >= $limit) {
                return $relatedProducts;
            }
        }

        // If not enough products, get from same parent category
        if ($product->warehouseProduct && $product->warehouseProduct->parent_category_id) {
            $relatedProducts = $query->whereHas('warehouseProduct', function ($q) use ($product) {
                $q->where('parent_category_id', $product->warehouseProduct->parent_category_id);
            })->limit($limit)->get();

            if ($relatedProducts->count() >= $limit) {
                return $relatedProducts;
            }
        }

        // If still not enough, get from same brand
        if ($product->warehouseProduct && $product->warehouseProduct->brand_id) {
            $relatedProducts = $query->whereHas('warehouseProduct', function ($q) use ($product) {
                $q->where('brand_id', $product->warehouseProduct->brand_id);
            })->limit($limit)->get();

            if ($relatedProducts->count() >= $limit) {
                return $relatedProducts;
            }
        }

        // Fallback: get any active products
        return $query->limit($limit)->get();
    }

    /**
     * Extract product features from description
     */
    private function extractProductFeatures($product)
    {
        $features = [];

        // Try to get features from ecommerce short description first
        if ($product->ecommerce_short_description) {
            $description = strip_tags($product->ecommerce_short_description);
        } elseif ($product->warehouseProduct && $product->warehouseProduct->short_description) {
            $description = strip_tags($product->warehouseProduct->short_description);
        } else {
            return $features;
        }

        // Split by common delimiters and extract bullet points
        $lines = preg_split('/[•\-\*\n\r]+/', $description);

        foreach ($lines as $line) {
            $line = trim($line);
            if (! empty($line) && strlen($line) > 10 && strlen($line) < 200) {
                $features[] = $line;
            }
        }

        // Limit to 6 features
        return array_slice($features, 0, 6);
    }

    /**
     * Get all active categories for shop filter
     */
    public function getCategories()
    {
        try {
            // Get active parent categories that have e-commerce products
            $categories = ParentCategory::where('status', '1')
                ->where('category_status_ecommerce', true)
                ->whereHas('products', function ($query) {
                    $query->whereHas('ecommerceProduct', function ($q) {
                        $q->where('ecommerce_status', 'active');
                    });
                })
                ->orderBy('sort_order', 'asc')
                ->get(['id', 'name', 'image']);

            return response()->json([
                'success' => true,
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
            ], 500);
        }
    }

    /**
     * Get all active brands for shop filter
     */
    public function getBrands()
    {
        try {
            // Get active brands that have e-commerce products
            $brands = Brand::where('status', 'active')
                ->whereHas('products', function ($query) {
                    $query->whereHas('ecommerceProduct', function ($q) {
                        $q->where('ecommerce_status', 'active');
                    });
                })
                ->orderBy('brand_title', 'asc')
                ->get(['id', 'brand_title', 'logo']);

            return response()->json([
                'success' => true,
                'brands' => $brands,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch brands',
            ], 500);
        }
    }

    /**
     * Filter products based on multiple criteria
     */
    // public function filterProducts(Request $request)
    // {
    //     try {
    //         // Start with base query
    //         $query = EcommerceProduct::with([
    //             'warehouseProduct.brand',
    //             'warehouseProduct.parentCategorie',
    //             'warehouseProduct.subCategorie',
    //         ])->active();

    //         // Filter by categories (multiple selection)
    //         if ($request->has('categories') && !empty($request->categories)) {
    //             $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
    //             // Cast to integers to ensure proper comparison
    //             $categoryIds = array_map('intval', $categoryIds);
    //             $query->whereHas('warehouseProduct', function ($q) use ($categoryIds) {
    //                 $q->whereIn('parent_category_id', $categoryIds);
    //             });
    //         }

    //         // Filter by brands (multiple selection)
    //         if ($request->has('brands') && !empty($request->brands)) {
    //             $brandIds = is_array($request->brands) ? $request->brands : [$request->brands];
    //             // Cast to integers to ensure proper comparison
    //             $brandIds = array_map('intval', $brandIds);
    //             $query->whereHas('warehouseProduct', function ($q) use ($brandIds) {
    //                 $q->whereIn('brand_id', $brandIds);
    //             });
    //         }

    //         // Filter by price range (predefined ranges)
    //         if ($request->has('price_range') && !empty($request->price_range)) {
    //             $priceRanges = is_array($request->price_range) ? $request->price_range : [$request->price_range];

    //             $query->where(function ($q) use ($priceRanges) {
    //                 foreach ($priceRanges as $range) {
    //                     switch ($range) {
    //                         case 'under_10000':
    //                             $q->orWhereHas('warehouseProduct', function ($wq) {
    //                                 $wq->where(function ($pq) {
    //                                     $pq->where('final_price', '>', 0)
    //                                         ->where('final_price', '<', 10000);
    //                                 })->orWhere(function ($pq) {
    //                                     $pq->where(function ($dpq) {
    //                                         $dpq->whereNull('final_price')
    //                                             ->orWhere('final_price', '<=', 0);
    //                                     })->where('selling_price', '<', 10000);
    //                                 });
    //                             });
    //                             break;
    //                         case '10000_15000':
    //                             $q->orWhereHas('warehouseProduct', function ($wq) {
    //                                 $wq->where(function ($pq) {
    //                                     $pq->where('final_price', '>', 0)
    //                                         ->whereBetween('final_price', [10000, 15000]);
    //                                 })->orWhere(function ($pq) {
    //                                     $pq->where(function ($dpq) {
    //                                         $dpq->whereNull('final_price')
    //                                             ->orWhere('final_price', '<=', 0);
    //                                     })->whereBetween('selling_price', [10000, 15000]);
    //                                 });
    //                             });
    //                             break;
    //                         case '15000_25000':
    //                             $q->orWhereHas('warehouseProduct', function ($wq) {
    //                                 $wq->where(function ($pq) {
    //                                     $pq->where('final_price', '>', 0)
    //                                         ->whereBetween('final_price', [15000, 25000]);
    //                                 })->orWhere(function ($pq) {
    //                                     $pq->where(function ($dpq) {
    //                                         $dpq->whereNull('final_price')
    //                                             ->orWhere('final_price', '<=', 0);
    //                                     })->whereBetween('selling_price', [15000, 25000]);
    //                                 });
    //                             });
    //                             break;
    //                         case 'above_35000':
    //                             $q->orWhereHas('warehouseProduct', function ($wq) {
    //                                 $wq->where(function ($pq) {
    //                                     $pq->where('final_price', '>', 0)
    //                                         ->where('final_price', '>=', 35000);
    //                                 })->orWhere(function ($pq) {
    //                                     $pq->where(function ($dpq) {
    //                                         $dpq->whereNull('final_price')
    //                                             ->orWhere('final_price', '<=', 0);
    //                                     })->where('selling_price', '>=', 35000);
    //                                 });
    //                             });
    //                             break;
    //                     }
    //                 }
    //             });
    //         }

    //         // Filter by custom price range
    //         if ($request->has('min_price') || $request->has('max_price')) {
    //             $minPrice = $request->min_price ?? 0;
    //             $maxPrice = $request->max_price ?? PHP_INT_MAX;

    //             $query->whereHas('warehouseProduct', function ($q) use ($minPrice, $maxPrice) {
    //                 $q->where(function ($pq) use ($minPrice, $maxPrice) {
    //                     $pq->where(function ($dpq) use ($minPrice, $maxPrice) {
    //                         $dpq->where('final_price', '>', 0)
    //                             ->whereBetween('final_price', [$minPrice, $maxPrice]);
    //                     })
    //                         ->orWhere(function ($spq) use ($minPrice, $maxPrice) {
    //                             $spq->where(function ($nullCheck) {
    //                                 $nullCheck->whereNull('final_price')
    //                                     ->orWhere('final_price', '<=', 0);
    //                             })->whereBetween('selling_price', [$minPrice, $maxPrice]);
    //                         });
    //                 });
    //             });
    //         }

    //         // Filter by deals (Today's Deals)
    //         if ($request->has('deal') && !empty($request->deal)) {
    //             $deal = $request->deal;
    //             if ($deal === 'dealToday') {
    //                 $query->where('is_todays_deal', true);
    //             }
    //         }

    //         // Apply sorting using subquery to avoid join issues
    //         $sort = $request->input('sort_by', '');

    //         if (!empty($sort)) {
    //             // Use a subquery approach for sorting to avoid eager loading issues
    //             $query->select('ecommerce_products.*');

    //             switch ($sort) {
    //                 case 'a-z':
    //                     $query->join('products as p', 'ecommerce_products.product_id', '=', 'p.id')
    //                           ->orderBy('p.product_name', 'asc');
    //                     break;
    //                 case 'z-a':
    //                     $query->join('products as p', 'ecommerce_products.product_id', '=', 'p.id')
    //                           ->orderBy('p.product_name', 'desc');
    //                     break;
    //                 case 'price-low-high':
    //                     $query->join('products as p', 'ecommerce_products.product_id', '=', 'p.id')
    //                           ->orderByRaw('COALESCE(p.final_price, p.selling_price, 0) ASC');
    //                     break;
    //                 case 'price-high-low':
    //                     $query->join('products as p', 'ecommerce_products.product_id', '=', 'p.id')
    //                           ->orderByRaw('COALESCE(p.final_price, p.selling_price, 0) DESC');
    //                     break;
    //                 default:
    //                     $query->orderBy('ecommerce_products.created_at', 'desc');
    //                     break;
    //             }
    //         } else {
    //             // Default ordering
    //             $query->orderBy('ecommerce_products.created_at', 'desc');
    //         }

    //         // Get filtered products
    //         $products = $query->paginate(12);

    //         // Format products for response
    //         $formattedProducts = $products->map(function ($product) {
    //             try {
    //                 $warehouseProduct = $product->warehouseProduct;
    //                 $brand = null;
    //                 $parentCategory = null;

    //                 if ($warehouseProduct) {
    //                     $brand = $warehouseProduct->brand;
    //                     $parentCategory = $warehouseProduct->parentCategorie;
    //                 }

    //                 return [
    //                     'id' => $product->id,
    //                     'name' => $warehouseProduct->product_name ?? '',
    //                     'sku' => $warehouseProduct->sku ?? '',
    //                     'brand' => $brand ? $brand->brand_title : '',
    //                     'brand_id' => $warehouseProduct->brand_id ?? null,
    //                     'category' => $parentCategory ? $parentCategory->parent_categories : '',
    //                     'category_id' => $warehouseProduct->parent_category_id ?? null,
    //                     'selling_price' => $warehouseProduct->selling_price ?? 0,
    //                     'discount_price' => $warehouseProduct->discount_price ?? 0,
    //                     'final_price' => $warehouseProduct->final_price ?? 0,
    //                     'main_image' => $warehouseProduct->main_product_image ?? '',
    //                     'stock_status' => $warehouseProduct->stock_status ?? 'Out of Stock',
    //                     'is_featured' => $product->is_featured,
    //                     'is_best_seller' => $product->is_best_seller,
    //                     'is_todays_deal' => $product->is_todays_deal,
    //                     'url' => route('product.detail', $product->id),
    //                     'short_description' => $warehouseProduct->short_description ?? '',
    //                     'total_sold' => $product->total_sold ?? 0,
    //                 ];
    //             } catch (\Exception $e) {
    //                 return [
    //                     'id' => $product->id,
    //                     'name' => '',
    //                     'sku' => '',
    //                     'brand' => '',
    //                     'brand_id' => null,
    //                     'category' => '',
    //                     'category_id' => null,
    //                     'selling_price' => 0,
    //                     'discount_price' => 0,
    //                     'final_price' => 0,
    //                     'main_image' => '',
    //                     'stock_status' => 'Unknown',
    //                     'is_featured' => false,
    //                     'is_best_seller' => false,
    //                     'is_todays_deal' => false,
    //                     'url' => route('product.detail', $product->id),
    //                     'short_description' => '',
    //                     'total_sold' => 0,
    //                 ];
    //             }
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'products' => $formattedProducts,
    //             'pagination' => [
    //                 'total' => $products->total(),
    //                 'per_page' => $products->perPage(),
    //                 'current_page' => $products->currentPage(),
    //                 'last_page' => $products->lastPage(),
    //                 'from' => $products->firstItem(),
    //                 'to' => $products->lastItem(),
    //             ],
    //         ]);
    //     } catch (\Exception $e) {
    //         \Illuminate\Support\Facades\Log::error('Filter products error: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to filter products',
    //             'error' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //         ], 500);
    //     }
    // }

    public function filterProducts(Request $request)
    {
        try {
            $query = EcommerceProduct::with([
                'warehouseProduct.brand',
                'warehouseProduct.parentCategorie',
                'warehouseProduct.subCategorie',
            ])->active();

            // Filter by categories
            if ($request->filled('categories')) {
                $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
                $categoryIds = array_map('intval', $categoryIds);

                $query->whereHas('warehouseProduct', function ($q) use ($categoryIds) {
                    $q->whereIn('parent_category_id', $categoryIds);
                });
            }

            // Filter by brands
            if ($request->filled('brands')) {
                $brandIds = is_array($request->brands) ? $request->brands : [$request->brands];
                $brandIds = array_map('intval', $brandIds);

                $query->whereHas('warehouseProduct', function ($q) use ($brandIds) {
                    $q->whereIn('brand_id', $brandIds);
                });
            }

            // Filter by predefined price ranges
            if ($request->filled('price_range')) {
                $priceRanges = is_array($request->price_range) ? $request->price_range : [$request->price_range];

                $query->where(function ($q) use ($priceRanges) {
                    foreach ($priceRanges as $range) {
                        switch ($range) {
                            case 'under_10000':
                                $q->orWhereHas('warehouseProduct', function ($wq) {
                                    $wq->where(function ($pq) {
                                        $pq->where('final_price', '>', 0)
                                            ->where('final_price', '<', 10000);
                                    })->orWhere(function ($pq) {
                                        $pq->where(function ($dpq) {
                                            $dpq->whereNull('final_price')
                                                ->orWhere('final_price', '<=', 0);
                                        })->where('selling_price', '<', 10000);
                                    });
                                });
                                break;

                            case '10000_15000':
                                $q->orWhereHas('warehouseProduct', function ($wq) {
                                    $wq->where(function ($pq) {
                                        $pq->where('final_price', '>', 0)
                                            ->whereBetween('final_price', [10000, 15000]);
                                    })->orWhere(function ($pq) {
                                        $pq->where(function ($dpq) {
                                            $dpq->whereNull('final_price')
                                                ->orWhere('final_price', '<=', 0);
                                        })->whereBetween('selling_price', [10000, 15000]);
                                    });
                                });
                                break;

                            case '15000_25000':
                                $q->orWhereHas('warehouseProduct', function ($wq) {
                                    $wq->where(function ($pq) {
                                        $pq->where('final_price', '>', 0)
                                            ->whereBetween('final_price', [15000, 25000]);
                                    })->orWhere(function ($pq) {
                                        $pq->where(function ($dpq) {
                                            $dpq->whereNull('final_price')
                                                ->orWhere('final_price', '<=', 0);
                                        })->whereBetween('selling_price', [15000, 25000]);
                                    });
                                });
                                break;

                            case 'above_35000':
                                $q->orWhereHas('warehouseProduct', function ($wq) {
                                    $wq->where(function ($pq) {
                                        $pq->where('final_price', '>', 0)
                                            ->where('final_price', '>=', 35000);
                                    })->orWhere(function ($pq) {
                                        $pq->where(function ($dpq) {
                                            $dpq->whereNull('final_price')
                                                ->orWhere('final_price', '<=', 0);
                                        })->where('selling_price', '>=', 35000);
                                    });
                                });
                                break;
                        }
                    }
                });
            }

            // Filter by custom min/max price
            if ($request->filled('min_price') || $request->filled('max_price')) {
                $minPrice = is_numeric($request->min_price) ? (float) $request->min_price : 0;
                $maxPrice = is_numeric($request->max_price) ? (float) $request->max_price : PHP_INT_MAX;

                $query->whereHas('warehouseProduct', function ($q) use ($minPrice, $maxPrice) {
                    $q->where(function ($pq) use ($minPrice, $maxPrice) {
                        $pq->where(function ($dpq) use ($minPrice, $maxPrice) {
                            $dpq->where('final_price', '>', 0)
                                ->whereBetween('final_price', [$minPrice, $maxPrice]);
                        })->orWhere(function ($spq) use ($minPrice, $maxPrice) {
                            $spq->where(function ($nullCheck) {
                                $nullCheck->whereNull('final_price')
                                    ->orWhere('final_price', '<=', 0);
                            })->whereBetween('selling_price', [$minPrice, $maxPrice]);
                        });
                    });
                });
            }

            // Today's Deal filter
            if ($request->filled('deal') && $request->deal === 'dealToday') {
                $query->where('is_todays_deal', true);
            }

            /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        | Join mat use karo, because pagination + eager loading + duplicate rows
        | ki wajah se issue aata hai.
        | Subquery based sorting use kar rahe hain.
        */
            $sort = $request->input('sort_by', '');

            switch ($sort) {
                case 'a-z':
                    $query->orderBy(
                        Product::select('product_name')
                            ->whereColumn('products.id', 'ecommerce_products.product_id')
                            ->limit(1),
                        'asc'
                    );
                    break;

                case 'z-a':
                    $query->orderBy(
                        Product::select('product_name')
                            ->whereColumn('products.id', 'ecommerce_products.product_id')
                            ->limit(1),
                        'desc'
                    );
                    break;

                case 'price-low-high':
                    $query->orderByRaw("
                    COALESCE(
                        NULLIF((SELECT final_price FROM products WHERE products.id = ecommerce_products.product_id LIMIT 1), 0),
                        (SELECT selling_price FROM products WHERE products.id = ecommerce_products.product_id LIMIT 1),
                        0
                    ) ASC
                ");
                    break;

                case 'price-high-low':
                    $query->orderByRaw("
                    COALESCE(
                        NULLIF((SELECT final_price FROM products WHERE products.id = ecommerce_products.product_id LIMIT 1), 0),
                        (SELECT selling_price FROM products WHERE products.id = ecommerce_products.product_id LIMIT 1),
                        0
                    ) DESC
                ");
                    break;

                default:
                    $query->orderBy('ecommerce_products.created_at', 'desc');
                    break;
            }

            // Paginate
            $products = $query->paginate(12);

            // Format products
            $formattedProducts = $products->getCollection()->map(function ($product) {
                $warehouseProduct = $product->warehouseProduct;
                $brand = $warehouseProduct?->brand;
                $parentCategory = $warehouseProduct?->parentCategorie;

                return [
                    'id' => $product->id,
                    'name' => $warehouseProduct->product_name ?? '',
                    'sku' => $warehouseProduct->sku ?? '',
                    'brand' => $brand->brand_title ?? '',
                    'brand_id' => $warehouseProduct->brand_id ?? null,
                    'category' => $parentCategory->parent_categories ?? '',
                    'category_id' => $warehouseProduct->parent_category_id ?? null,
                    'selling_price' => $warehouseProduct->selling_price ?? 0,
                    'discount_price' => $warehouseProduct->discount_price ?? 0,
                    'final_price' => $warehouseProduct->final_price ?? 0,
                    'main_image' => $warehouseProduct->main_product_image ?? '',
                    'stock_status' => $warehouseProduct->stock_status ?? 'Out of Stock',
                    'is_featured' => $product->is_featured ?? false,
                    'is_best_seller' => $product->is_best_seller ?? false,
                    'is_todays_deal' => $product->is_todays_deal ?? false,
                    'url' => route('product.detail', $product->id),
                    'short_description' => $warehouseProduct->short_description ?? '',
                    'total_sold' => $product->total_sold ?? 0,
                ];
            });

            return response()->json([
                'success' => true,
                'products' => $formattedProducts->values(),
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Filter products error: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to filter products',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
