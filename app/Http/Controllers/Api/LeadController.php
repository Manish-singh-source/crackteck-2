<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\Staff;
use Illuminate\Http\Request;
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

        if($roleCheck->staff_role != 'sales_person'){
            return response()->json([
                'success' => false,
                'message' => 'User is not a sales person.',
            ], 403);
        }

        // Get validated data as array
        $validatedData = $validator->validated();

        // Query leads
        $leads = Lead::with('customer.companyDetails')->where('staff_id', $validatedData['user_id'])->paginate();

        // Return paginated leads as resource collection
        return LeadResource::collection($leads);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
            'name' => 'required',
            'company_name' => 'nullable',
            'designation' => 'nullable',
            'phone' => 'required',
            'email' => 'required|email',

            'dob' => 'nullable|date',
            'gender' => 'nullable',

            'address' => 'nullable',

            'budget_range' => 'required',
            'source' => 'required',
            'urgency' => 'required',
            'requirement_type' => 'required',
            'industry_type' => 'required',
            'status' => 'required',

            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('uploads/crm/lead/file'), $filename);
            $validated['file'] = 'uploads/crm/lead/file/'.$filename;
        }

        if ($request->name) {
            $full_name = explode(' ', $request->name);
            $request->merge(['first_name' => $full_name[0]]);
            $request->merge(['last_name' => $full_name[1]]);

            unset($request['name']);
        }

        $request->merge(['staff_id' => $request->user_id]);
        unset($request['user_id']);

        $leadNumber = 'LD-' . date('YmdHis') . '-' . $request->staff_id;;
        $request->merge(['lead_number' => $leadNumber]);

        $lead = Lead::create($request->all());

        if (! $lead) {
            return response()->json(['message' => 'Lead not created'], 500);
        }

        return new LeadResource($lead);
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

        $lead = Lead::with('companyDetails')->where('staff_id', $validated['user_id'])->where('id', $lead_id)->first();
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

        if ($request->full_name) {
            $full_name = explode(' ', $request->full_name);
            $request->merge(['first_name' => $full_name[0]]);
            $request->merge(['last_name' => $full_name[1]]);

            unset($request['full_name']);
        }

        $lead = Lead::where('staff_id', $validated['user_id'])->find($lead_id);

        if (! $lead) {
            return response()->json(['message' => 'Lead not found'], 404);
        }

        $lead->update($request->all());

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
