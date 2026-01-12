<?php

namespace App\Http\Controllers;

use App\Models\AMC;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Contact;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductDeal;
use App\Models\WebsiteBanner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    /**
     * Display the frontend homepage with active banners, categories, deals, and collections
     */
    public function index()
    {
        // Get only type 0 (website) active banners for the homepage carousel, ordered by display_order
        $banners = WebsiteBanner::where('is_active', '1')
            ->where('type', '0')
            ->orderBy('display_order', 'asc')
            ->get();

        // Get active parent categories for e-commerce display, ordered by sort_order
        $categories = ParentCategory::where('status', '1')
            ->orderBy('sort_order', 'asc')
            ->get();

        // Get active collections with their categories
        $collections = Collection::where('status', 'active')
            ->with('categories')
            ->orderBy('created_at', 'desc')
            ->limit(8) // Limit to 8 collections for homepage display
            ->get();

        // Get active deals that are currently running
        // $activeDeals = ProductDeal::with([
        //     'dealItems.ecommerceProduct.warehouseProduct.brand',
        //     'dealItems.ecommerceProduct.warehouseProduct',
        // ])
        //     ->where('status', 'active')
        //     ->where('offer_start_date', '<=', Carbon::now())
        //     ->where('offer_end_date', '>=', Carbon::now())
        //     ->orderBy('offer_start_date', 'desc')
        //     ->get();

        $products = Product::with(['brand', 'parentCategorie', 'subCategorie'])->get();
        // dd($products);

        return view('frontend.index', compact('banners', 'categories', 'products', 'collections'));
    }

    /**
     * Display collection details page with associated products
     */
    public function collectionDetails($id)
    {
        // Get the collection with its categories
        $collection = Collection::active()
            ->with('categories')
            ->findOrFail($id);

        // Get all products that belong to categories in this collection
        $categoryIds = $collection->categories->pluck('id');

        $products = Product::whereIn('parent_category_id', $categoryIds)
            ->where('status', 1) // Only active products
            ->with(['brand', 'parentCategorie', 'subCategorie'])
            ->paginate(20);

        return view('frontend.collection-details', compact('collection', 'products'));
    }

    public function getProduct(Request $request)
    {

        $product = Product::with(['brand', 'parentCategorie', 'subCategorie'])->findOrFail($request->id);

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * Display AMC plans page with active plans grouped by type
     */
    public function amcPlans()
    {
        // Get active AMC plans grouped by plan type
        $monthlyPlans = AMC::where('status', 'Active')
            ->where('plan_type', 'Monthly')
            ->get();

        // dd($monthlyPlans);

        $annualPlans = AMC::where('status', 'Active')
            ->where('plan_type', 'Annually')
            ->get();

        return view('frontend.amc', compact('monthlyPlans', 'annualPlans'));
    }

    /**
     * Get product categories for AMC form dropdown
     */
    public function getProductCategories()
    {
        $categories = ParentCategorie::where('status', '1')
            ->select('id', 'parent_categories as name')
            ->orderBy('parent_categories')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get brands for AMC form dropdown
     */
    public function getBrands()
    {
        $brands = Brand::select('id', 'brand_title as name')
            ->orderBy('brand_title')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $brands,
        ]);
    }

    /**
     * Get AMC plans with durations for form dropdown
     */
    public function getAmcPlansData()
    {
        $plans = AMC::where('status', 'Active')
            ->select('id', 'plan_name', 'plan_type', 'duration', 'total_cost', 'description')
            ->orderBy('plan_type')
            ->orderBy('plan_name')
            ->get()
            ->groupBy('plan_type');

        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    /**
     * Submit AMC service request form
     */
    public function submitAmcRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Step 1: Customer Details
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'pan_no' => 'required|string|max:20',
            'customer_type' => 'required|string',

            // Step 2: Company/Branch Details (if applicable)
            'company_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pin_code' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:20',

            // Step 3: Product Information (Multiple Products)
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.product_type' => 'required|string',
            'products.*.brand_name' => 'required|string',
            'products.*.model_number' => 'required|string|max:255',
            'products.*.serial_number' => 'required|string|max:255',
            'products.*.purchase_date' => 'required|date',

            // Step 4: AMC Plan Selection
            'plan_type' => 'required|in:Monthly,Annually',
            'amc_plan_id' => 'required|exists:a_m_c_s,id',
            'plan_duration' => 'required|string',
            'preferred_start_date' => 'required|date',

            // Step 5: Additional Information
            'additional_notes' => 'nullable|string',
            'terms_agreed' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Generate unique service ID
            $serviceId = $this->generateServiceId();

            // Create AMC Service
            $amcService = new \App\Models\AmcService;
            $amcService->service_id = $serviceId;
            $amcService->first_name = $request->first_name;
            $amcService->last_name = $request->last_name;
            $amcService->phone = $request->phone;
            $amcService->email = $request->email;
            $amcService->customer_type = $request->customer_type;
            $amcService->company_name = $request->company_name;
            $amcService->gst_no = $request->gst_no;
            $amcService->pan_no = $request->pan_no;

            $amcService->plan_type = $request->plan_type;
            $amcService->amc_plan_id = $request->amc_plan_id;
            $amcService->plan_duration = $request->plan_duration;
            $amcService->plan_start_date = $request->preferred_start_date;
            $amcService->additional_notes = $request->additional_notes;
            $amcService->terms_agreed = $request->terms_agreed;
            $amcService->status = 'Pending';
            $amcService->source_type = $request->source_type_label;

            // Calculate plan end date based on duration
            $startDate = \Carbon\Carbon::parse($request->preferred_start_date);
            $amcService->plan_end_date = $this->calculateEndDate($startDate, $request->plan_duration);

            // Get plan cost for total amount
            $amcPlan = AMC::find($request->amc_plan_id);
            $amcService->total_amount = $amcPlan ? $amcPlan->total_cost : 0;

            $amcService->save();

            // Create company/branch details if provided
            if ($request->filled('company_name')) {
                $branch = new \App\Models\AmcBranch;
                $branch->amc_service_id = $amcService->id;
                $branch->branch_name = $request->branch_name;
                $branch->address_line1 = $request->address_line1 ?? '';
                $branch->address_line2 = $request->address_line2 ?? '';
                $branch->city = $request->city ?? '';
                $branch->state = $request->state ?? '';
                $branch->country = $request->country ?? 'India';
                $branch->pincode = $request->pin_code ?? '';
                $branch->save();
            }

            // Create multiple product details
            $products = $request->input('products', []);
            foreach ($products as $productData) {
                $product = new \App\Models\AmcProduct;
                $product->amc_service_id = $amcService->id;
                $product->product_name = $productData['product_name'];
                $product->product_type = $productData['product_type'];
                $product->product_brand = $productData['brand_name'];
                $product->model_no = $productData['model_number'];
                $product->serial_no = $productData['serial_number'];
                $product->purchase_date = $productData['purchase_date'];
                $product->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'AMC service request submitted successfully!',
                'service_id' => $serviceId,
                'data' => $amcService,
                'products_count' => count($products),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function submitNonAmcRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|digits:10',
            'email' => 'required|email|max:255',
            'pan_no' => 'required|string|max:20',
            'customer_type' => 'required|in:Individual,Business,Corporate,SME',

            'products' => 'nullable|array|min:1',
            'products.*.product_name' => 'nullable|string',
            'products.*.product_type' => 'nullable|string',
            'products.*.product_brand' => 'nullable|string',
            'products.*.model_number' => 'nullable|string',
            'products.*.serial_number' => 'nullable|string',
            'products.*.purchase_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failedqqqqq',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Create Non-AMC Service
            $nonAmcService = new \App\Models\NonAmcService;

            // Customer Personal Information
            $nonAmcService->first_name = $request->first_name;
            $nonAmcService->last_name = $request->last_name;
            $nonAmcService->phone = $request->phone;
            $nonAmcService->email = $request->email;
            $nonAmcService->dob = $request->dob;
            $nonAmcService->gender = $request->gender;
            $nonAmcService->customer_type = $request->customer_type;
            $nonAmcService->source_type = $request->source_type_label;

            // Customer Address Information
            $nonAmcService->address_line1 = $request->address_line1;
            $nonAmcService->address_line2 = $request->address_line2;
            $nonAmcService->city = $request->city;
            $nonAmcService->state = $request->state;
            $nonAmcService->country = $request->country;
            $nonAmcService->pincode = $request->pincode;

            // Company Information (for Business customers)
            $nonAmcService->company_name = $request->company_name;
            $nonAmcService->branch_name = $request->branch_name;
            $nonAmcService->gst_no = $request->gst_no;
            $nonAmcService->pan_no = $request->pan_no;

            // Service Details
            $nonAmcService->service_type = $request->service_type ?? 'Online';
            $nonAmcService->priority_level = $request->priority_level;
            $nonAmcService->additional_notes = $request->additional_notes;
            $nonAmcService->total_amount = $request->total_amount ?? 0;

            // Status and tracking
            $nonAmcService->status = 'Pending'; // Set created_by if user is logged in

            $nonAmcService->save();

            // Create multiple product details
            $products = $request->input('products', []);
            foreach ($products as $productData) {
                $product = new \App\Models\NonAmcProduct;
                $product->non_amc_service_id = $nonAmcService->id;
                $product->product_name = $productData['product_name'];
                $product->product_type = $productData['product_type'];
                $product->product_brand = $productData['product_brand'];
                $product->model_no = $productData['model_number'];
                $product->serial_no = $productData['serial_number'];
                $product->purchase_date = $productData['purchase_date'];
                $product->issue_type = $productData['issue_type'] ?? null;
                $product->issue_description = $productData['issue_description'] ?? null;
                $product->warranty_status = $productData['warranty_status'] ?? 'Unknown';
                $product->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Non-AMC service request submitted successfully!',
                'data' => $nonAmcService,
                'products_count' => count($products),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate unique service ID
     */
    private function generateServiceId()
    {
        $year = date('Y');
        $lastService = \App\Models\AmcService::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->service_id, -4)) + 1) : 1;

        return 'SRV-'.$year.'-'.str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate plan end date based on duration
     */
    private function calculateEndDate($startDate, $duration)
    {
        $duration = strtolower($duration);

        if (strpos($duration, 'month') !== false) {
            $months = intval($duration);

            return $startDate->addMonths($months);
        } elseif (strpos($duration, 'year') !== false) {
            $years = intval($duration);

            return $startDate->addYears($years);
        }

        // Default to 1 year if duration format is unclear
        return $startDate->addYear();
    }

    public function storeContact(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        try {
            $contact = new Contact;
            $contact->first_name = $request->first_name;
            $contact->last_name = $request->last_name;
            $contact->email = $request->email;
            // The data come static data 
            $contact->subject = 'Inquiry From E-Commerce Website';
            $contact->phone = $request->phone;
            $contact->description = $request->description;
            $contact->save();

            if (! $contact) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong.',
                    ], 500);
                }

                return back()->with('error', 'Something went wrong.');
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for contacting us! We will get back to you within 24 hours.',
                ]);
            }

            return back()->with('success', 'Thank you for contacting us! We will get back to you within 24 hours.');

        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Something went wrong.');
        }
    }
}
