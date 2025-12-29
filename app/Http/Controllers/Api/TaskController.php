<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\Meet;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    // Calender wise Task Filtering
    public function index(Request $request)
    {
        $validated = request()->validate([
            // validation rules if any
            'user_id' => 'required',
        ]);

        if (! $validated['user_id']) {
            return response()->json(['message' => 'User ID is required'], 400);
        }

        $meets = Meet::where('user_id', $validated['user_id'])->where('date', today())->get();
        $followup = FollowUp::where('user_id', $validated['user_id'])->where('followup_date', today())->get();

        return response()->json(['meets' => $meets, 'followup' => $followup], 200);
    }
}
