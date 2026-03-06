<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json(['meets' => $meets, 'followup' => $followup], 200);
    }
}
