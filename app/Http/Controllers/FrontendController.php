<?php

namespace App\Http\Controllers;

use App\Models\Amc;
use App\Models\AmcPlan;
use App\Models\AmcProduct;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Contact;
use App\Models\EcommerceProduct;
use App\Models\Lead;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\ProductDeal;
use App\Models\RemoteAmcPayment;
use App\Models\WebsiteBanner;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

class FrontendController extends Controller
{
    /**
     * Display the frontend homepage with active banners, categories, deals, and collections
     */
    public function index()
    {
        // Get only type 0 (website) active banners for the homepage carousel, ordered by display_order
        $banners = WebsiteBanner::where('is_active', '1')
            ->where('type', 'website')
            ->orderBy('display_order', 'asc')
            ->get();
        // dd($banners);

        // Get active parent categories for e-commerce display, ordered by sort_order
        $categories = ParentCategory::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->get();

        // Get active collections with their categories
        $collections = Collection::where('status', 'active')
            ->with('categories')
            ->orderBy('created_at', 'desc')
            ->limit(8) // Limit to 8 collections for homepage display
            ->get();

        //
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

        // Get featured products from ecommerce_products table
        $featuredProducts = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->where('is_featured', true)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Get suggested products from ecommerce_products table (for Toprate tab)
        $suggestedProducts = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->where('is_suggested', true)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Get today's deal products from ecommerce_products table (for Toprate tab)
        $todaysDealProducts = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->where('is_todays_deal', true)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // Get sale products (products with discount) for On-Sale tab
        $saleProducts = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->whereHas('warehouseProduct', function ($query) {
                $query->where('discount_price', '>', 0);
            })
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $products = Product::with(['brand', 'parentCategorie', 'subCategorie'])->get();

        // Get trending products (recently added products from ecommerce_products table, sorted by created_at descending)
        $trendingProducts = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get best seller products from ecommerce_products table
        $bestSellerProducts = EcommerceProduct::with(['warehouseProduct.brand', 'warehouseProduct.parentCategorie'])
            ->where('is_best_seller', true)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('frontend.index', compact('banners', 'categories', 'products', 'collections', 'featuredProducts', 'suggestedProducts', 'todaysDealProducts', 'saleProducts', 'trendingProducts', 'bestSellerProducts'));
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

        return view('remote-amc', compact('annualPlans'));
    }

    /**
     * Display Remote AMC plans page with active plans filtered by support_type = 'remote'
     */
    public function remoteAmcPlans()
    {
        $annualPlans = AmcPlan::where('status', 'Active')
            ->where('support_type', 'remote')
            ->get();

        return view('frontend.remote-amc', compact('annualPlans'));
    }

