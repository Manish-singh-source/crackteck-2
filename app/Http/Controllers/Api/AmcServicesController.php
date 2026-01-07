<?php

namespace App\Http\Controllers\Api;

use App\Models\AmcPlan;
use App\Models\Customer;
use App\Models\Engineer;
use App\Models\AmcService;
use App\Models\CoveredItem;
use App\Models\DeliveryMan;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AmcServicesController extends Controller
{
    //
    protected function getModelByRoleId($roleId)
    {
        return [
            1 => Engineer::class,
            2 => DeliveryMan::class,
            3 => SalesPerson::class,
            4 => Customer::class,
        ][$roleId] ?? null;
    }

    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function getAmcPlans(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $amcPlans = AmcPlan::where('status', '1')->get();
            $amcPlans = $amcPlans->map(function ($row) {
                return [
                    'id' => $row->id,
                    'plan_name' => $row->plan_name,
                    'plan_code' => $row->plan_code,
                    'description' => $row->description,
                    'duration' => $row->duration,
                    'total_visits' => $row->total_visits,
                    'plan_cost' => $row->plan_cost,
                    'tax' => $row->tax,
                    'total_cost' => $row->total_cost,
                    'pay_terms' => $row->pay_terms,
                    'support_type' => $row->support_type,
                    'covered_items' => $row->covered_items->map(function ($item) {
                        $serviceType = CoveredItem::find($item->id);
                        return [
                            'id' => $serviceType->id,
                            'item_name' => $serviceType->item_name,
                            'item_description' => $serviceType->item_description,
                        ];
                    }),
                    'brochure' => $row->brochure,
                    'tandc' => $row->tandc,
                    'replacement_policy' => $row->replacement_policy,
                ];
            });

            return response()->json(['amc_plans' => $amcPlans], 200);
        }
    }

    public function generateServiceId()
    {
        $year = date('Y');
        $lastService = AmcService::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->service_id, -4)) + 1) : 1;

        return 'AMC-'.$year.'-'.str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function calculateEndDate($startDate, $duration)
    {
        $duration = strtolower($duration);
        $startDate = \Carbon\Carbon::parse($startDate);

        if (strpos($duration, 'months') !== false) {
            $months = intval($duration);

            return $startDate->addMonths($months);
        } elseif (strpos($duration, 'years') !== false) {
            $years = intval($duration);

            return $startDate->addYears($years);
        }

        // Default to 1 year if duration format is unclear
        return $startDate->addYear();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|in:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers') {
            $validator = Validator::make($request->all(), [
                // Step 1: Customer Details
                'role_id' => 'required|in:4',
                'customer_id' => 'nullable|integer',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'pan_no' => 'required|string|max:20',
                'customer_type' => 'required|string',
                'source_type_label' => 'required|string',

                // Step 2: Company/Branch Details (if applicable)
                'company_name' => 'nullable|string|max:255',
                'branch_name' => 'nullable|string|max:255',
                'address_line1' => 'nullable|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'pincode' => 'nullable|string|max:20',
                'gst_no' => 'nullable|string|max:20',

                // Step 3: Product Information (Multiple Products)
                'products' => 'required|array|min:1',   // Ensure at least one product
                'products.*.product_name' => 'required|string|max:255',
                'products.*.product_type' => 'required|string',
                'products.*.brand_name' => 'required|string',
                'products.*.model_number' => 'required|string|max:255',
                'products.*.serial_number' => 'required|string|max:255',
                'products.*.purchase_date' => 'required|date',

                // Step 4: AMC Plan Selection
                'plan_type' => 'required|in:Monthly,Annually',
                'amc_plan_id' => 'required|exists:a_m_c_s,id',
                'preferred_start_date' => 'required|date',

                // Step 5: Additional Information
                'additional_notes' => 'nullable|string',
                'terms_agreed' => 'required|accepted',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            // return response()->json(['success' => true, 'message' => $validated ], 200);

            $amcPlan = \App\Models\AMC::find($validated['amc_plan_id']);

            $amcService = new AmcService;
            $amcService->service_id = $this->generateServiceId();
            $amcService->customer_id = $validated['customer_id'] ?? null;
            $amcService->first_name = $validated['first_name'];
            $amcService->last_name = $validated['last_name'];
            $amcService->phone = $validated['phone'];
            $amcService->email = $validated['email'];
            $amcService->pan_no = $validated['pan_no'];
            $amcService->customer_type = $validated['customer_type'];
            $amcService->company_name = $validated['company_name'] ?? null;
            $amcService->gst_no = $validated['gst_no'] ?? null;
            $amcService->source_type = $validated['source_type_label'];

            $amcService->amc_plan_id = $validated['amc_plan_id'];
            $amcService->plan_type = $validated['plan_type'];
            $amcService->plan_duration = $amcPlan->duration ?? $validated['plan_duration'];
            $amcService->plan_start_date = $validated['preferred_start_date'];
            $amcService->plan_end_date = $this->calculateEndDate($validated['preferred_start_date'], $amcPlan->duration ?? $validated['plan_duration']);
            $amcService->additional_notes = $validated['additional_notes'] ?? null;
            $amcService->terms_agreed = $validated['terms_agreed'] ?? false;
            $amcService->total_amount = $amcPlan->total_cost ?? 0;
            $amcService->status = 'Pending';
            // $amcService->created_by = Auth::id() ?? $validated['created_by'] ?? null;
            $amcService->save();

            $amcBranches = new \App\Models\AmcBranch;
            $amcBranches->amc_service_id = $amcService->id;
            $amcBranches->branch_name = $validated['branch_name'] ?? null;
            $amcBranches->address_line1 = $validated['address_line1'] ?? null;
            $amcBranches->address_line2 = $validated['address_line2'] ?? null;
            $amcBranches->city = $validated['city'] ?? null;
            $amcBranches->state = $validated['state'] ?? null;
            $amcBranches->country = $validated['country'] ?? null;
            $amcBranches->pincode = $validated['pincode'] ?? null;
            $amcBranches->save();

            foreach ($validated['products'] as $product) {
                $amcProducts = new \App\Models\AmcProduct;
                $amcProducts->amc_service_id = $amcService->id;
                $amcProducts->amc_branch_id = $amcBranches->id;
                $amcProducts->product_name = $product['product_name'] ?? null;
                $amcProducts->product_type = $product['product_type'] ?? null;
                $amcProducts->product_brand = $product['brand_name'] ?? null;
                $amcProducts->model_no = $product['model_number'] ?? null;
                $amcProducts->serial_no = $product['serial_number'] ?? null;
                $amcProducts->purchase_date = $product['purchase_date'] ?? null;
                $amcProducts->save();
            }

            return response()->json(['success' => true, 'message' => 'AMC service request submitted successfully!', 'data' => $amcService]);
        }
    }
}
