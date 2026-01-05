<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowUpResource;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowUpController extends Controller
{
    public function index(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $followup = FollowUp::with('leadDetails')->where('staff_id', $validated['user_id'])->get();
        if ($followup->isEmpty()) {
            return response()->json(['message' => 'No followup found'], 404);
        }

        return FollowUpResource::collection($followup);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
            'lead_id' => 'required',
            'followup_date' => 'required',
            'followup_time' => 'required',
            'status' => 'required',
            'remarks' => 'nullable',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $validated['staff_id'] = $validated['user_id'];
        unset($validated['user_id']);

        // return response()->json(['message' => 'Follow Up created successfully', 'followup' => $validated], 200);
        $followup = FollowUp::create($validated);
        if (! $followup) {
            return response()->json(['message' => 'Follow Up not created'], 500);
        }

        return response()->json(['message' => 'Follow Up created successfully'], 200);
    }

    public function show(Request $request, $lead_id)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'user_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        $followup = FollowUp::with('leadDetails')->where('staff_id', $validated['user_id'])->where('id', $lead_id)->first();

        if (! $followup) {
            return response()->json(['message' => 'Follow Up not found'], 404);
        }

        return new FollowUpResource($followup);
    }

    public function update(Request $request, $followup_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $followup = FollowUp::where('staff_id', $validated['user_id'])->find($followup_id);

        if (! $followup) {
            return response()->json(['message' => 'Follow Up not found'], 404);
        }

        $followup->update($request->all());

        return new FollowUpResource($followup);
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

        $validated = $validated->validated();

        $followup = FollowUp::where('staff_id', $validated['user_id'])->where('id', $lead_id)->delete();

        if (! $followup) {
            return response()->json(['message' => 'Follow Up not found'], 404);
        }

        return response()->json(['message' => 'Follow Up deleted successfully'], 200);
    }
}
