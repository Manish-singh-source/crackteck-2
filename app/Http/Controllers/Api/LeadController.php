<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Models\Customer;
use App\Models\CustomerAddressDetail;
use App\Models\Lead;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    //
    /**
     * Get all leads for a user
     * description: Get all leads for a user
     *
     * @return void
     */
    public function index(Request $request)
    {
        // Create validator
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $roleCheck = Staff::where('id', $request->user_id)->first();

        if ($roleCheck->staff_role != 'sales_person') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a sales person.',
            ], 403);
        }

        // Get validated data as array
        $validatedData = $validator->validated();

        // Query leads
        $leads = Lead::with('customer', 'companyDetails')->where('staff_id', $validatedData['user_id'])->paginate();

        // Return paginated leads as resource collection
        return LeadResource::collection($leads);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Customer fields
            'user_id' => 'required',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:10',
            'email' => 'required|email',

            // Address fields
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'nullable|string',
            'pincode' => 'required|string',

            // Lead fields
            'requirement_type' => 'required|string',
            'budget_range' => 'required|string',
            'urgency' => 'required|in:low,medium,high,critical',
            'notes' => 'nullable|string',
            // 'status' => 'nullable|in:new,contacted,qualified,proposal,won,lost,nurture',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Generate customer code in incremental format
            $lastCustomer = Customer::orderBy('id', 'desc')->first();
            $lastCustomerCode = $lastCustomer?->customer_code ?? 'CUST0000';
            $customerCode = str_replace('CUST', '', $lastCustomerCode);
            $customerCode = (int) $customerCode + 1;
            $customerCode = 'CUST' . str_pad($customerCode, 4, '0', STR_PAD_LEFT);

            // 1. Create or find customer
            $customer = Customer::firstOrCreate(
                ['phone' => $request->phone],
                [
                    'customer_code' => $customerCode,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'customer_type' => 'both',
                    'source_type' => 'lead',
                    'is_lead' => true,
                    'created_by' => $request->user_id,
                ]
            );

            // 2. Create customer address
            $customerAddress = CustomerAddressDetail::create([
                'customer_id' => $customer->id,
                'branch_name' => 'Lead Address',
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?? 'India',
                'pincode' => $request->pincode,
                'is_primary' => 'yes',
            ]);

            // Handle file upload
            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/crm/lead/file'), $filename);
                $filePath = 'uploads/crm/lead/file/' . $filename;
            }

            // 3. Create lead with customer_id and customer_address_id
            $leadNumber = 'LD-' . date('YmdHis') . '-' . $request->user_id;

            $lead = Lead::create([
                'customer_id' => $customer->id,
                'staff_id' => $request->user_id,
                'customer_address_id' => $customerAddress->id,
                'lead_number' => $leadNumber,
                'requirement_type' => $request->requirement_type,
                'budget_range' => $request->budget_range,
                'urgency' => $request->urgency,
                'status' => $request->status ?? 'new',
                'notes' => $request->notes,
            ]);

            DB::commit();

            if (! $lead) {
                return response()->json(['message' => 'Lead not created'], 500);
            }

            $lead->load('customer', 'companyDetails');

            return new LeadResource($lead);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create lead.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $lead_id)
    {
        $validated = Validator::make($request->all(), ([
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $lead = Lead::with('customer', 'companyDetails')->where('staff_id', $validated['user_id'])->where('id', $lead_id)->first();
        if (! $lead) {
            return response()->json(['message' => 'Lead not found'], 404);
        }

        return new LeadResource($lead);
    }

    public function update(Request $request, $lead_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $lead = Lead::where('staff_id', $validated['user_id'])->find($lead_id);

        if (! $lead) {
            return response()->json(['message' => 'Lead not found'], 404);
        }
        
        $lead->update($request->all());

        $lead->load('customer', 'companyDetails');
        
        return new LeadResource($lead);
    }

    public function destroy(Request $request, $lead_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $lead = Lead::where('staff_id', $request->user_id)->where('id', $lead_id)->delete();

        if (! $lead) {
            return response()->json(['message' => 'Lead not found'], 404);
        }

        return response()->json(['message' => 'Lead deleted successfully'], 200);
    }
}
