<?php

namespace App\Http\Controllers;

use App\Models\AMC;
use App\Models\AmcBranch;
use App\Models\AmcPlan;
use App\Models\AmcEngineerAssignment;
use App\Models\AmcGroupEngineer;
use App\Models\AmcProduct;
use App\Models\AmcService;
use App\Models\AssignedEngineer;
use App\Models\Brand;
use App\Models\CoveredItem;
use App\Models\Customer;
use App\Models\CustomerAddressDetail;
use App\Models\CustomerCompanyDetail;
use App\Models\CustomerPanCardDetail;
use App\Models\Engineer;
use App\Models\EngineerDiagnosisDetail;
use App\Models\NonAmcEngineerAssignment;
use App\Models\NonAmcProduct;
use App\Models\NonAmcService;
use App\Models\ParentCategorie;
use App\Models\ParentCategory;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestProductPickup;
use App\Models\ServiceRequestProductRequestPart;
use App\Models\ServiceRequestProductReturn;
use App\Models\Warehouse;
use App\Helpers\StatusUpdateHelper;
use App\Models\CaseTransferRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceRequestController extends Controller
{
    public function generateServiceId()
    {
        $year = date('Y');
        $lastService = ServiceRequest::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->request_id, -4)) + 1) : 1;

        return 'SRV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    //
    public function index()
    {
        // Common relationships
        $baseQuery = ServiceRequest::with(['customer', 'products']);

        // AMC
        $amcServices = (clone $baseQuery)
            ->where('service_type', 'amc')
            ->get();

        // Installation
        $installationServices = (clone $baseQuery)
            ->where('service_type', 'installation')
            ->get();

        // Repairing
        $repairingServices = (clone $baseQuery)
            ->where('service_type', 'repairing')
            ->get();

        // Quick
        $quickServiceRequests = (clone $baseQuery)
            ->where('service_type', 'quick_service')
            ->get();

        return view('crm.service-request.index', compact(
            'amcServices',
            'installationServices',
            'repairingServices',
            'quickServiceRequests'
        ));
    }

    public function create_amc()
    {
        $amcPlans = AmcPlan::where('status', 'Active')->get();
        $amcServiceOptions = $amcPlans->pluck('plan_name', 'id')->prepend('--Select AMC Service--', '');
        $productTypes = ParentCategorie::active()->orderBy('parent_categories')->get();
        $brands = Brand::where('status', '1')->orderBy('brand_title')->get();

        return view('/crm/service-request/create-amc', compact('amcPlans', 'amcServiceOptions', 'productTypes', 'brands'));
    }

    public function store_amc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'branches' => 'required|array|min:1',
            'branches.*.branch_name' => 'required|string',
            'branches.*.address_line1' => 'required|string',
            'branches.*.city' => 'required|string',
            'branches.*.state' => 'required|string',
            'branches.*.pincode' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Create AMC Service
            $amcService = new AmcService;
            $amcService->service_id = $this->generateServiceId();
            $amcService->first_name = $request->first_name;
            $amcService->last_name = $request->last_name;
            $amcService->phone = $request->phone;
            $amcService->email = $request->email;
            $amcService->dob = $request->dob;
            $amcService->gender = $request->gender;
            $amcService->customer_type = $request->customer_type;
            $amcService->company_name = $request->company_name;
            $amcService->company_address = $request->company_address;
            $amcService->gst_no = $request->gst_no;
            $amcService->pan_no = $request->pan_no;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = time() . '_profile.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/profiles'), $filename);
                $amcService->profile_image = 'uploads/crm/amc/profiles/' . $filename;
            }

            // Handle customer image upload
            if ($request->hasFile('customer_image')) {
                $file = $request->file('customer_image');
                $filename = time() . '_customer.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/customers'), $filename);
                $amcService->customer_image = 'uploads/crm/amc/customers/' . $filename;
            }

            // AMC Details
            $amcService->amc_plan_id = $request->amc_plan_id;
            $amcService->plan_duration = $request->plan_duration;
            $amcService->plan_start_date = $request->plan_start_date;

            // Calculate end date based on duration
            if ($request->plan_start_date && $request->plan_duration) {
                $startDate = \Carbon\Carbon::parse($request->plan_start_date);
                $duration = (int) filter_var($request->plan_duration, FILTER_SANITIZE_NUMBER_INT);
                $amcService->plan_end_date = $startDate->addMonths($duration)->format('Y-m-d');
            }

            $amcService->priority_level = $request->priority_level;
            $amcService->additional_notes = $request->additional_notes;
            $amcService->total_amount = $request->total_amount ?? 0;
            $amcService->status = 'Pending';
            $amcService->created_by = Auth::id();
            $amcService->source_type = $request->source_type_label;
            $amcService->save();

            // Create Branches
            $branchMapping = []; // maps client-side branch index -> saved branch id
            if ($request->has('branches')) {
                foreach ($request->branches as $branchData) {
                    $branch = new AmcBranch;
                    $branch->amc_service_id = $amcService->id;
                    $branch->branch_name = $branchData['branch_name'];
                    $branch->address_line1 = $branchData['address_line1'];
                    $branch->address_line2 = $branchData['address_line2'] ?? null;
                    $branch->city = $branchData['city'];
                    $branch->state = $branchData['state'];
                    $branch->country = $branchData['country'] ?? 'India';
                    $branch->pincode = $branchData['pincode'];
                    $branch->contact_person = $branchData['contact_person'] ?? null;
                    $branch->contact_no = $branchData['contact_no'] ?? null;
                    $branch->save();

                    // If the client sent a temporary index for this branch (used by JS), store mapping
                    if (isset($branchData['index'])) {
                        $branchMapping[$branchData['index']] = $branch->id;
                    }
                }
            }

            // Create Products
            if ($request->has('products')) {
                foreach ($request->products as $productData) {
                    $product = new AmcProduct;
                    $product->amc_service_id = $amcService->id;

                    // The client-side sends a temporary branch reference (index). Map it to real branch id if available.
                    $rawBranchRef = $productData['amc_branch_id'] ?? null;
                    if ($rawBranchRef !== null && isset($branchMapping[$rawBranchRef])) {
                        $product->amc_branch_id = $branchMapping[$rawBranchRef];
                    } else {
                        // If mapping not available, set null to avoid FK errors (controller validation will catch inconsistencies)
                        $product->amc_branch_id = null;
                    }

                    $product->product_name = $productData['product_name'];
                    $product->product_type = $productData['product_type'] ?? null;
                    $product->product_brand = $productData['product_brand'] ?? null;
                    $product->model_no = $productData['model_no'] ?? null;
                    $product->serial_no = $productData['serial_no'] ?? null;
                    $product->purchase_date = $productData['purchase_date'] ?? null;
                    $product->warranty_status = $productData['warranty_status'] ?? null;

                    // Handle product image upload
                    if (isset($productData['product_image']) && $productData['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $productData['product_image'];
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/crm/amc/products'), $filename);
                        $product->product_image = 'uploads/crm/amc/products/' . $filename;
                    }

                    $product->save();
                }
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'AMC Request created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function view_amc($id)
    {
        $amcService = AmcService::with([
            'amcPlan',
            'branches',
            'products.type',
            'products.brand',
            'creator',
            'activeAssignment.engineer',
            'activeAssignment.supervisor',
            'activeAssignment.groupEngineers',
        ])->findOrFail($id);

        $engineers = Engineer::select('id', 'first_name', 'last_name', 'designation', 'department')
            ->orderBy('first_name')
            ->get();

        return view('/crm/service-request/view-amc', compact('amcService', 'engineers'));
    }

    public function edit_amc($id)
    {
        $amcService = AmcService::with(['branches', 'products'])->findOrFail($id);
        $amcPlans = AMC::where('status', 'Active')->get();
        $productTypes = ParentCategorie::active()->orderBy('parent_categories')->get();
        $brands = Brand::where('status', '1')->orderBy('brand_title')->get();

        return view('/crm/service-request/edit-amc', compact('amcService', 'amcPlans', 'productTypes', 'brands'));
    }

    public function update_amc(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $amcService = AmcService::findOrFail($id);

            // Update AMC Service
            $amcService->first_name = $request->first_name;
            $amcService->last_name = $request->last_name;
            $amcService->phone = $request->phone;
            $amcService->email = $request->email;
            $amcService->dob = $request->dob;
            $amcService->gender = $request->gender;
            $amcService->customer_type = $request->customer_type;
            $amcService->company_name = $request->company_name;
            $amcService->company_address = $request->company_address;
            $amcService->gst_no = $request->gst_no;
            $amcService->pan_no = $request->pan_no;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image
                if ($amcService->profile_image && File::exists(public_path($amcService->profile_image))) {
                    File::delete(public_path($amcService->profile_image));
                }

                $file = $request->file('profile_image');
                $filename = time() . '_profile.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/profiles'), $filename);
                $amcService->profile_image = 'uploads/crm/amc/profiles/' . $filename;
            }

            // Handle customer image upload
            if ($request->hasFile('customer_image')) {
                // Delete old image
                if ($amcService->customer_image && File::exists(public_path($amcService->customer_image))) {
                    File::delete(public_path($amcService->customer_image));
                }

                $file = $request->file('customer_image');
                $filename = time() . '_customer.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/customers'), $filename);
                $amcService->customer_image = 'uploads/crm/amc/customers/' . $filename;
            }

            // AMC Details
            $amcService->amc_plan_id = $request->amc_plan_id;
            $amcService->plan_duration = $request->plan_duration;
            $amcService->plan_start_date = $request->plan_start_date;

            // Calculate end date based on duration
            if ($request->plan_start_date && $request->plan_duration) {
                $startDate = \Carbon\Carbon::parse($request->plan_start_date);
                $duration = (int) filter_var($request->plan_duration, FILTER_SANITIZE_NUMBER_INT);
                $amcService->plan_end_date = $startDate->addMonths($duration)->format('Y-m-d');
            }

            $amcService->priority_level = $request->priority_level;
            $amcService->additional_notes = $request->additional_notes;
            $amcService->total_amount = $request->total_amount ?? 0;
            $amcService->status = $request->status ?? $amcService->status;
            $amcService->save();

            // Update Branches - keep existing, add new
            $existingBranchIds = [];

            // Update existing branches
            if ($request->has('existing_branches')) {
                foreach ($request->existing_branches as $branchData) {
                    if (isset($branchData['id'])) {
                        $branch = AmcBranch::find($branchData['id']);
                        if ($branch && $branch->amc_service_id == $amcService->id) {
                            // Update branch data
                            $branch->branch_name = $branchData['branch_name'];
                            $branch->address_line1 = $branchData['address_line1'];
                            $branch->address_line2 = $branchData['address_line2'] ?? null;
                            $branch->city = $branchData['city'];
                            $branch->state = $branchData['state'];
                            $branch->pincode = $branchData['pincode'];
                            $branch->contact_person = $branchData['contact_person'] ?? null;
                            $branch->contact_no = $branchData['contact_no'] ?? null;
                            $branch->save();

                            $existingBranchIds[] = $branch->id;
                        }
                    }
                }
            }

            // Add new branches
            if ($request->has('branches')) {
                foreach ($request->branches as $branchData) {
                    $branch = new AmcBranch;
                    $branch->amc_service_id = $amcService->id;
                    $branch->branch_name = $branchData['branch_name'];
                    $branch->address_line1 = $branchData['address_line1'];
                    $branch->address_line2 = $branchData['address_line2'] ?? null;
                    $branch->city = $branchData['city'];
                    $branch->state = $branchData['state'];
                    $branch->pincode = $branchData['pincode'];
                    $branch->contact_person = $branchData['contact_person'] ?? null;
                    $branch->contact_no = $branchData['contact_no'] ?? null;
                    $branch->save();

                    $existingBranchIds[] = $branch->id;
                }
            }

            // Delete branches that were removed
            $amcService->branches()->whereNotIn('id', $existingBranchIds)->delete();

            // Update Products - keep existing, add new
            $existingProductIds = [];

            // Update existing products
            if ($request->has('existing_products')) {
                foreach ($request->existing_products as $productData) {
                    if (isset($productData['id'])) {
                        $product = AmcProduct::find($productData['id']);
                        if ($product && $product->amc_service_id == $amcService->id) {
                            // Update product data
                            $product->product_name = $productData['product_name'];
                            $product->product_type = $productData['product_type'] ?? null;
                            $product->product_brand = $productData['product_brand'] ?? null;
                            $product->model_no = $productData['model_no'] ?? null;
                            $product->serial_no = $productData['serial_no'] ?? null;
                            $product->purchase_date = $productData['purchase_date'] ?? null;
                            $product->warranty_status = $productData['warranty_status'] ?? null;
                            $product->amc_branch_id = $productData['branch_id'] ?? null;
                            $product->save();

                            $existingProductIds[] = $product->id;
                        }
                    }
                }
            }

            // Add new products
            if ($request->has('products')) {
                foreach ($request->products as $productData) {
                    $product = new AmcProduct;
                    $product->amc_service_id = $amcService->id;
                    $product->amc_branch_id = $productData['branch_id'] ?? null;
                    $product->product_name = $productData['product_name'];
                    $product->product_type = $productData['product_type'] ?? null;
                    $product->product_brand = $productData['product_brand'] ?? null;
                    $product->model_no = $productData['model_no'] ?? null;
                    $product->serial_no = $productData['serial_no'] ?? null;
                    $product->purchase_date = $productData['purchase_date'] ?? null;
                    $product->warranty_status = $productData['warranty_status'] ?? null;
                    $product->save();

                    $existingProductIds[] = $product->id;
                }
            }

            // Delete products that were removed (and their images)
            $removedProducts = $amcService->products()->whereNotIn('id', $existingProductIds)->get();
            foreach ($removedProducts as $removedProduct) {
                if ($removedProduct->product_image && File::exists(public_path($removedProduct->product_image))) {
                    File::delete(public_path($removedProduct->product_image));
                }
            }
            $amcService->products()->whereNotIn('id', $existingProductIds)->delete();

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'AMC Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy_amc($id)
    {
        try {
            $amcService = AmcService::findOrFail($id);

            // Delete associated images
            if ($amcService->profile_image && File::exists(public_path($amcService->profile_image))) {
                File::delete(public_path($amcService->profile_image));
            }

            if ($amcService->customer_image && File::exists(public_path($amcService->customer_image))) {
                File::delete(public_path($amcService->customer_image));
            }

            // Delete product images
            foreach ($amcService->products as $product) {
                if ($product->product_image && File::exists(public_path($product->product_image))) {
                    File::delete(public_path($product->product_image));
                }
            }

            // Delete the AMC service (cascade will delete branches and products)
            $amcService->delete();

            return redirect()->route('service-request.index')->with('success', 'AMC Request deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // API method to fetch AMC plan details
    public function getAmcPlanDetails($id)
    {
        try {
            $amcPlan = AMC::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $amcPlan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found',
            ], 404);
        }
    }

    /**
     * Assign engineer(s) to AMC service
     */
    public function assignEngineer(Request $request)
    {
        // Remove engineer_id if assignment_type is Group to avoid validation error
        if ($request->assignment_type === 'Group') {
            $request->request->remove('engineer_id');
        }
        $validator = Validator::make($request->all(), [
            'amc_service_id' => 'required|exists:amc_services,id',
            'assignment_type' => 'required|in:Individual,Group',
            'engineer_id' => 'required_if:assignment_type,Individual|exists:engineers,id',
            'group_name' => 'required_if:assignment_type,Group',
            'engineer_ids' => 'required_if:assignment_type,Group|array',
            'engineer_ids.*' => 'exists:engineers,id',
            'supervisor_id' => 'required_if:assignment_type,Group|exists:engineers,id',
        ]);
        // Additional string validation for group_name only if Group assignment
        if ($request->assignment_type === 'Group' && isset($request->group_name) && ! is_string($request->group_name)) {
            return response()->json([
                'success' => false,
                'message' => 'The group name must be a string.',
            ], 400);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Deactivate previous assignments
            AmcEngineerAssignment::where('amc_service_id', $request->amc_service_id)
                ->update(['status' => 'Inactive']);

            if ($request->assignment_type === 'Individual') {
                // Individual assignment
                $assignment = AmcEngineerAssignment::create([
                    'amc_service_id' => $request->amc_service_id,
                    'assignment_type' => 'Individual',
                    'engineer_id' => $request->engineer_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                $engineer = Engineer::find($request->engineer_id);
                $message = 'Engineer ' . $engineer->first_name . ' ' . $engineer->last_name . ' assigned successfully';
            } else {
                // Group assignment
                $assignment = AmcEngineerAssignment::create([
                    'amc_service_id' => $request->amc_service_id,
                    'assignment_type' => 'Group',
                    'group_name' => $request->group_name,
                    'supervisor_id' => $request->supervisor_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                // Add group members
                foreach ($request->engineer_ids as $engineerId) {
                    AmcGroupEngineer::create([
                        'assignment_id' => $assignment->id,
                        'engineer_id' => $engineerId,
                        'is_supervisor' => ($engineerId == $request->supervisor_id),
                    ]);
                }

                $message = 'Group "' . $request->group_name . '" assigned successfully with ' . count($request->engineer_ids) . ' engineers';
            }

            DB::commit();

            // Load relationships for response
            $assignment->load(['engineer', 'supervisor', 'groupEngineers']);

            return response()->json([
                'success' => true,
                'message' => $message,
                'assignment' => $assignment,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error assigning engineer: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addBranch(Request $request)
    {
        $branch = AmcBranch::create($request->all());

        return response()->json($branch);
    }

    public function addProduct(Request $request)
    {
        $product = AmcProduct::create($request->all());

        return response()->json($product);
    }

    // ==================== Non-AMC Service Request CRUD Methods ====================

    public function create_non_amc()
    {
        return view('/crm/service-request/create-servies');
    }

    public function store_non_amc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Create Non-AMC Service
            $nonAmcService = new NonAmcService;
            $nonAmcService->first_name = $request->first_name;
            $nonAmcService->last_name = $request->last_name;
            $nonAmcService->phone = $request->phone;
            $nonAmcService->email = $request->email;
            $nonAmcService->dob = $request->dob;
            $nonAmcService->gender = $request->gender;
            $nonAmcService->customer_type = $request->customer_type ?? 'Individual';
            $nonAmcService->source_type = $request->source_type_label ?? 'admin_panel';

            // Address Information
            $nonAmcService->address_line1 = $request->address_line1;
            $nonAmcService->address_line2 = $request->address_line2;
            $nonAmcService->city = $request->city;
            $nonAmcService->state = $request->state;
            $nonAmcService->country = $request->country;
            $nonAmcService->pincode = $request->pincode;

            // Company Information
            $nonAmcService->company_name = $request->company_name;
            $nonAmcService->branch_name = $request->branch_name;
            $nonAmcService->gst_no = $request->gst_no;
            $nonAmcService->pan_no = $request->pan_no;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = time() . '_profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/non-amc/profiles'), $filename);
                $nonAmcService->profile_image = 'uploads/crm/non-amc/profiles/' . $filename;
            }

            // Handle customer image upload
            if ($request->hasFile('customer_image')) {
                $file = $request->file('customer_image');
                $filename = time() . '_customer_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/non-amc/customers'), $filename);
                $nonAmcService->customer_image = 'uploads/crm/non-amc/customers/' . $filename;
            }

            $nonAmcService->service_type = $request->service_type ?? 'Offline';
            $nonAmcService->priority_level = $request->priority_level;
            $nonAmcService->additional_notes = $request->additional_notes;
            $nonAmcService->total_amount = $request->total_amount ?? 0;
            $nonAmcService->status = 'Pending';
            $nonAmcService->created_by = Auth::id();
            $nonAmcService->save();

            // Create Products
            if ($request->has('products')) {
                foreach ($request->products as $productData) {
                    $product = new NonAmcProduct;
                    $product->non_amc_service_id = $nonAmcService->id;
                    $product->product_name = $productData['product_name'];
                    $product->product_type = $productData['product_type'] ?? null;
                    $product->product_brand = $productData['product_brand'] ?? null;
                    $product->model_no = $productData['model_no'] ?? null;
                    $product->serial_no = $productData['serial_no'] ?? null;
                    $product->purchase_date = $productData['purchase_date'] ?? null;
                    $product->issue_type = $productData['issue_type'] ?? null;
                    $product->issue_description = $productData['issue_description'] ?? null;
                    $product->warranty_status = $productData['warranty_status'] ?? 'Unknown';

                    // Handle product image upload
                    if (isset($productData['product_image']) && $productData['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $productData['product_image'];
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/crm/non-amc/products'), $filename);
                        $product->product_image = 'uploads/crm/non-amc/products/' . $filename;
                    }

                    $product->save();
                }
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Non-AMC Service Request created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function view_non_amc($id)
    {
        $service = NonAmcService::with(['products', 'creator', 'activeAssignment.engineer', 'activeAssignment.groupEngineers'])->findOrFail($id);
        $engineers = Engineer::select('id', 'first_name', 'last_name', 'designation', 'department')
            ->orderBy('first_name')
            ->get();

        return view('/crm/service-request/view-non-amc', compact('service', 'engineers'));
    }

    public function edit_non_amc($id)
    {
        $service = NonAmcService::with(['products'])->findOrFail($id);

        return view('/crm/service-request/edit-non-amc', compact('service'));
    }

    public function update_non_amc(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $nonAmcService = NonAmcService::findOrFail($id);

            // Update Non-AMC Service
            $nonAmcService->first_name = $request->first_name;
            $nonAmcService->last_name = $request->last_name;
            $nonAmcService->phone = $request->phone;
            $nonAmcService->email = $request->email;
            $nonAmcService->dob = $request->dob;
            $nonAmcService->gender = $request->gender;
            $nonAmcService->customer_type = $request->customer_type ?? 'Individual';

            // Address Information
            $nonAmcService->address_line1 = $request->address_line1;
            $nonAmcService->address_line2 = $request->address_line2;
            $nonAmcService->city = $request->city;
            $nonAmcService->state = $request->state;
            $nonAmcService->country = $request->country;
            $nonAmcService->pincode = $request->pincode;

            // Company Information
            $nonAmcService->company_name = $request->company_name;
            $nonAmcService->branch_name = $request->branch_name;
            $nonAmcService->gst_no = $request->gst_no;
            $nonAmcService->pan_no = $request->pan_no;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image
                if ($nonAmcService->profile_image && File::exists(public_path($nonAmcService->profile_image))) {
                    File::delete(public_path($nonAmcService->profile_image));
                }

                $file = $request->file('profile_image');
                $filename = time() . '_profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/non-amc/profiles'), $filename);
                $nonAmcService->profile_image = 'uploads/crm/non-amc/profiles/' . $filename;
            }

            // Handle customer image upload
            if ($request->hasFile('customer_image')) {
                // Delete old image
                if ($nonAmcService->customer_image && File::exists(public_path($nonAmcService->customer_image))) {
                    File::delete(public_path($nonAmcService->customer_image));
                }

                $file = $request->file('customer_image');
                $filename = time() . '_customer_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/non-amc/customers'), $filename);
                $nonAmcService->customer_image = 'uploads/crm/non-amc/customers/' . $filename;
            }

            $nonAmcService->service_type = $request->service_type ?? 'Offline';
            $nonAmcService->priority_level = $request->priority_level;
            $nonAmcService->additional_notes = $request->additional_notes;
            $nonAmcService->total_amount = $request->total_amount ?? 0;

            // Handle status change
            $oldStatus = $nonAmcService->status;
            $newStatus = $request->status ?? $nonAmcService->status;

            // If changing status from Pending to something else, clear assigned engineer
            if ($oldStatus === 'Pending' && $newStatus !== 'Pending') {
                // Status is being changed from Pending - engineer can now be assigned
                // But don't auto-assign, just allow it
            }

            // If changing status back to Pending, clear engineer assignment
            if ($oldStatus !== 'Pending' && $newStatus === 'Pending') {
                // Clear engineer assignment when status changes to Pending
                if ($nonAmcService->assigned_engineer_id) {
                    $nonAmcService->previous_engineer_id = $nonAmcService->assigned_engineer_id;
                    $nonAmcService->assigned_engineer_id = null;

                    // Mark active assignments as inactive
                    NonAmcEngineerAssignment::where('non_amc_service_id', $nonAmcService->id)
                        ->where('status', 'Active')
                        ->update(['status' => 'Inactive']);
                }
            }

            $nonAmcService->status = $newStatus;
            $nonAmcService->save();

            // Update Products - keep existing, add new
            $existingProductIds = [];

            // Update existing products
            if ($request->has('existing_products')) {
                foreach ($request->existing_products as $productData) {
                    if (isset($productData['id'])) {
                        $product = NonAmcProduct::find($productData['id']);
                        if ($product && $product->non_amc_service_id == $nonAmcService->id) {
                            $existingProductIds[] = $product->id;
                            // Existing products are kept as-is, no update needed
                        }
                    }
                }
            }

            // Add new products
            if ($request->has('products')) {
                foreach ($request->products as $productData) {
                    $product = new NonAmcProduct;
                    $product->non_amc_service_id = $nonAmcService->id;
                    $product->product_name = $productData['product_name'];
                    $product->product_type = $productData['product_type'] ?? null;
                    $product->product_brand = $productData['product_brand'] ?? null;
                    $product->model_no = $productData['model_no'] ?? null;
                    $product->serial_no = $productData['serial_no'] ?? null;
                    $product->purchase_date = $productData['purchase_date'] ?? null;
                    $product->issue_type = $productData['issue_type'] ?? null;
                    $product->issue_description = $productData['issue_description'] ?? null;
                    $product->warranty_status = $productData['warranty_status'] ?? 'Unknown';

                    // Handle product image upload
                    if (isset($productData['product_image']) && $productData['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $productData['product_image'];
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads/crm/non-amc/products'), $filename);
                        $product->product_image = 'uploads/crm/non-amc/products/' . $filename;
                    }

                    $product->save();
                    $existingProductIds[] = $product->id;
                }
            }

            // Delete products that were removed (and their images)
            $removedProducts = $nonAmcService->products()->whereNotIn('id', $existingProductIds)->get();
            foreach ($removedProducts as $removedProduct) {
                if ($removedProduct->product_image && File::exists(public_path($removedProduct->product_image))) {
                    File::delete(public_path($removedProduct->product_image));
                }
            }
            $nonAmcService->products()->whereNotIn('id', $existingProductIds)->delete();

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Non-AMC Service Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy_non_amc($id)
    {
        try {
            $nonAmcService = NonAmcService::findOrFail($id);

            // Delete associated images
            if ($nonAmcService->profile_image && File::exists(public_path($nonAmcService->profile_image))) {
                File::delete(public_path($nonAmcService->profile_image));
            }

            if ($nonAmcService->customer_image && File::exists(public_path($nonAmcService->customer_image))) {
                File::delete(public_path($nonAmcService->customer_image));
            }

            // Delete product images
            foreach ($nonAmcService->products as $product) {
                if ($product->product_image && File::exists(public_path($product->product_image))) {
                    File::delete(public_path($product->product_image));
                }
            }

            // Delete the service (products will be cascade deleted)
            $nonAmcService->delete();

            return redirect()->route('service-request.index')->with('success', 'Non-AMC Service Request deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting service request: ' . $e->getMessage());
        }
    }

    /**
     * Update/Transfer engineer for NON AMC service
     */
    public function updateNonAmcEngineer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'non_amc_service_id' => 'required|exists:non_amc_services,id',
            'engineer_id' => 'required|exists:engineers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $nonAmcService = NonAmcService::findOrFail($request->non_amc_service_id);

            // Check if status is pending
            if (! $nonAmcService->canAssignEngineer()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Engineer cannot be assigned while status is Pending. Please change the status first.',
                ], 422);
            }

            // Get previous active assignment to mark as transferred
            $previousAssignment = NonAmcEngineerAssignment::where('non_amc_service_id', $request->non_amc_service_id)
                ->where('status', 'Active')
                ->first();

            // Create new assignment
            $assignment = NonAmcEngineerAssignment::create([
                'non_amc_service_id' => $request->non_amc_service_id,
                'assignment_type' => 'Individual',
                'engineer_id' => $request->engineer_id,
                'status' => 'Active',
                'assigned_at' => now(),
            ]);

            // Mark previous assignment as transferred if exists
            if ($previousAssignment) {
                $previousAssignment->update([
                    'status' => 'Transferred',
                    'transferred_to' => $assignment->id,
                    'transferred_at' => now(),
                ]);

                // Update previous_engineer_id in service
                $nonAmcService->previous_engineer_id = $previousAssignment->engineer_id;
            }

            // Update the service with new assigned engineer
            $nonAmcService->assigned_engineer_id = $request->engineer_id;
            $nonAmcService->save();

            DB::commit();
            activity()->performedOn($nonAmcService)->causedBy(Auth::user())->log('NON AMC engineer updated/transferred');

            $engineer = Engineer::find($request->engineer_id);

            return response()->json([
                'success' => true,
                'message' => 'Engineer ' . $engineer->first_name . ' ' . $engineer->last_name . ' updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ---------------------------------------------------------- AMC Service Request Methods -----------------------------------------------------------

    public function createAmcServiceRequest()
    {
        // Get active AMC plans
        $amcService = AmcPlan::where('status', 'active')->get(); // Get as Collection
        // Prepare options for dropdown
        $amcServiceOptions = $amcService->pluck('plan_name', 'id')->prepend('--Select AMC Service--', '');

        // Get active categories
        $categories = ParentCategory::where('status', 'active')
            ->pluck('name', 'id');

        // Get active brands
        $brands = Brand::where('status', 'active')
            ->pluck('name', 'id');

        // Get all customers
        $customers = Customer::all();

        return view('crm/service-request/create-amc', compact(
            'amcService',
            'amcServiceOptions',
            'customers',
            'categories',
            'brands'
        ));
    }

    public function storeAmcServiceRequest(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'amc_plan_id' => 'required',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string',
        ]);

        // 1. Check if customer exists
        $customer = Customer::where('email', $request->email)->first();

        try {
            DB::beginTransaction();
            if (! $customer) {
                // Create new customer
                $customer = Customer::create([
                    'customer_code' => $this->generateCustomerCode(),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);

                // Store customer address
                CustomerAddressDetail::create([
                    'customer_id' => $customer->id,
                    'branch_name' => $request->branch_name,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);

                // Store company details
                CustomerCompanyDetail::create([
                    'customer_id' => $customer->id,
                    'company_name' => $request->company_name,
                    'gst_no' => $request->gst_no,
                    'pan_no' => $request->pan_no,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);
            }
            // dd($request->service_type);

            // 2. Store service request
            $serviceRequest = ServiceRequest::create([
                'request_id' => $this->generateServiceId(),
                'service_type' => $request->service_type,
                'amc_plan_id' => $request->amc_plan_id,
                'price' => $request->price,
                'customer_id' => $customer->id,
                'request_date' => now(),
                'request_status' => 'pending',
                'request_source' => 'system',
                'created_by' => Auth::id(),
            ]);

            // 3. Store products
            foreach ($request->products as $product) {
                $imagePath = null;
                if (isset($product['product_image']) && $product['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $product['product_image']->store('service-request-images', 'public');
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $product['product_name'],
                    'type' => $product['product_type'],
                    'brand' => $product['product_brand'],
                    'model_no' => $product['model_no'] ?? null,
                    'hsn' => $product['hsn'] ?? null,
                    'purchase_date' => $product['purchase_date'] ?? null,
                    'item_code_id' => $product['amc_service_id'] ?? null,
                    'service_charge' => $product['price'] ?? null,
                    'description' => $product['issue_description'] ?? null,
                    'images' => $imagePath ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Service request created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            return redirect()->back()->with('error', 'Error creating service request: ' . $e->getMessage());
        }
    }

    public function viewAmcServiceRequest($id)
    {
        $request = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'customerPan',
            'products.itemCode',
            'parentCategorie',
            'amcPlan',
            'activeAssignment.engineer',
            'activeAssignment.groupEngineers',
            'activeAssignment.transferredTo',
            'inactiveAssignments.engineer',
            'inactiveAssignments.groupEngineers',
            'inactiveAssignments.transferredTo',
        ])->findOrFail($id);
        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();
        return view('crm/service-request/view-amc-service-request', compact('request', 'engineers'));
    }

    public function editAmcServiceRequest($id, $service_type)
    {
        try {
            $request = ServiceRequest::with([
                'customer.addressDetails',
                'customer.companyDetails',
                'customer.panCardDetails',
                'products',
                'parentCategorie',
            ])->findOrFail($id);
            // dd($request);

            $service_type = $service_type;

            // same data as create
            if ($service_type != 'amc') {
                $quickService = CoveredItem::where('service_type', $service_type)->get(); // Collection
                $quickServiceOptions = $quickService
                    ->pluck('service_name', 'id', 'service_charge')
                    ->prepend('--Select Quick Service--', 0);
            }else {
                $quickService = AmcPlan::where('status', 'active')->get(); // Collection
                $quickServiceOptions = $quickService
                    ->pluck('plan_name', 'id', 'price')
                    ->prepend('--Select AMC Service--', 0);
            }

            $quickServicePrices = $quickService->pluck('service_charge', 'id');
            // dd($quickServicePrices, $quickServiceOptions);

            $categories = ParentCategory::where('status', 'active')
                ->pluck('name', 'id');

            $brands = Brand::where('status', 'active')
                ->pluck('name', 'id');

            $customers = Customer::all();

            return view('crm/service-request/edit-quick-service-request', compact(
                'request',
                'quickService',
                'quickServiceOptions',
                'quickServicePrices',
                'customers',
                'categories',
                'brands',
                'service_type'
            ));
        } catch (\Exception $e) {
            return redirect()
                ->route('service-request.index')
                ->with('error', 'Quick Service Request not found: ' . $e->getMessage());
        }
    }
    
    public function updateAmcServiceRequest(Request $request, $id)
    {
        // Basic validation
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::findOrFail($id);

            // Update service request
            $serviceRequest->update([
                'amc_plan_id' => $request->amc_plan_id,
                'price' => $request->price,
            ]);

            // Update products
            foreach ($request->products as $index => $productData) {
                if (isset($serviceRequest->products[$index])) {
                    $product = $serviceRequest->products[$index];
                    $product->update([
                        'name' => $productData['product_name'],
                        'type' => $productData['product_type'] ?? null,
                        'brand' => $productData['product_brand'] ?? null,
                        'model_no' => $productData['model_no'] ?? null,
                        'hsn' => $productData['hsn'] ?? null,
                        'purchase_date' => $productData['purchase_date'] ?? null,
                        'issue_description' => $productData['issue_description'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'AMC Service Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error updating AMC Service Request: ' . $e->getMessage())->withInput();
        }
    }


    // ---------------------------------------------------------- Installation Service Request Methods -----------------------------------------------------------

    public function createInstallationServiceRequest()
    {
        $installationService = CoveredItem::where('service_type', 'installation')->where('status', 'active')->get(); // Get as Collection
        $installationServiceOptions = $installationService->pluck('service_name', 'id')->prepend('--Select Installation Service--', 0);

        $categories = ParentCategory::where('status', 'active')
            ->pluck('name', 'id');
        $brands = Brand::where('status', 'active')->pluck('name', 'id');
        $customers = Customer::all();
        // dd($repairingService);

        return view('crm/service-request/create-installation', compact('installationService', 'installationServiceOptions', 'customers', 'categories', 'brands'));
    }

    public function storeInstallationServiceRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string',
            // Add other validations as needed
        ]);

        // 1. Check if customer exists
        $customer = Customer::where('email', $request->email)->first();

        try {
            DB::beginTransaction();
            if (! $customer) {
                // Create new customer
                $customer = Customer::create([
                    'customer_code' => $this->generateCustomerCode(),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);

                // Store customer address
                CustomerAddressDetail::create([
                    'customer_id' => $customer->id,
                    'branch_name' => $request->branch_name,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);

                // Store company details
                CustomerCompanyDetail::create([
                    'customer_id' => $customer->id,
                    'company_name' => $request->company_name,
                    'gst_no' => $request->gst_no,
                    'pan_no' => $request->pan_no,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);
            }
            // dd($request->service_type);

            // 2. Store service request
            $serviceRequest = ServiceRequest::create([
                'request_id' => $this->generateServiceId(),
                'service_type' => $request->service_type,
                'customer_id' => $customer->id,
                'request_date' => now(),
                'request_status' => 'pending',
                'request_source' => 'system',
                'created_by' => Auth::id(),
            ]);

            // 3. Store products
            foreach ($request->products as $product) {
                $imagePath = null;
                if (isset($product['product_image']) && $product['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $product['product_image']->store('service-request-images', 'public');
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $product['product_name'],
                    'type' => $product['product_type'],
                    'brand' => $product['product_brand'],
                    'model_no' => $product['model_no'] ?? null,
                    'hsn' => $product['hsn'] ?? null,
                    'purchase_date' => $product['purchase_date'] ?? null,
                    'item_code_id' => $product['installation_service_id'] ?? null,
                    'service_charge' => $product['price'] ?? null,
                    'description' => $product['issue_description'] ?? null,
                    'images' => $imagePath ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Service request created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            return redirect()->back()->with('error', 'Error creating service request: ' . $e->getMessage());
        }
    }

    public function viewInstallationServiceRequest($id)
    {
        $request = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'customerPan',
            'products.itemCode',
            'parentCategorie',
            'activeAssignment.engineer',
            'activeAssignment.groupEngineers',
            'activeAssignment.transferredTo',
            'inactiveAssignments.engineer',
            'inactiveAssignments.groupEngineers',
            'inactiveAssignments.transferredTo',
        ])->findOrFail($id);
        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();
        return view('crm/service-request/view-installation-service-request', compact('request', 'engineers'));
    }

    public function editInstallationServiceRequest($id)
    {
        try {
            $request = ServiceRequest::with([
                'customer.addressDetails',
                'customer.companyDetails',
                'customer.panCardDetails',
                'products',
                'parentCategorie',
            ])->findOrFail($id);
            // dd($request);

            // same data as create
            $installationService = CoveredItem::where('service_type', 'installation')->get(); // Collection
            $installationServiceOptions = $installationService
                ->pluck('service_name', 'id', 'service_charge')
                ->prepend('--Select Installation Service--', 0);

            $installationServicePrices = $installationService->pluck('service_charge', 'id');
            // dd($quickServicePrices, $quickServiceOptions);

            $categories = ParentCategory::where('status', 'active')
                ->pluck('name', 'id');

            $brands = Brand::where('status', 'active')
                ->pluck('name', 'id');

            $customers = Customer::all();

            return view('crm/service-request/edit-installation-service-request', compact(
                'request',
                'installationService',
                'installationServiceOptions',
                'installationServicePrices',
                'customers',
                'categories',
                'brands'
            ));
        } catch (\Exception $e) {
            return redirect()
                ->route('service-request.index')
                ->with('error', 'Installation Service Request not found: ' . $e->getMessage());
        }
    }

    public function updateInstallationServiceRequest(Request $request, $id)
    {
        // Basic validation – extend as needed
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::with(['customer', 'customerAddress', 'customerCompany', 'customerPan', 'products'])
                ->findOrFail($id);

            /*
            * 1. UPDATE / CREATE CUSTOMER (by email) + ADDRESS + COMPANY + PAN
            */
            $customer = Customer::with(['addressDetails', 'companyDetails', 'panCardDetails'])
                ->where('email', $request->email)->first();

            if ($customer) {
                $customer->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);
            }

            // Address
            $addr = $customer->addressDetails()->first() ?? new CustomerAddressDetail;
            $addr->branch_name = $request->branch_name;
            $addr->address1 = $request->address1;
            $addr->address2 = $request->address2;
            $addr->country = $request->country;
            $addr->state = $request->state;
            $addr->city = $request->city;
            $addr->pincode = $request->pincode;
            $addr->customer_id = $customer->id;
            $addr->save();

            // Company
            if (! empty($request->company_name) || ! empty($request->gst_no)) {
                $comp = $customer->companyDetails()->first() ?? new CustomerCompanyDetail;
                $comp->company_name = $request->company_name;
                $comp->gst_no = $request->gst_no;
                $comp->comp_address1 = $request->comp_address1;
                $comp->comp_address2 = $request->comp_address2;
                $comp->comp_country = $request->comp_country;
                $comp->comp_state = $request->comp_state;
                $comp->comp_city = $request->comp_city;
                $comp->comp_pincode = $request->comp_pincode;
                $comp->customer_id = $customer->id;
                $comp->save();
            }

            // PAN (if you use separate pan table)
            if (! empty($request->pan_number)) {
                $pan = $customer->panCardDetails()->first() ?? new CustomerPanCardDetail(['customer_id' => $customer->id]);
                $pan->pan_number = $request->pan_number;
                $pan->customer_id = $customer->id;
                $pan->save();
            }

            /*
            * 2. UPDATE SERVICE REQUEST HEADER
            */
            $serviceRequest->update([
                'customer_id' => $customer->id,
                'service_type' => 'installation',
                'request_source' => 'system',
                'request_date' => $serviceRequest->request_date ?? now(),
                'created_by' => $serviceRequest->created_by ?? Auth::id(),
                'status' => $request->status ?? $serviceRequest->status,
            ]);

            /*
            * 3. UPDATE PRODUCTS (simple strategy: delete old + recreate from form)
            *    This ensures quick_service_id + price (service_charge) are in sync.
            */
            // Handle existing product images deletion only if needed; here we keep them.
            $serviceRequest->products()->delete();

            foreach ($request->products as $index => $prod) {
                $imagePath = null;

                // Handle product image upload
                if (isset($prod['product_image']) && $prod['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $prod['product_image'];
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/service-request-products'), $imageName);
                    $imagePath = 'uploads/service-request-products/' . $imageName;
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $prod['product_name'] ?? null,
                    'type' => $prod['product_type'] ?? null,
                    'brand' => $prod['product_brand'] ?? null,
                    'model_no' => $prod['model_no'] ?? null,
                    'hsn' => $prod['hsn'] ?? null,
                    'purchase_date' => $prod['purchase_date'] ?? null,
                    'item_code_id' => $prod['installation_service_id'] ?? null,
                    'service_charge' => $prod['price'] ?? null,
                    'description' => $prod['issue_description'] ?? null,
                    'images' => $imagePath,
                ]);
            }

            DB::commit();

            activity()
                ->performedOn($serviceRequest)
                ->causedBy(Auth::user())
                ->log('Updated Installation Service Request #' . $serviceRequest->id);

            return redirect()
                ->route('service-request.view-installation-service-request', $serviceRequest->id)
                ->with('success', 'Installation Service Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error updating Quick Service Request: ' . $e->getMessage())
                ->withInput();
        }
    }

    // ---------------------------------------------------------- Repairing Service Request Methods -----------------------------------------------------------

    public function createRepairingServiceRequest()
    {
        $repairingService = CoveredItem::where('service_type', 'repair')->where('status', 'active')->get(); // Get as Collection
        $repairingServiceOptions = $repairingService->pluck('service_name', 'id')->prepend('--Select Repairing Service--', 0);

        $categories = ParentCategory::where('status', 'active')
            ->pluck('name', 'id');
        $brands = Brand::where('status', 'active')->pluck('name', 'id');
        $customers = Customer::all();
        // dd($repairingService);

        return view('crm/service-request/create-repairing', compact('repairingService', 'repairingServiceOptions', 'customers', 'categories', 'brands'));
    }

    public function storeRepairingServiceRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string',
            // Add other validations as needed
        ]);

        // 1. Check if customer exists
        $customer = Customer::where('email', $request->email)->first();

        try {
            DB::beginTransaction();
            if (! $customer) {
                // Create new customer
                $customer = Customer::create([
                    'customer_code' => $this->generateCustomerCode(),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);

                // Store customer address
                CustomerAddressDetail::create([
                    'customer_id' => $customer->id,
                    'branch_name' => $request->branch_name,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);

                // Store company details
                CustomerCompanyDetail::create([
                    'customer_id' => $customer->id,
                    'company_name' => $request->company_name,
                    'gst_no' => $request->gst_no,
                    'pan_no' => $request->pan_no,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);
            }
            // dd($request->service_type);

            // 2. Store service request
            $serviceRequest = ServiceRequest::create([
                'request_id' => $this->generateServiceId(),
                'service_type' => $request->service_type,
                'customer_id' => $customer->id,
                'request_date' => now(),
                'request_status' => 'pending',
                'request_source' => 'system',
                'created_by' => Auth::id(),
            ]);

            // 3. Store products
            foreach ($request->products as $product) {
                $imagePath = null;
                if (isset($product['product_image']) && $product['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $product['product_image']->store('service-request-images', 'public');
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $product['product_name'],
                    'type' => $product['product_type'],
                    'brand' => $product['product_brand'],
                    'model_no' => $product['model_no'] ?? null,
                    'hsn' => $product['hsn'] ?? null,
                    'purchase_date' => $product['purchase_date'] ?? null,
                    'item_code_id' => $product['repairing_service_id'] ?? null,
                    'service_charge' => $product['price'] ?? null,
                    'description' => $product['issue_description'] ?? null,
                    'images' => $imagePath ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Service request created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            return redirect()->back()->with('error', 'Error creating service request: ' . $e->getMessage());
        }
    }

    public function viewRepairingServiceRequest($id)
    {
        $request = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'customerPan',
            'products.itemCode',
            'parentCategorie',
            'activeAssignment.engineer',
            'activeAssignment.groupEngineers',
            'activeAssignment.transferredTo',
            'inactiveAssignments.engineer',
            'inactiveAssignments.groupEngineers',
            'inactiveAssignments.transferredTo',
        ])->findOrFail($id);
        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();
        return view('crm/service-request/view-repairing-service-request', compact('request', 'engineers'));
    }

    public function editRepairingServiceRequest($id)
    {
        try {
            $request = ServiceRequest::with([
                'customer.addressDetails',
                'customer.companyDetails',
                'customer.panCardDetails',
                'products',
                'parentCategorie',
            ])->findOrFail($id);
            // dd($request);

            // same data as create
            $repairingService = CoveredItem::where('service_type', 'repair')->get(); // Collection
            $repairingServiceOptions = $repairingService
                ->pluck('service_name', 'id', 'service_charge')
                ->prepend('--Select Repairing Service--', 0);

            $repairingServicePrices = $repairingService->pluck('service_charge', 'id');
            // dd($quickServicePrices, $quickServiceOptions);

            $categories = ParentCategory::where('status', 'active')
                ->pluck('name', 'id');

            $brands = Brand::where('status', 'active')
                ->pluck('name', 'id');

            $customers = Customer::all();

            return view('crm/service-request/edit-repairing-service-request', compact(
                'request',
                'repairingService',
                'repairingServiceOptions',
                'repairingServicePrices',
                'customers',
                'categories',
                'brands'
            ));
        } catch (\Exception $e) {
            return redirect()
                ->route('service-request.index')
                ->with('error', 'Repairing Service Request not found: ' . $e->getMessage());
        }
    }

    public function updateRepairingServiceRequest(Request $request, $id)
    {
        // Basic validation – extend as needed
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::with(['customer', 'customerAddress', 'customerCompany', 'customerPan', 'products'])
                ->findOrFail($id);

            /*
            * 1. UPDATE / CREATE CUSTOMER (by email) + ADDRESS + COMPANY + PAN
            */
            $customer = Customer::with(['addressDetails', 'companyDetails', 'panCardDetails'])
                ->where('email', $request->email)->first();

            if ($customer) {
                $customer->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);
            }

            // Address
            $addr = $customer->addressDetails()->first() ?? new CustomerAddressDetail;
            $addr->branch_name = $request->branch_name;
            $addr->address1 = $request->address1;
            $addr->address2 = $request->address2;
            $addr->country = $request->country;
            $addr->state = $request->state;
            $addr->city = $request->city;
            $addr->pincode = $request->pincode;
            $addr->customer_id = $customer->id;
            $addr->save();

            // Company
            if (! empty($request->company_name) || ! empty($request->gst_no)) {
                $comp = $customer->companyDetails()->first() ?? new CustomerCompanyDetail;
                $comp->company_name = $request->company_name;
                $comp->gst_no = $request->gst_no;
                $comp->comp_address1 = $request->comp_address1;
                $comp->comp_address2 = $request->comp_address2;
                $comp->comp_country = $request->comp_country;
                $comp->comp_state = $request->comp_state;
                $comp->comp_city = $request->comp_city;
                $comp->comp_pincode = $request->comp_pincode;
                $comp->customer_id = $customer->id;
                $comp->save();
            }

            // PAN (if you use separate pan table)
            if (! empty($request->pan_number)) {
                $pan = $customer->panCardDetails()->first() ?? new CustomerPanCardDetail(['customer_id' => $customer->id]);
                $pan->pan_number = $request->pan_number;
                $pan->customer_id = $customer->id;
                $pan->save();
            }

            /*
            * 2. UPDATE SERVICE REQUEST HEADER
            */
            $serviceRequest->update([
                'customer_id' => $customer->id,
                'service_type' => 'repairing', // Quick Service
                'request_source' => 'system',
                'request_date' => $serviceRequest->request_date ?? now(),
                'created_by' => $serviceRequest->created_by ?? Auth::id(),
                'status' => $request->status ?? $serviceRequest->status,
            ]);

            /*
            * 3. UPDATE PRODUCTS (simple strategy: delete old + recreate from form)
            *    This ensures quick_service_id + price (service_charge) are in sync.
            */
            // Handle existing product images deletion only if needed; here we keep them.
            $serviceRequest->products()->delete();

            foreach ($request->products as $index => $prod) {
                $imagePath = null;

                // Handle product image upload
                if (isset($prod['product_image']) && $prod['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $prod['product_image'];
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/service-request-products'), $imageName);
                    $imagePath = 'uploads/service-request-products/' . $imageName;
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $prod['product_name'] ?? null,
                    'type' => $prod['product_type'] ?? null,
                    'brand' => $prod['product_brand'] ?? null,
                    'model_no' => $prod['model_no'] ?? null,
                    'hsn' => $prod['hsn'] ?? null,
                    'purchase_date' => $prod['purchase_date'] ?? null,
                    'item_code_id' => $prod['repairing_service_id'] ?? null,
                    'service_charge' => $prod['price'] ?? null,
                    'description' => $prod['issue_description'] ?? null,
                    'images' => $imagePath,
                ]);
            }

            DB::commit();

            activity()
                ->performedOn($serviceRequest)
                ->causedBy(Auth::user())
                ->log('Updated Repairing Service Request #' . $serviceRequest->id);

            return redirect()
                ->route('service-request.view-repairing-service-request', $serviceRequest->id)
                ->with('success', 'Repairing Service Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error updating Quick Service Request: ' . $e->getMessage())
                ->withInput();
        }
    }

    // ------------------------------------------------------------ Quick Service Request Methods -------------------------------------------------------------

    public function createQuickServiceRequest()
    {
        $quickService = CoveredItem::where('service_type', 'quick_service')->where('status', 'active')->get(); // Get as Collection
        $quickServiceOptions = $quickService->pluck('service_name', 'id')->prepend('--Select Quick Service--', 0);

        $categories = ParentCategory::where('status', 'active')
            ->pluck('name', 'id');
        $brands = Brand::where('status', 'active')->pluck('name', 'id');
        $customers = Customer::all();
        // dd($quickService);

        return view('crm/service-request/create-quick', compact('quickService', 'quickServiceOptions', 'customers', 'categories', 'brands'));
    }

    private function generateCustomerCode()
    {
        // $customerCode = 'CUST' . str_pad((Customer::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);
        // mujhe is format me chahiye
        $customerCode = 'CUST' . str_pad((Customer::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        return $customerCode;
    }

    /**
     * Get customer addresses by email (AJAX)
     */
    public function getCustomerAddresses(Request $request)
    {
        $email = $request->email;

        \Log::info('Fetching customer addresses for email: ' . $email);

        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            \Log::warning('Customer not found for email: ' . $email);
            return response()->json(['error' => 'Customer not found'], 404);
        }

        \Log::info('Customer found: ' . $customer->id . ', fetching addresses...');

        $addresses = CustomerAddressDetail::where('customer_id', $customer->id)->get();

        \Log::info('Addresses found: ' . $addresses->count());

        return response()->json([
            'customer' => $customer,
            'addresses' => $addresses
        ]);
    }

    public function storeQuickServiceRequest(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string',
            // Add other validations as needed
        ]);

        // 1. Check if customer exists
        $customer = Customer::where('email', $request->email)->first();

        try {
            DB::beginTransaction();
            $customerAddressId = null;

            if (! $customer) {
                // Create new customer
                $customer = Customer::create([
                    'customer_code' => $this->generateCustomerCode(),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);

                // Store customer address
                $address = CustomerAddressDetail::create([
                    'customer_id' => $customer->id,
                    'branch_name' => $request->branch_name,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);
                $customerAddressId = $address->id;

                // Store company details
                CustomerCompanyDetail::create([
                    'customer_id' => $customer->id,
                    'company_name' => $request->company_name,
                    'gst_no' => $request->gst_no,
                    'pan_no' => $request->pan_no,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode,
                ]);
            } else {
                // Customer exists, use the address_id from the form
                $customerAddressId = $request->customer_address_id;
            }
            // dd($request->service_type);

            // 2. Store service request
            $serviceRequest = ServiceRequest::create([
                'request_id' => $this->generateServiceId(),
                'service_type' => $request->service_type,
                'customer_id' => $customer->id,
                'customer_address_id' => $customerAddressId,
                'request_date' => now(),
                'request_status' => 'pending',
                'request_source' => 'system',
                'created_by' => Auth::id(),
            ]);

            // 3. Store products
            foreach ($request->products as $product) {
                $imagePath = null;
                if (isset($product['product_image']) && $product['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $product['product_image']->store('service-request-images', 'public');
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $product['product_name'],
                    'type' => $product['product_type'],
                    'brand' => $product['product_brand'],
                    'model_no' => $product['model_no'] ?? null,
                    'hsn' => $product['hsn'] ?? null,
                    'purchase_date' => $product['purchase_date'] ?? null,
                    'item_code_id' => $product['quick_service_id'] ?? null,
                    'service_charge' => $product['price'] ?? null,
                    'description' => $product['issue_description'] ?? null,
                    'images' => $imagePath ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('service-request.index')->with('success', 'Service request created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());

            return redirect()->back()->with('error', 'Error creating service request: ' . $e->getMessage());
        }
    }

    public function viewQuickServiceRequest($id)
    {
        $request = ServiceRequest::with([
            'customer',
            'customerAddress',
            'customerCompany',
            'customerPan',
            'products.itemCode',
            'products.diagnosisDetails.assignedEngineer.engineer',
            'products.diagnosisDetails.coveredItem',
            'products.pickups',
            'products.requestParts', // Load request parts for each product
            'parentCategorie',
            'activeAssignment.engineer',
            // 'activeAssignment.groupEngineers',
            'activeAssignment.transferredTo',
            'inactiveAssignments.engineer',
            // 'inactiveAssignments.groupEngineers',
            'inactiveAssignments.transferredTo',
            'productReturns', // Load return diagnosis data
        ])->findOrFail($id);

        $engineers = Staff::where('staff_role', 'engineer')->where('status', 'active')->get();

        // Get active delivery men
        $deliveryMen = Staff::where('staff_role', 'delivery_man')->where('status', 'active')->get();

        // Get existing pickup records for this service request
        $pickups = ServiceRequestProductPickup::with(['serviceRequestProduct', 'assignedPerson'])
            ->where('request_id', $id)
            ->get();

        $returns = ServiceRequestProductReturn::where('status', 'accepted')->get();

        // Get warehouses with products for picking feature
        $warehouses = Warehouse::with(['products' => function($query) {
            $query->where('stock_quantity', '>', 0);
        }])->where('status', 'active')->get();

        return view('crm/service-request/view-quick-service-request', compact('request', 'engineers', 'deliveryMen', 'pickups', 'returns', 'warehouses'));
    }

    /**
     * Handle admin approval/rejection for stock_in_hand and request_part requests from diagnosis details
     */
    public function adminStockInHandApproval(Request $request)
    {
        $validated=Validator::make($request->all(),[
            'request_id' => 'required|exists:service_requests,id',
            'product_id' => 'required|exists:service_request_products,id',
            'engineer_id' => 'required|exists:staff,id',
            'part_id' => 'required',
            'admin_action' => 'required|in:admin_approved,admin_rejected',
            'request_type' => 'nullable|in:stock_in_hand,request_part',
        ]);

        if($validated->fails()){
            dd($validated->errors());
        }

        // Determine request type - default to stock_in_hand if not provided
        $requestType = $request->request_type ?? 'stock_in_hand';

        try {
            // Find the service_request_product_request_parts record
            // that matches the engineer_id (staff ID), part_id and has pending/requested status
            $requestPart = ServiceRequestProductRequestPart::where('engineer_id', $request->engineer_id)
                ->where('part_id', $request->part_id)
                ->where('request_type', $requestType)
                ->whereIn('status', ['pending', 'requested'])
                ->first();

            // If no record exists, create a new one
            if (!$requestPart) {
                // Check if there's any record at all for this engineer and part
                $existingRecord = ServiceRequestProductRequestPart::where('engineer_id', $request->engineer_id)
                    ->where('part_id', $request->part_id)
                    ->where('request_type', $requestType)
                    ->first();
                
                if ($existingRecord) {
                    // Record exists but with different status, use it
                    $requestPart = $existingRecord;
                } else {
                    // Create new record
                    $requestPart = ServiceRequestProductRequestPart::create([
                        'request_id' => $request->request_id,
                        'product_id' => $request->product_id,
                        'engineer_id' => $request->engineer_id,
                        'part_id' => $request->part_id,
                        'requested_quantity' => $request->quantity ?? 1,
                        'request_type' => $requestType,
                        'assigned_person_type' => 'engineer',
                        'assigned_person_id' => $request->engineer_id,
                        'status' => 'pending',
                    ]);
                }
            }

            if ($request->admin_action === 'admin_approved') {
                // Update status to 'admin_approved' when admin approves
                $updateData = [
                    'request_id' => $request->request_id,
                    'product_id' => $request->product_id,
                    'status' => 'admin_approved',
                    'admin_approved_at' => now(),
                ];
                
                // Update quantity if provided
                if ($request->has('quantity') && $request->quantity > 0) {
                    $updateData['requested_quantity'] = $request->quantity;
                }
                
                $requestPart->update($updateData);
                $message = 'Request approved successfully.';
            } else {
                // Update status to 'admin_rejected' when admin rejects
                $requestPart->update([
                    'request_id' => $request->request_id,
                    'product_id' => $request->product_id,
                    'status' => 'admin_rejected',
                    'admin_rejected_at' => now(),
                ]);
                $message = 'Request rejected successfully.';
            }


            return redirect()->route('service-request.view-quick-service-request', $request->request_id)
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('service-request.view-quick-service-request', $request->request_id)
                ->with('error', 'Error processing request: ' . $e->getMessage());
        }
    }

    /**
     * Assign part to engineer or delivery man after customer approval
     */
    public function assignPartToPerson(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:service_requests,id',
            'product_id' => 'required|exists:service_request_products,id',
            'request_part_id' => 'required|exists:service_request_product_request_parts,id',
            'assigned_person_type' => 'required|in:engineer,delivery_man',
            'assigned_person_id' => 'required|exists:staff,id',
        ]);

        try {
            $requestPart = ServiceRequestProductRequestPart::find($request->request_part_id);
            
            if (!$requestPart) {
                throw new \Exception('Request part not found.');
            }

            // Check if the part is customer approved
            if ($requestPart->status !== 'customer_approved') {
                throw new \Exception('Part must be customer approved before assignment.');
            }

            // Update the request part with assignment details
            $requestPart->update([
                'assigned_person_type' => $request->assigned_person_type,
                'assigned_person_id' => $request->assigned_person_id,
                'assigned_at' => now(),
                'status' => 'assigned',
            ]);

            return redirect()->route('service-request.view-quick-service-request', $request->request_id)
                ->with('success', 'Part assigned successfully.');
        } catch (\Exception $e) {
            return redirect()->route('service-request.view-quick-service-request', $request->request_id)
                ->with('error', 'Error assigning part: ' . $e->getMessage());
        }
    }

    public function editQuickServiceRequest($id, $service_type)
    {
        try {
            $request = ServiceRequest::with([
                'customer.addressDetails',
                'customer.companyDetails',
                'customer.panCardDetails',
                'products',
                'parentCategorie',
            ])->findOrFail($id);
            // dd($request);

            $service_type = $service_type;

            // same data as create
            $quickService = CoveredItem::where('service_type', $service_type)->get(); // Collection
            $quickServiceOptions = $quickService
                ->pluck('service_name', 'id', 'service_charge')
                ->prepend('--Select Quick Service--', 0);

            $quickServicePrices = $quickService->pluck('service_charge', 'id');
            // dd($quickServicePrices, $quickServiceOptions);

            $categories = ParentCategory::where('status', 'active')
                ->pluck('name', 'id');

            $brands = Brand::where('status', 'active')
                ->pluck('name', 'id');

            $customers = Customer::all();

            return view('crm/service-request/edit-quick-service-request', compact(
                'request',
                'quickService',
                'quickServiceOptions',
                'quickServicePrices',
                'customers',
                'categories',
                'brands',
                'service_type'
            ));
        } catch (\Exception $e) {
            return redirect()
                ->route('service-request.index')
                ->with('error', 'Quick Service Request not found: ' . $e->getMessage());
        }
    }

    public function updateQuickServiceRequest(Request $request, $id, $service_type)
    {
        // Basic validation – extend as needed
        $request->validate([
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::with(['customer', 'customerAddress', 'customerCompany', 'customerPan', 'products'])
                ->findOrFail($id);

            /*
            * 1. UPDATE / CREATE CUSTOMER (by email) + ADDRESS + COMPANY + PAN
            */
            $customer = Customer::with(['addressDetails', 'companyDetails', 'panCardDetails'])
                ->where('email', $request->email)->first();

            if ($customer) {
                $customer->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                ]);
            }

            // Address
            $addr = $customer->addressDetails()->first() ?? new CustomerAddressDetail;
            $addr->branch_name = $request->branch_name;
            $addr->address1 = $request->address1;
            $addr->address2 = $request->address2;
            $addr->country = $request->country;
            $addr->state = $request->state;
            $addr->city = $request->city;
            $addr->pincode = $request->pincode;
            $addr->customer_id = $customer->id;
            $addr->save();

            // Company
            if (! empty($request->company_name) || ! empty($request->gst_no)) {
                $comp = $customer->companyDetails()->first() ?? new CustomerCompanyDetail;
                $comp->company_name = $request->company_name;
                $comp->gst_no = $request->gst_no;
                $comp->comp_address1 = $request->comp_address1;
                $comp->comp_address2 = $request->comp_address2;
                $comp->comp_country = $request->comp_country;
                $comp->comp_state = $request->comp_state;
                $comp->comp_city = $request->comp_city;
                $comp->comp_pincode = $request->comp_pincode;
                $comp->customer_id = $customer->id;
                $comp->save();
            }

            // PAN (if you use separate pan table)
            if (! empty($request->pan_number)) {
                $pan = $customer->panCardDetails()->first() ?? new CustomerPanCardDetail(['customer_id' => $customer->id]);
                $pan->pan_number = $request->pan_number;
                $pan->customer_id = $customer->id;
                $pan->save();
            }

            /*
            * 2. UPDATE SERVICE REQUEST HEADER
            */
            $serviceRequest->update([
                'customer_id' => $customer->id,
                'service_type' => $service_type, // Quick Service
                'request_source' => 'system',
                'visit_date' => $request->visit_date,
                'request_date' => $serviceRequest->request_date ?? now(),
                'created_by' => $serviceRequest->created_by ?? Auth::id(),
                'status' => $request->status ?? $serviceRequest->status,
            ]);

            /*
            * 3. UPDATE PRODUCTS (simple strategy: delete old + recreate from form)
            *    This ensures quick_service_id + price (service_charge) are in sync.
            */
            // Handle existing product images deletion only if needed; here we keep them.
            $serviceRequest->products()->delete();

            foreach ($request->products as $index => $prod) {
                $imagePath = null;

                // Handle product image upload
                if (isset($prod['product_image']) && $prod['product_image'] instanceof \Illuminate\Http\UploadedFile) {
                    $file = $prod['product_image'];
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/service-request-products'), $imageName);
                    $imagePath = 'uploads/service-request-products/' . $imageName;
                }

                ServiceRequestProduct::create([
                    'service_requests_id' => $serviceRequest->id,
                    'name' => $prod['product_name'] ?? null,
                    'type' => $prod['product_type'] ?? null,
                    'brand' => $prod['product_brand'] ?? null,
                    'model_no' => $prod['model_no'] ?? null,
                    'hsn' => $prod['hsn'] ?? null,
                    'purchase_date' => $prod['purchase_date'] ?? null,
                    'item_code_id' => $prod['quick_service_id'] ?? null,   // quick service id
                    'service_charge' => $prod['price'] ?? null,              // Quick Service Price from form
                    'description' => $prod['issue_description'] ?? null,
                    'images' => $imagePath,
                    'status' => 'pending', // Set initial status as pending
                ]);

                // Update all products from pending to approved after successful update
                ServiceRequestProduct::where('service_requests_id', $serviceRequest->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'approved']);
            }

            DB::commit();

            activity()
                ->performedOn($serviceRequest)
                ->causedBy(Auth::user())
                ->log('Updated Quick Service Request #' . $serviceRequest->id);

            return redirect()
                ->route('service-request.view-quick-service-request', $serviceRequest->id)
                ->with('success', 'Quick Service Request updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error updating Quick Service Request: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroyQuickServiceRequest($id)
    {
        DB::beginTransaction();
        try {
            $quickServiceRequest = ServiceRequest::findOrFail($id);

            // Delete image if exists
            if ($quickServiceRequest->image && File::exists(public_path($quickServiceRequest->image))) {
                File::delete(public_path($quickServiceRequest->image));
            }

            // Delete the request (engineer assignments will be cascade deleted)
            $quickServiceRequest->delete();

            DB::commit();

            activity()
                ->performedOn($quickServiceRequest)
                ->causedBy(Auth::user())
                ->log('Deleted Quick Service Request #' . $quickServiceRequest->id);

            return redirect()->route('service-request.index')->with('success', 'Quick Service Request deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error deleting Quick Service Request: ' . $e->getMessage());
        }
    }

    /**
     * Submit Diagnosis for a picked product
     */
    public function submitDiagnosis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_request_id' => 'required|exists:service_requests,id',
            'service_request_product_id' => 'required|exists:service_request_products,id',
            'pickup_id' => 'required|exists:service_request_product_pickups,id',
            'diagnosis_list' => 'required|array|min:1',
            'diagnosis_list.*.component' => 'required|string',
            'diagnosis_list.*.report' => 'required|string',
            'diagnosis_list.*.status' => 'required|string',
            'diagnosis_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::findOrFail($request->service_request_id);
            $product = ServiceRequestProduct::findOrFail($request->service_request_product_id);
            $pickup = ServiceRequestProductPickup::findOrFail($request->pickup_id);

            // Check if pickup status is received
            if ($pickup->status !== 'received') {
                return response()->json([
                    'success' => false,
                    'message' => 'Diagnosis can only be submitted for pickups with received status.',
                ], 422);
            }

            // Check if product status is picked
            if ($product->status !== 'picked') {
                return response()->json([
                    'success' => false,
                    'message' => 'Product status must be picked to submit diagnosis.',
                ], 422);
            }

            // Get active assignment to get the assigned engineer
            $activeAssignment = AssignedEngineer::where('service_request_id', $request->service_request_id)
                ->where('status', 'active')
                ->first();

            $engineerId = $activeAssignment->engineer_id ?? null;

            // If no engineer from active assignment, try to get from pickup
            if (!$engineerId && $pickup->engineer_id) {
                $engineerId = $pickup->engineer_id;
            }

            // If still no engineer, use the assigned person if they're an engineer
            if (!$engineerId && $pickup->assigned_person_type === 'engineer' && $pickup->assigned_person_id) {
                $engineerId = $pickup->assigned_person_id;
            }

            // If still no engineer found, use current logged in user or 0 as fallback
            if (!$engineerId) {
                $engineerId = Auth::id() ?? 0;
            }

            // Prepare diagnosis list with all items having status 'working'
            $diagnosisList = [];
            foreach ($request->diagnosis_list as $item) {
                $diagnosisList[] = [
                    'name' => $item['component'],
                    'report' => $item['report'],
                    'status' => $item['status'] ?? 'working', // Default to working
                ];
            }

            // Find existing diagnosis detail record
            $diagnosis = EngineerDiagnosisDetail::where('service_request_id', $request->service_request_id)
                ->where('service_request_product_id', $request->service_request_product_id)
                ->first();

            // If no existing diagnosis found, return error
            if (!$diagnosis) {
                return response()->json([
                    'success' => false,
                    'message' => 'No existing diagnosis found for this product. Please contact administrator.',
                ], 422);
            }

            // Update existing diagnosis record
            $diagnosis->update([
                'covered_item_id' => $product->item_code_id,
                'diagnosis_list' => json_encode($diagnosisList),
                'diagnosis_notes' => $request->diagnosis_notes,
                'completed_at' => now(),
            ]);

            // Refresh the model to get updated values
            $diagnosis->refresh();

            // Update product status from picked to diagnosis_completed
            $product->status = 'diagnosis_completed';
            $product->save();

            // Check and update all product statuses to completed if all are diagnosis_completed
            // Also check service request completion conditions
            StatusUpdateHelper::checkAllStatusConditions($product->service_requests_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Diagnosis submitted successfully.',
                'data' => [
                    'diagnosis_id' => $diagnosis->id,
                    'product_status' => $product->status,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error submitting diagnosis: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function assignQuickServiceEngineer(Request $request)
    {
        /** ---------------- VALIDATION ---------------- */
        $rules = [
            'service_request_id' => 'required|exists:service_requests,id',
            'assignment_type'    => 'required|in:individual,group',
        ];

        if ($request->assignment_type === 'individual') {
            $rules['engineer_id'] = 'required|exists:staff,id';
        }

        if ($request->assignment_type === 'group') {
            $rules['group_name']     = 'required|string|max:255';
            $rules['engineer_ids']   = 'required|array|min:1';
            $rules['engineer_ids.*'] = 'exists:staff,id';
            $rules['supervisor_id']  = 'required|exists:staff,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::findOrFail($request->service_request_id);

            /** Only approved requests can be assigned */
            if (!in_array($serviceRequest->status, ['admin_approved', 'engineer_not_approved', 'in_transfer'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Engineer can only be assigned to approved requests.',
                ], 422);
            }

            /** ---------------- PREVIOUS ASSIGNMENT ---------------- */
            $previousAssignment = AssignedEngineer::where('service_request_id', $serviceRequest->id)
                ->where('status', 'active')
                ->first();

            if ($previousAssignment) {
                $previousAssignment->update([
                    'status' => 'inactive',
                    'transferred_at' => now(),
                ]);
            }

            /** ---------------- ASSIGN ENGINEER ---------------- */
            if ($request->assignment_type === 'individual') {

                $assignment = AssignedEngineer::create([
                    'service_request_id' => $serviceRequest->id,
                    'engineer_id'        => $request->engineer_id,
                    'assignment_type'    => 'individual',
                    'assigned_at'        => now(),
                    'status'             => 'active',
                ]);

                if ($previousAssignment) {
                    $previousAssignment->update([
                        'transferred_to' => $request->engineer_id
                    ]);
                }

                $engineer = Staff::find($request->engineer_id);
                $message = 'Engineer ' . $engineer->first_name . ' ' . $engineer->last_name . ' assigned successfully';

                /** ---------------- CASE TRANSFER UPDATE ---------------- */
                $caseTransfers = CaseTransferRequest::where('service_request_id', $serviceRequest->id)->get();
                foreach ($caseTransfers as $caseTransfer) {
                    $caseTransfer->update([
                        'new_engineer_id' => $request->engineer_id,
                        'status'          => 'approved',
                        'approved_at'     => now(),
                    ]);
                }
            } else {

                $assignment = AssignedEngineer::create([
                    'service_request_id' => $serviceRequest->id,
                    'engineer_id'        => $request->supervisor_id,
                    'assignment_type'    => 'group',
                    'group_name'         => $request->group_name,
                    'assigned_at'        => now(),
                    'status'             => 'active',
                ]);

                foreach ($request->engineer_ids as $engineerId) {
                    $assignment->groupEngineers()->attach($engineerId, [
                        'is_supervisor' => ($engineerId == $request->supervisor_id),
                    ]);
                }

                $message = 'Group "' . $request->group_name .
                    '" assigned successfully with ' . count($request->engineer_ids) . ' engineers';

                /** ---------------- CASE TRANSFER UPDATE ---------------- */
                $caseTransfer = CaseTransferRequest::where('service_request_id', $serviceRequest->id)->first();
                if ($caseTransfer) {
                    $caseTransfer->update([
                        'new_engineer_id' => $request->supervisor_id,
                        'status'          => 'approved',
                        'approved_at'     => now(),
                    ]);
                }
            }

            /** ---------------- UPDATE SERVICE REQUEST ---------------- */
            $oldStatus = $serviceRequest->status;

            $serviceRequest->update([
                'status' => 'assigned_engineer',
                'is_engineer_assigned' => 'assigned'
            ]);

            // Update all products from 'approved' to 'processing' when engineer is assigned
            ServiceRequestProduct::where('service_requests_id', $serviceRequest->id)
                ->where('status', 'approved')
                ->update(['status' => 'processing']);

            /** ---------------- LOGGING ---------------- */
            Log::info('Engineer Assigned', [
                'service_request_id' => $serviceRequest->id,
                'old_status' => $oldStatus,
                'new_status' => 'assigned_engineer',
                'assignment_id' => $assignment->id
            ]);

            activity()
                ->performedOn($serviceRequest)
                ->causedBy(Auth::user())
                ->withProperties([
                    'old_status' => $oldStatus,
                    'new_status' => 'assigned_engineer',
                    'assignment_id' => $assignment->id
                ])
                ->log('Engineer assigned to service request');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'old_status' => $oldStatus,
                'new_status' => 'assigned_engineer',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Engineer Assignment Failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error assigning engineer: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Assign pickup for a service request product.
     */
    public function assignPickup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_request_id' => 'required|exists:service_requests,id',
            'assigned_person_type' => 'required|in:delivery_man,engineer',
            'assigned_person_id' => 'required|exists:staff,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::findOrFail($request->service_request_id);

            // Only allow pickup assignment for picking status
            if ($serviceRequest->status !== 'picking') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pickup can only be assigned when service request status is picking.',
                ], 422);
            }

            // Get the active assignment for this service request
            $activeAssignment = AssignedEngineer::where('service_request_id', $serviceRequest->id)
                ->where('status', 'active')
                ->first();

            if (!$activeAssignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active engineer assignment found for this service request.',
                ], 422);
            }

            // Get diagnosis details to extract reason for picking products
            $pickingProductIds = [];
            $reason = '';
            $diagnosisDetails = EngineerDiagnosisDetail::where('service_request_id', $serviceRequest->id)
                ->get();

            foreach ($diagnosisDetails as $diagnosis) {
                if ($diagnosis->diagnosis_list) {
                    $diagnosisList = json_decode($diagnosis->diagnosis_list, true);
                    if (is_array($diagnosisList)) {
                        foreach ($diagnosisList as $item) {
                            if (isset($item['status']) && $item['status'] === 'picking') {
                                $pickingProductIds[] = $diagnosis->service_request_product_id;
                                // Extract component names and reports as reason
                                $reasonParts[] = ($item['name'] ?? '') . ': ' . ($item['report'] ?? '');
                            }
                        }
                    }
                }
            }

            if (!empty($reasonParts)) {
                $reason = implode('; ', $reasonParts);
            }

            // Check if pickup record already exists for this request
            $pickup = ServiceRequestProductPickup::where('request_id', $serviceRequest->id)
                ->first();

            if ($pickup) {
                // Update existing pickup record
                $pickup->update([
                    'assigned_person_type' => $request->assigned_person_type,
                    'assigned_person_id' => $request->assigned_person_id,
                    'status' => 'assigned',
                    'assigned_at' => now(),
                ]);
            } else {
                // Create new pickup record - use first picking product or first product
                $productId = !empty($pickingProductIds) ? $pickingProductIds[0] : ($serviceRequest->products->first()->id ?? null);

                if (!$productId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No products found for this service request.',
                    ], 422);
                }

                $pickup = ServiceRequestProductPickup::create([
                    'request_id' => $serviceRequest->id,
                    'product_id' => $productId,
                    'engineer_id' => $activeAssignment->id,
                    'reason' => $reason,
                    'assigned_person_type' => $request->assigned_person_type,
                    'assigned_person_id' => $request->assigned_person_id,
                    'status' => 'assigned',
                    'assigned_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pickup assigned successfully.',
                'pickup' => $pickup,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Pickup Assignment Failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error assigning pickup: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin action for pickup (approve/cancel).
     */
    public function pickupAdminAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_id' => 'required|exists:service_request_product_pickups,id',
            'action' => 'required|in:approved,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $pickup = ServiceRequestProductPickup::findOrFail($request->pickup_id);

            // dd($pickup);
            // Only allow admin action for pending status
            if ($pickup->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin action can only be performed when pickup status is pending.',
                ], 422);
            }

            // Update pickup status based on action
            if ($request->action === 'approved') {
                $pickup->update([
                    'status' => 'admin_approved',
                    'admin_approved_at' => now(),
                ]);
            } elseif ($request->action === 'cancelled') {
                $pickup->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pickup request ' . $request->action . ' successfully.',
                'pickup' => $pickup,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Pickup Admin Action Failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing admin action: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update pickup status to received and update product/service request status
     */
    public function pickupReceived(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_id' => 'required|exists:service_request_product_pickups,id',
            'status' => 'required|in:received',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $pickup = ServiceRequestProductPickup::findOrFail($request->pickup_id);

            // Only allow received action for picked status
            if ($pickup->status !== 'picked') {
                return response()->json([
                    'success' => false,
                    'message' => 'Received action can only be performed when pickup status is picked.',
                ], 422);
            }

            // Update pickup status to received
            $pickup->update([
                'status' => 'received',
                'received_at' => now(),
            ]);

            // Update the product status to picked
            $product = $pickup->serviceRequestProduct;
            if ($product) {
                $product->update([
                    'status' => 'picked',
                ]);
            }

            // Update the service request status to picked
            $serviceRequest = $pickup->serviceRequest;
            if ($serviceRequest) {
                $serviceRequest->update([
                    'status' => 'picked',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pickup marked as received successfully. Product and Service Request status updated to picked.',
                'pickup' => $pickup,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Pickup Received Action Failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing received action: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Assign return for a service request product.
     */
    public function assignReturn(Request $request)
    {
        // Validate assigned_person_type first
        $assignedPersonType = $request->assigned_person_type;
        if (!in_array($assignedPersonType, ['delivery_man', 'engineer'])) {
            return response()->json([
                'success' => false,
                'message' => 'Please select an Assigned Person Type (Delivery Man or Engineer)',
            ], 422);
        }

        // Validate assigned person ID based on type
        if ($assignedPersonType === 'delivery_man') {
            $validator = Validator::make($request->all(), [
                'request_id' => 'required|exists:service_requests,id',
                'product_id' => 'required|exists:service_request_products,id',
                'pickups_id' => 'required|exists:service_request_product_pickups,id',
                'assigned_person_type' => 'required|in:delivery_man,engineer',
                'delivery_man_id' => 'required|exists:staff,id',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'request_id' => 'required|exists:service_requests,id',
                'product_id' => 'required|exists:service_request_products,id',
                'pickups_id' => 'required|exists:service_request_product_pickups,id',
                'assigned_person_type' => 'required|in:delivery_man,engineer',
                'engineer_id' => 'required|exists:staff,id',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::findOrFail($request->request_id);
            $product = ServiceRequestProduct::findOrFail($request->product_id);
            $pickup = ServiceRequestProductPickup::findOrFail($request->pickups_id);

            // Get assigned person type and id
            if ($assignedPersonType === 'delivery_man') {
                $assignedPersonId = $request->delivery_man_id;
            } else {
                $assignedPersonId = $request->engineer_id;
            }

            if (empty($assignedPersonId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a ' . ($assignedPersonType === 'delivery_man' ? 'Delivery Man' : 'Engineer'),
                ], 422);
            }

            // Validate that pickup status is received
            if ($pickup->status !== 'received') {
                return response()->json([
                    'success' => false,
                    'message' => 'Return can only be assigned when pickup status is received.',
                ], 422);
            }

            // Validate that product status is diagnosis_completed
            if ($product->status !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Return can only be assigned when product status is diagnosis_completed.',
                ], 422);
            }

            // Check if return record already exists for this pickup
            $existingReturn = ServiceRequestProductReturn::where('pickups_id', $pickup->id)->first();

            if ($existingReturn) {
                return response()->json([
                    'success' => false,
                    'message' => 'Return has already been assigned for this pickup.',
                ], 422);
            }

            // Create new return record
            $return = ServiceRequestProductReturn::create([
                'request_id' => $serviceRequest->id,
                'product_id' => $product->id,
                'pickups_id' => $pickup->id,
                'assigned_person_type' => $assignedPersonType,
                'assigned_person_id' => $assignedPersonId,
                'status' => 'assigned',
                'assigned_at' => now(),
            ]);

            // Update pickup status to 'returned'
            $pickup->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            // Check and update service request status based on return/pickup/product conditions
            StatusUpdateHelper::checkAllStatusConditions($pickup->request_id);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Return assigned successfully.',
                'return' => $return,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Return Assignment Failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error assigning return: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update return status to picked.
     */
    public function returnPicked(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'return_id' => 'required|exists:service_request_product_returns,id',
            'return_status' => 'required|in:picked',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $return = ServiceRequestProductReturn::findOrFail($request->return_id);

            // Only allow picked status update when current status is accepted
            if ($return->status !== 'accepted') {
                return response()->json([
                    'success' => false,
                    'message' => 'Return status can only be updated to picked when current status is accepted.',
                ], 422);
            }

            // Update return status to picked
            $return->update([
                'status' => 'picked',
                'picked_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Return status updated to picked successfully.',
                'return' => $return,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Return Picked Update Failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating return status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark part as picked from warehouse and update status.
     */
    public function partPicked(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_part_id' => 'required|exists:service_request_product_request_parts,id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $requestPart = ServiceRequestProductRequestPart::findOrFail($request->request_part_id);

            // Check if status allows picking (should be after assigned or ap_approved)
            $allowedStatuses = ['assigned', 'ap_approved', 'warehouse_approved'];
            if (!in_array($requestPart->status, $allowedStatuses)) {
                return redirect()
                    ->back()
                    ->with('error', 'Part cannot be picked in current status: ' . $requestPart->status);
            }

            // Update status to picked and set picked_at timestamp
            $requestPart->update([
                'status' => 'picked',
                'picked_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Part marked as picked successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Part Picked Update Failed', [
                'error' => $e->getMessage(),
                'request_part_id' => $request->request_part_id
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error updating part status: ' . $e->getMessage());
        }
    }
}
