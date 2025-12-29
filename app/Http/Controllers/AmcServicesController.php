<?php

namespace App\Http\Controllers;

use App\Models\AMC;
use App\Models\AmcBranch;
use App\Models\AmcEngineerAssignment;
use App\Models\AmcGroupEngineer;
use App\Models\AmcProduct;
use App\Models\AmcService;
use App\Models\AmcServiceVisit;
use App\Models\AmcVisitEngineerAssignment;
use App\Models\AmcVisitGroupEngineer;
use App\Models\Brand;
use App\Models\Engineer;
use App\Models\ParentCategorie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AmcServicesController extends Controller
{
    /**
     * Display a listing of active AMC services.
     */
    public function index()
    {
        $amcServices = AmcService::with(['amcPlan', 'branches', 'products', 'creator'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('crm/amc-services/index', compact('amcServices'));
    }

    /**
     * Display the specified active AMC service.
     */
    public function view($id)
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
            'engineerAssignments.engineer',
            'engineerAssignments.supervisor',
            'engineerAssignments.groupEngineers',
            'visits.engineer',
        ])->active()->findOrFail($id);

        $engineers = Engineer::select('id', 'first_name', 'last_name', 'designation', 'department')
            ->orderBy('first_name')
            ->get();

        return view('crm/amc-services/view', compact('amcService', 'engineers'));
    }

    /**
     * Show the form for editing the specified active AMC service.
     */
    public function edit($id)
    {
        $amcService = AmcService::with(['branches', 'products'])
            ->active()
            ->findOrFail($id);

        $amcPlans = AMC::where('status', 'Active')->get();
        $productTypes = ParentCategorie::active()->orderBy('parent_categories')->get();
        $brands = Brand::where('status', '1')->orderBy('brand_title')->get();

        return view('crm/amc-services/edit', compact('amcService', 'amcPlans', 'productTypes', 'brands'));
    }

    /**
     * Update the specified active AMC service in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $amcService = AmcService::active()->findOrFail($id);

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
                if ($amcService->profile_image && File::exists(public_path($amcService->profile_image))) {
                    File::delete(public_path($amcService->profile_image));
                }

                $file = $request->file('profile_image');
                $filename = time().'_profile.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/profiles'), $filename);
                $amcService->profile_image = 'uploads/crm/amc/profiles/'.$filename;
            }

            // Handle customer image upload
            if ($request->hasFile('customer_image')) {
                if ($amcService->customer_image && File::exists(public_path($amcService->customer_image))) {
                    File::delete(public_path($amcService->customer_image));
                }

                $file = $request->file('customer_image');
                $filename = time().'_customer.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/amc/customers'), $filename);
                $amcService->customer_image = 'uploads/crm/amc/customers/'.$filename;
            }

            $amcService->amc_plan_id = $request->amc_plan_id;
            $amcService->plan_duration = $request->plan_duration;
            $amcService->plan_start_date = $request->plan_start_date;
            $amcService->plan_end_date = $request->plan_end_date;
            $amcService->priority_level = $request->priority_level;
            $amcService->additional_notes = $request->additional_notes;
            $amcService->total_amount = $request->total_amount ?? 0;
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
            activity()->performedOn($amcService)->causedBy(Auth::user())->log('AMC Service updated');

            return redirect()->route('amc-services.index')->with('success', 'AMC Service updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Error: '.$e->getMessage())->withInput();
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Deactivate previous assignments
            AmcEngineerAssignment::where('amc_service_id', $request->amc_service_id)
                ->where('status', 'Active')
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
                $message = 'Engineer '.$engineer->first_name.' '.$engineer->last_name.' assigned successfully';
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

                $message = 'Group "'.$request->group_name.'" assigned successfully with '.count($request->engineer_ids).' engineers';
            }

            DB::commit();

            // Load relationships for response
            $assignment->load(['engineer', 'supervisor', 'groupEngineers']);

            activity()->performedOn($assignment)->causedBy(Auth::user())->log('Engineer assigned to AMC service');

            return response()->json([
                'success' => true,
                'message' => $message,
                'assignment' => $assignment,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error assigning engineer: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate visits for AMC service based on plan duration and total visits
     */
    public function generateVisits($amcServiceId)
    {
        DB::beginTransaction();
        try {
            $amcService = AmcService::with('amcPlan')->findOrFail($amcServiceId);

            // Check if visits already exist
            if ($amcService->visits()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Visits already generated for this AMC service',
                ], 400);
            }

            // Get plan details
            $planDuration = $amcService->plan_duration;
            $totalVisits = $amcService->amcPlan->total_visits ?? 0;
            $startDate = Carbon::parse($amcService->plan_start_date);

            if (! $planDuration || ! $totalVisits || $totalVisits == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid plan duration or total visits',
                ], 400);
            }

            // Calculate total months from duration
            preg_match('/\d+/', $planDuration, $matches);
            $number = isset($matches[0]) ? (int) $matches[0] : 0;

            $totalMonths = 0;
            if (stripos($planDuration, 'month') !== false) {
                $totalMonths = $number;
            } elseif (stripos($planDuration, 'year') !== false) {
                $totalMonths = $number * 12;
            } elseif (stripos($planDuration, 'day') !== false) {
                $totalMonths = $number / 30; // Approximate
            }

            if ($totalMonths == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not calculate duration in months',
                ], 400);
            }

            // Calculate interval between visits in months
            $intervalMonths = $totalMonths / $totalVisits;

            // Generate visits
            for ($i = 1; $i <= $totalVisits; $i++) {
                $visitDate = $startDate->copy()->addMonths(($i - 1) * $intervalMonths);

                AmcServiceVisit::create([
                    'amc_service_id' => $amcService->id,
                    'visit_number' => $i,
                    'scheduled_date' => $visitDate,
                    'status' => 'Pending',
                ]);
            }

            DB::commit();
            activity()->performedOn($amcService)->causedBy(Auth::user())->log('Visits generated for AMC service');

            return response()->json([
                'success' => true,
                'message' => $totalVisits.' visits generated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error generating visits: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Assign engineer to a specific visit
     */
    public function assignVisitEngineer(Request $request)
    {
        // Remove engineer_id if assignment_type is Group to avoid validation error
        if ($request->assignment_type === 'Group') {
            $request->request->remove('engineer_id');
        }

        $validator = Validator::make($request->all(), [
            'visit_id' => 'required|exists:amc_service_visits,id',
            'assignment_type' => 'required|in:Individual,Group',
            'engineer_id' => 'required_if:assignment_type,Individual|exists:engineers,id',
            'group_name' => 'required_if:assignment_type,Group',
            'engineer_ids' => 'required_if:assignment_type,Group|array',
            'engineer_ids.*' => 'exists:engineers,id',
            'supervisor_id' => 'required_if:assignment_type,Group|exists:engineers,id',
            'scheduled_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $visit = AmcServiceVisit::findOrFail($request->visit_id);
            $visit->scheduled_date = $request->scheduled_date;
            $visit->status = 'Upcoming';

            // Deactivate previous assignments for this visit
            AmcVisitEngineerAssignment::where('visit_id', $request->visit_id)
                ->where('status', 'Active')
                ->update(['status' => 'Inactive']);

            if ($request->assignment_type === 'Individual') {
                // Individual assignment
                $visit->engineer_id = $request->engineer_id;
                $visit->save();

                $assignment = AmcVisitEngineerAssignment::create([
                    'visit_id' => $request->visit_id,
                    'assignment_type' => 'Individual',
                    'engineer_id' => $request->engineer_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                $engineer = Engineer::find($request->engineer_id);
                $message = 'Engineer '.$engineer->first_name.' '.$engineer->last_name.' assigned successfully';
            } else {
                // Group assignment
                $visit->engineer_id = null; // Clear individual engineer
                $visit->save();

                $assignment = AmcVisitEngineerAssignment::create([
                    'visit_id' => $request->visit_id,
                    'assignment_type' => 'Group',
                    'group_name' => $request->group_name,
                    'supervisor_id' => $request->supervisor_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                // Add group members
                foreach ($request->engineer_ids as $engineerId) {
                    AmcVisitGroupEngineer::create([
                        'assignment_id' => $assignment->id,
                        'engineer_id' => $engineerId,
                        'is_supervisor' => ($engineerId == $request->supervisor_id),
                    ]);
                }

                $message = 'Group "'.$request->group_name.'" assigned successfully with '.count($request->engineer_ids).' engineers';
            }

            DB::commit();
            activity()->performedOn($visit)->causedBy(Auth::user())->log('Engineer assigned to visit');

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update visit engineer and date
     */
    public function updateVisitEngineer(Request $request)
    {
        // Remove engineer_id if assignment_type is Group to avoid validation error
        if ($request->assignment_type === 'Group') {
            $request->request->remove('engineer_id');
        }

        $validator = Validator::make($request->all(), [
            'visit_id' => 'required|exists:amc_service_visits,id',
            'assignment_type' => 'required|in:Individual,Group',
            'engineer_id' => 'required_if:assignment_type,Individual|exists:engineers,id',
            'group_name' => 'required_if:assignment_type,Group',
            'engineer_ids' => 'required_if:assignment_type,Group|array',
            'engineer_ids.*' => 'exists:engineers,id',
            'supervisor_id' => 'required_if:assignment_type,Group|exists:engineers,id',
            'scheduled_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $visit = AmcServiceVisit::findOrFail($request->visit_id);
            $visit->scheduled_date = $request->scheduled_date;

            // Get previous active assignment to mark as transferred
            $previousAssignment = AmcVisitEngineerAssignment::where('visit_id', $request->visit_id)
                ->where('status', 'Active')
                ->first();

            if ($request->assignment_type === 'Individual') {
                // Individual assignment
                $visit->engineer_id = $request->engineer_id;
                $visit->save();

                $assignment = AmcVisitEngineerAssignment::create([
                    'visit_id' => $request->visit_id,
                    'assignment_type' => 'Individual',
                    'engineer_id' => $request->engineer_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                $engineer = Engineer::find($request->engineer_id);
                $message = 'Engineer '.$engineer->first_name.' '.$engineer->last_name.' updated successfully';
            } else {
                // Group assignment
                $visit->engineer_id = null; // Clear individual engineer
                $visit->save();

                $assignment = AmcVisitEngineerAssignment::create([
                    'visit_id' => $request->visit_id,
                    'assignment_type' => 'Group',
                    'group_name' => $request->group_name,
                    'supervisor_id' => $request->supervisor_id,
                    'status' => 'Active',
                    'assigned_at' => now(),
                ]);

                // Add group members
                foreach ($request->engineer_ids as $engineerId) {
                    AmcVisitGroupEngineer::create([
                        'assignment_id' => $assignment->id,
                        'engineer_id' => $engineerId,
                        'is_supervisor' => ($engineerId == $request->supervisor_id),
                    ]);
                }

                $message = 'Group "'.$request->group_name.'" updated successfully with '.count($request->engineer_ids).' engineers';
            }

            // Mark previous assignment as transferred if exists
            if ($previousAssignment) {
                $previousAssignment->update([
                    'status' => 'Transferred',
                    'transferred_to' => $assignment->id,
                    'transferred_at' => now(),
                ]);
            }

            DB::commit();
            activity()->performedOn($visit)->causedBy(Auth::user())->log('Visit engineer/date updated');

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage(),
            ], 500);
        }
    }
}