    /**
     * Display Onsite AMC plans page with active plans filtered by support_type = 'onsite'
     */
    public function onsiteAmcPlans()
    {
        $annualPlans = AmcPlan::where('status', 'Active')
            ->where('support_type', 'onsite')
            ->get();

        return view('frontend.onsite-amc', compact('annualPlans'));
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
     * Get device types from device_specific_diagnoses table
     */
    public function getDeviceTypes()
    {
        $deviceTypes = \App\Models\DeviceSpecificDiagnosis::select('id', 'device_type')
            ->orderBy('device_type')
            ->distinct()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $deviceTypes,
        ]);
    }

    /**
     * Check if customer is logged in
     */
    public function checkCustomerLogin()
    {
        if (Auth::guard('customer_web')->check()) {
            $customer = Auth::guard('customer_web')->user();

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

        if (! $customer) {
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
        $validator = Validator::make($request->all(), [
            // Step 1: Customer Details
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'customer_type' => 'nullable',
            'source_type' => 'nullable|string',
            'amc_type' => 'required|in:remote,onsite',

            // Step 2: Customer Address (required for onsite, optional for remote)
            'branch_name' => 'required_if:amc_type,onsite|string|max:255|nullable',
            'address1' => 'required_if:amc_type,onsite|string|max:255|nullable',
            'address2' => 'nullable|string|max:255',
            'city' => 'required_if:amc_type,onsite|string|max:100|nullable',
            'state' => 'required_if:amc_type,onsite|string|max:100|nullable',
            'country' => 'nullable|string|max:100',
            'pincode' => 'required_if:amc_type,onsite|string|max:20|nullable',

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
            // 'preferred_start_date' => 'required|date',

            // Step 5: Product Information (Multiple Products)
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.product_type' => 'required|string',
            'products.*.brand_name' => 'required|string',
            'products.*.model_number' => 'required|string|max:255',
            'products.*.mac_address' => 'required|string|max:255',
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
            $result = DB::transaction(function () use ($request) {
                $customer = \App\Models\Customer::where('email', $request->email)->first();

                if (! $customer) {
                    $customer = \App\Models\Customer::create([
                        'customer_code' => 'CUST-' . strtoupper(uniqid()),
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'customer_type' => $request->customer_type,
                        'source_type' => $request->source_type ?? 'ecommerce',
                    ]);
                }

                $customerAddress = null;
                $selectedAddressId = $request->input('selected_address_id');

                if ($request->amc_type !== 'remote') {
                    if ($selectedAddressId) {
                        $customerAddress = \App\Models\CustomerAddressDetail::find($selectedAddressId);
                    }

                    if (! $customerAddress) {
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
                }

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

                $amcPlan = AmcPlan::findOrFail($request->amc_plan_id);
                $paymentAmount = $request->amc_type === 'remote' ? $this->calculateAmcPlanAmountInPaise($amcPlan) : 0;
                $paymentCurrency = config('services.razorpay.currency', 'INR');

                $amc = Amc::create([
                    'request_id' => uniqid('SR-'),
                    'service_type' => 'amc',
                    'amc_type' => $request->amc_type,
                    'customer_id' => $customer->id,
                    'customer_address_id' => $customerAddress ? $customerAddress->id : null,
                    'amc_plan_id' => $request->amc_plan_id,
                    'request_date' => now(),
                    'request_source' => $request->source_type ?? 'customer',
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_amount' => $paymentAmount,
                    'payment_currency' => $paymentCurrency,
                    'created_by' => Auth::id(),
                ]);

                $monthGapFloat = intval($amcPlan->duration) / max(1, intval($amcPlan->total_visits));
                $monthGap = (int) round($monthGapFloat);
                $startVisitDate = $request->preferred_start_date ? \Carbon\Carbon::parse($request->preferred_start_date) : \Carbon\Carbon::now();
                $nextVisitDate = $startVisitDate->copy()->addMonths($monthGap);

                foreach (range(1, $amcPlan->total_visits) as $visitNumber) {
                    $amc->amcScheduleMeetings()->create([
                        'amc_id' => $amc->id,
                        'scheduled_at' => $nextVisitDate,
                        'completed_at' => null,
                        'remarks' => null,
                        'report' => null,
                        'visits_count' => $visitNumber,
                        'status' => 'scheduled',
                    ]);

                    $nextVisitDate = $nextVisitDate->addMonths($monthGap);
                }

                $products = $request->input('products', []);
                foreach ($products as $productData) {
                    AmcProduct::create([
                        'amc_id' => $amc->id,
                        'name' => $productData['product_name'],
                        'type' => $productData['product_type'],
                        'brand' => $productData['brand_name'],
                        'model_no' => $productData['model_number'],
                        'purchase_date' => $productData['purchase_date'],
                        'sku' => $productData['sku'] ?? null,
                        'hsn' => $productData['hsn'] ?? null,
                        'mac_address' => $productData['mac_address'] ?? null,
                    ]);
                }

                if ($request->amc_type === 'onsite') {
                    Lead::create([
                        'customer_id' => $customer->id,
                        'staff_id' => null,
                        'customer_address_id' => $customerAddress ? $customerAddress->id : null,
                        'lead_number' => uniqid(),
                        'requirement_type' => 'amc',
                        'budget_range' => null,
                        'estimated_value' => null,
                        'notes' => $request->additional_notes ?? null,
                    ]);
                }

                $response = [
                    'amc' => $amc->fresh(),
                    'products_count' => count($products),
                    'selected_address_id' => $request->selected_address_id,
                    'requires_payment' => false,
                    'payment' => null,
                ];

                if ($request->amc_type === 'remote') {
                    $payment = $this->createRemoteAmcPaymentOrder($amc, $customer, $amcPlan);

                    $response['requires_payment'] = true;
                    $response['payment'] = [
                        'id' => $payment->id,
                        'payment_reference' => $payment->payment_reference,
                        'amount_paise' => $payment->amount,
                        'currency' => $payment->currency,
                        'razorpay' => [
                            'key_id' => config('services.razorpay.key_id'),
                            'order_id' => $payment->gateway_order_id,
                            'amount' => $payment->amount,
                            'currency' => $payment->currency,
                        ],
                    ];
                }

                return $response;
            });

            if ($result['requires_payment']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Remote AMC request created. Complete the payment to activate your plan.',
                    'service_id' => $result['amc']->id,
                    'data' => $result['amc'],
                    'selected_address_id' => $result['selected_address_id'],
                    'products_count' => $result['products_count'],
                    'requires_payment' => true,
                    'payment' => $result['payment'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'AMC service request submitted successfully!',
                'service_id' => $result['amc']->id,
                'data' => $result['amc'],
                'selected_address_id' => $result['selected_address_id'],
                'products_count' => $result['products_count'],
                'requires_payment' => false,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'debug' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function verifyRemoteAmcPayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'remote_amc_payment_id' => 'required|integer|exists:remote_amc_payments,id',
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $payment = RemoteAmcPayment::with('amc')
            ->whereKey($validated['remote_amc_payment_id'])
            ->where('gateway_order_id', $validated['razorpay_order_id'])
            ->firstOrFail();

        try {
            $verifiedPayment = DB::transaction(function () use ($payment, $validated) {
                $api = app(Api::class);

                $api->utility->verifyPaymentSignature([
                    'razorpay_order_id' => $validated['razorpay_order_id'],
                    'razorpay_payment_id' => $validated['razorpay_payment_id'],
                    'razorpay_signature' => $validated['razorpay_signature'],
                ]);

                $gatewayPayment = $api->payment->fetch($validated['razorpay_payment_id'])->toArray();
                $status = $gatewayPayment['status'] ?? 'authorized';
                $isPaid = in_array($status, ['authorized', 'captured'], true);

                $payment->forceFill([
                    'gateway_payment_id' => $validated['razorpay_payment_id'],
                    'gateway_signature' => $validated['razorpay_signature'],
                    'status' => $status,
                    'method' => $gatewayPayment['method'] ?? null,
                    'gateway_payload' => $gatewayPayment,
                    'paid_at' => $isPaid ? now() : $payment->paid_at,
                    'failed_at' => $status === 'failed' ? now() : $payment->failed_at,
                ])->save();

                $payment->amc->forceFill([
                    'status' => $isPaid ? 'active' : 'pending',
                    'payment_status' => $isPaid ? 'paid' : ($status === 'failed' ? 'failed' : 'pending'),
                    'paid_at' => $isPaid ? now() : $payment->amc->paid_at,
                ])->save();

                return $payment->fresh(['amc']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully. Your Remote AMC plan is now active.',
                'data' => [
                    'payment' => $verifiedPayment,
                    'amc' => $verifiedPayment->amc,
                ],
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to verify the Razorpay payment.',
                'error' => $exception->getMessage(),
            ], 422);
        }
    }

    private function calculateAmcPlanAmountInPaise(AmcPlan $amcPlan): int
    {
        return (int) round(((float) $amcPlan->total_cost) * 100);
    }

    private function createRemoteAmcPaymentOrder(Amc $amc, \App\Models\Customer $customer, AmcPlan $amcPlan): RemoteAmcPayment
    {
        $api = app(Api::class);
        $amount = $this->calculateAmcPlanAmountInPaise($amcPlan);
        $currency = config('services.razorpay.currency', 'INR');

        $gatewayOrder = $api->order->create([
            'amount' => $amount,
            'currency' => $currency,
            'receipt' => $amc->request_id,
            'payment_capture' => config('services.razorpay.auto_capture', true) ? 1 : 0,
            'notes' => array_filter([
                'amc_id' => (string) $amc->getKey(),
                'request_id' => $amc->request_id,
                'customer_id' => (string) $customer->getKey(),
                'customer_email' => $customer->email,
                'amc_type' => $amc->amc_type,
                'plan_name' => $amcPlan->plan_name,
            ], static fn ($value) => $value !== null && $value !== ''),
        ])->toArray();

        return RemoteAmcPayment::create([
            'amc_id' => $amc->id,
            'customer_id' => $customer->id,
            'amc_plan_id' => $amcPlan->id,
            'payment_reference' => 'RAMP-' . strtoupper(uniqid()),
            'gateway' => 'razorpay',
            'gateway_order_id' => $gatewayOrder['id'],
            'amount' => $gatewayOrder['amount'],
            'currency' => $gatewayOrder['currency'] ?? $currency,
            'status' => $gatewayOrder['status'] ?? 'created',
            'gateway_payload' => $gatewayOrder,
        ]);
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

        return 'SRV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
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

