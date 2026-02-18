<?php

namespace App\Http\Controllers;

use App\Models\AMC;
use App\Models\AmcPlan;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Contact;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductDeal;
use App\Models\WebsiteBanner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $annualPlans = AmcPlan::where('status', 'Active')
            ->get();

        return view('frontend.amc', compact('annualPlans'));
    }

    /**
     * Get product categories for AMC form dropdown
     */
    public function getProductCategories()
    {
        $categories = ParentCategory::where('status', '1')
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
        $plans = AmcPlan::where('status', 'Active')
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
     * Check if customer is logged in
     */
    public function checkCustomerLogin()
    {
        if (Auth::check()) {
            $customer = Auth::user();
            
            // Get customer addresses
            $addresses = \App\Models\CustomerAddressDetail::where('customer_id', $customer->id)->get();
            
            // Get customer company details
            $companyDetails = \App\Models\CustomerCompanyDetail::where('customer_id', $customer->id)->first();
            
            return response()->json([
                'logged_in' => true,
                'customer' => [
                    'id' => $customer->id,
                    'customer_code' => $customer->customer_code,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'phone' => $customer->phone,
                    'email' => $customer->email,
                    'customer_type' => $customer->customer_type,
                ],
                'addresses' => $addresses,
                'company_details' => $companyDetails,
            ]);
        }
        
        return response()->json([
            'logged_in' => false,
        ]);
    }

    /**
     * Check if email already exists in database
     */
    public function checkCustomerEmail(Request $request)
    {
        $email = $request->email;
        
        $customer = \App\Models\Customer::where('email', $email)->first();
        
        if ($customer) {
            return response()->json([
                'success' => true,
                'exists' => true,
                'message' => 'Email already exists in our system. Please login to continue.',
            ]);
        }
        
        return response()->json([
            'success' => true,
            'exists' => false,
            'message' => 'Email is available.',
        ]);
    }

    /**
     * Get customer data by email (for logged in users or after email verification)
     */
    public function getCustomerData(Request $request)
    {
        $email = $request->email;
        
        $customer = \App\Models\Customer::where('email', $email)->first();
        
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ]);
        }
        
        // Get customer address
        $addresses = \App\Models\CustomerAddressDetail::where('customer_id', $customer->id)->get();
        
        // Get customer company details
        $companyDetails = \App\Models\CustomerCompanyDetail::where('customer_id', $customer->id)->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'customer' => $customer,
                'addresses' => $addresses,
                'company_details' => $companyDetails,
            ],
        ]);
    }

    /**
     * Submit AMC service request form
     */
    public function submitAmcRequest(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            // Step 1: Customer Details
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'customer_type' => 'nullable',
            'source_type' => 'nullable|string',

            // Step 2: Customer Address
            'branch_name' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'required|string|max:20',

            // Step 3: Company Details (Optional)
            'company_name' => 'nullable|string|max:255',
            'comp_address1' => 'nullable|string|max:255',
            'comp_address2' => 'nullable|string|max:255',
            'comp_city' => 'nullable|string|max:100',
            'comp_state' => 'nullable|string|max:100',
            'comp_country' => 'nullable|string|max:100',
            'comp_pincode' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:20',

            // Step 4: AMC Plan Selection
            'amc_plan_id' => 'required|integer|min:1',
            'preferred_start_date' => 'required|date',

            // Step 5: Product Information (Multiple Products)
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.product_type' => 'required|string',
            'products.*.brand_name' => 'required|string',
            'products.*.model_number' => 'required|string|max:255',
            'products.*.purchase_date' => 'required|date',

            // Step 6: Additional Information
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'debug' => 'Validator failed',
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        try {
            // Check if customer exists or create new one
            $customer = \App\Models\Customer::where('email', $request->email)->first();
            
            if (!$customer) {
                // Generate customer code
                $customerCode = 'CUST-' . strtoupper(uniqid());
                
                $customer = \App\Models\Customer::create([
                    'customer_code' => $customerCode,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'customer_type' => $request->customer_type,
                    'source_type' => $request->source_type ?? 'ecommerce',
                ]);
            }

            // Create or update customer address
            $customerAddress = null;
            $selectedAddressId = $request->input('selected_address_id');
            
            if ($selectedAddressId) {
                // Use existing address if selected
                $customerAddress = \App\Models\CustomerAddressDetail::find($selectedAddressId);
            }
            
            if (!$customerAddress) {
                // Create new address only if no existing address selected
                $customerAddress = \App\Models\CustomerAddressDetail::create([
                    'customer_id' => $customer->id,
                    'branch_name' => $request->branch_name ?? 'Primary',
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country ?? 'India',
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                    'is_primary' => 'yes',
                ]);
            }

            // Create customer company details if company name is provided
            if ($request->filled('company_name')) {
                \App\Models\CustomerCompanyDetail::updateOrCreate(
                    ['customer_id' => $customer->id],
                    [
                        'company_name' => $request->company_name,
                        'gst_no' => $request->gst_no,
                        'comp_address1' => $request->comp_address1,
                        'comp_address2' => $request->comp_address2,
                        'comp_country' => $request->comp_country ?? 'India',
                        'comp_state' => $request->comp_state,
                        'comp_city' => $request->comp_city,
                        'comp_pincode' => $request->comp_pincode,
                    ]
                );
            }

            // Get AMC plan details
            $amcPlan = \App\Models\AmcPlan::find($request->amc_plan_id);

            // Generate unique service ID
            $serviceId = $this->generateServiceId();

            // Create Service Request in service_requests table
            $serviceRequest = \App\Models\ServiceRequest::create([
                'request_id' => uniqid(),
                'service_type' => 'AMC',
                'customer_id' => $customer->id,
                'customer_address_id' => $customerAddress->id,
                'amc_plan_id' => $request->amc_plan_id,
                'request_date' => now(),
                'status' => 'pending',
                'request_source' => $request->source_type ?? 'customer',
                'visit_date' => $request->preferred_start_date,
            ]);

            // Create Service Request Products in service_request_products table
            $products = $request->input('products', []);
            foreach ($products as $productData) {
                \App\Models\ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $productData['product_name'],
                    'type' => $productData['product_type'],
                    'brand' => $productData['brand_name'],
                    'model_no' => $productData['model_number'],
                    'purchase_date' => $productData['purchase_date'],
                    'sku' => $productData['sku'] ?? null,
                    'hsn' => $productData['hsn'] ?? null,
                    'status' => 'Pending',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'AMC service request submitted successfully!',
                'service_id' => $serviceId,
                'data' => $serviceRequest,
                'selected_address_id' => $request->selected_address_id,
                'products_count' => count($products),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'debug' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
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
        $lastService = \App\Models\ServiceRequest::whereYear('created_at', $year)
            ->where('service_type', 'AMC')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->request_id, -4)) + 1) : 1;

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
