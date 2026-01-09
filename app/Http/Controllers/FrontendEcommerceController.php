<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\EcommerceProduct;
use App\Models\ParentCategorie;
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
            ->where('status', "1")
            ->get();

        $categories = ParentCategory::where('status_ecommerce', "1")
            ->whereHas('products', function ($query) {
                $query->whereHas('ecommerceProduct', function ($q) {
                    $q->where('status_ecommerce', "1")
                        ->whereNull('deleted_at');
                });
            })
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'image']);

        $brands = Brand::where('status', "1")
            ->whereHas('products', function ($query) {
                $query->whereHas('ecommerceProduct', function ($q) {
                    $q->where('status_ecommerce', "1")
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
            ->where('status', "1")
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
            ->where('status', "1");

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
            $brands = Brand::where('status', '1')
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
    public function filterProducts(Request $request)
    {
        try {
            $query = EcommerceProduct::with([
                'warehouseProduct.brand',
                'warehouseProduct.parentCategorie',
                'warehouseProduct.subCategorie',
            ])->active();

            // Filter by categories (multiple selection)
            if ($request->has('categories') && ! empty($request->categories)) {
                $categoryIds = is_array($request->categories) ? $request->categories : [$request->categories];
                $query->whereHas('warehouseProduct', function ($q) use ($categoryIds) {
                    $q->whereIn('parent_category_id', $categoryIds);
                });
            }

            // Filter by brands (multiple selection)
            if ($request->has('brands') && ! empty($request->brands)) {
                $brandIds = is_array($request->brands) ? $request->brands : [$request->brands];
                $query->whereHas('warehouseProduct', function ($q) use ($brandIds) {
                    $q->whereIn('brand_id', $brandIds);
                });
            }

            // Filter by price range (predefined ranges)
            if ($request->has('price_range') && ! empty($request->price_range)) {
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

            // Filter by custom price range
            if ($request->has('min_price') || $request->has('max_price')) {
                $minPrice = $request->min_price ?? 0;
                $maxPrice = $request->max_price ?? PHP_INT_MAX;

                $query->whereHas('warehouseProduct', function ($q) use ($minPrice, $maxPrice) {
                    $q->where(function ($pq) use ($minPrice, $maxPrice) {
                        // Check discount price first if it exists and is greater than 0
                        $pq->where(function ($dpq) use ($minPrice, $maxPrice) {
                            $dpq->where('final_price', '>', 0)
                                ->whereBetween('final_price', [$minPrice, $maxPrice]);
                        })
                            // Otherwise check selling price
                            ->orWhere(function ($spq) use ($minPrice, $maxPrice) {
                                $spq->where(function ($nullCheck) {
                                    $nullCheck->whereNull('final_price')
                                        ->orWhere('final_price', '<=', 0);
                                })->whereBetween('selling_price', [$minPrice, $maxPrice]);
                            });
                    });
                });
            }

            // Sorting
            if ($request->has('sort_by') && ! empty($request->sort_by)) {
                $sort = $request->input('sort_by');
                switch ($sort) {
                    case 'a-z':
                        $query->join('products', 'ecommerce_products.warehouse_product_id', '=', 'products.id')
                            ->orderBy('products.product_name', 'asc');
                        break;
                    case 'z-a':
                        $query->join('products', 'ecommerce_products.warehouse_product_id', '=', 'products.id')
                            ->orderBy('products.product_name', 'desc');
                        break;
                    case 'price-low-high':
                        $query->join('products', 'ecommerce_products.warehouse_product_id', '=', 'products.id')
                            ->orderByRaw('CASE WHEN products.final_price > 0 THEN products.final_price ELSE products.selling_price END ASC');
                        break;
                    case 'price-high-low':
                        $query->join('products', 'ecommerce_products.warehouse_product_id', '=', 'products.id')
                            ->orderByRaw('CASE WHEN products.final_price > 0 THEN products.final_price ELSE products.selling_price END DESC');
                        break;
                    default:
                        $query->join('products', 'ecommerce_products.warehouse_product_id', '=', 'products.id')
                            ->orderBy('products.product_name', 'asc');
                        break;
                }
            } else {
                $query->join('products', 'ecommerce_products.warehouse_product_id', '=', 'products.id')
                    ->orderBy('products.product_name', 'asc');
            }

            // Get filtered products
            $products = $query->paginate(12);

            // Format products for response
            $formattedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->warehouseProduct->product_name ?? '',
                    'sku' => $product->warehouseProduct->sku ?? '',
                    'brand' => $product->warehouseProduct->brand->brand_title ?? '',
                    'brand_id' => $product->warehouseProduct->brand_id ?? null,
                    'category' => $product->warehouseProduct->parentCategorie->parent_categories ?? '',
                    'category_id' => $product->warehouseProduct->parent_category_id ?? null,
                    'selling_price' => $product->warehouseProduct->selling_price ?? 0,
                    'discount_price' => $product->warehouseProduct->discount_price ?? 0,
                    'final_price' => $product->warehouseProduct->final_price ?? 0,
                    'main_image' => $product->warehouseProduct->main_product_image ?? '',
                    'stock_status' => $product->warehouseProduct->stock_status ?? 'Out of Stock',
                    'is_featured' => $product->is_featured,
                    'is_best_seller' => $product->is_best_seller,
                    'is_todays_deal' => $product->is_todays_deal,
                    'url' => route('product.detail', $product->id),
                    'short_description' => $product->warehouseProduct->short_description ?? '',
                ];
            });

            return response()->json([
                'success' => true,
                'products' => $formattedProducts,
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
            return response()->json([
                'success' => false,
                'message' => 'Failed to filter products',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
