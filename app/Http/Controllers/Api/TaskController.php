<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\FollowUp;
use App\Models\Meet;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index(Request $request)
    {
        $validated = request()->validate([
            'user_id' => 'required',
        ]);

        if (! $validated['user_id']) {
            return response()->json(['message' => 'User ID is required'], 400);
        }
        $meets = Meet::where('staff_id', $validated['user_id'])->get();
        $followup = FollowUp::where('staff_id', $validated['user_id'])->get();
        
        $quotations = [ 'meets' => $meets->toArray(), 'followup' => $followup->toArray()];

        if (empty($quotations)) {
            return response()->json(['message' => 'No quotations found for the given user ID'], 404);
        }
        // return response()->json(['meets' => $meets, 'followup' => $followup], 200);

        return ApiResponse::success(
            'Quotations found successfully.',
            TaskResource::collection($quotations)
        );

    }
}
