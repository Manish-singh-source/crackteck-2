<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MeetResource;
use App\Models\Meet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeetController extends Controller
{
    //
    public function index(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $meets = Meet::with('leadDetails')->where('staff_id', $request->user_id)->paginate();

        if ($meets->isEmpty()) {
            return response()->json(['message' => 'No meets found'], 404);
        }

        return MeetResource::collection($meets);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
            'lead_id' => 'required',
            'meet_title' => 'required',
            'meeting_type' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'attachment' => 'nullable',
            'meetAgenda' => 'nullable',
            'followUp' => 'nullable',
            'status' => 'nullable',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        $validated['staff_id'] = $validated['user_id'];
        unset($validated['user_id']);

        $validated['start_time'] = $validated['time'] ?? null;
        unset($validated['time']);

        $validated['meet_agenda'] = $validated['meetAgenda'] ?? null;
        unset($validated['meetAgenda']);

        $validated['follow_up_action'] = $validated['followUp'] ?? null;
        unset($validated['followUp']);



        $meet = Meet::create($validated);

        if (! $meet) {
            return response()->json(['message' => 'Meet not created'], 500);
        }

        $meet->load('leadDetails');

        return new MeetResource($meet);
    }

    public function show(Request $request, $meet_id)
    {
        $validated = Validator::make($request->all(), ([
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        $meets = Meet::where('staff_id', $validated['user_id'])->where('id', $meet_id)->first();

        if (! $meets) {
            return response()->json(['message' => 'Meet not found'], 404);
        }

        return new MeetResource($meets);
    }

    public function update(Request $request, $meet_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        // Find the meeting record
        $meet = Meet::find($meet_id);

        if (! $meet) {
            return response()->json(['message' => 'Meeting not found'], 404);
        }

        // Update the model
        $meet->update($request->all());

        // Return updated resource
        return new MeetResource($meet);
    }

    public function destroy(Request $request, $meet_id)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        Meet::where('staff_id', $validated['user_id'])->where('id', $meet_id)->delete();

        return response()->json(['message' => 'Meet deleted successfully'], 200);
    }
}
