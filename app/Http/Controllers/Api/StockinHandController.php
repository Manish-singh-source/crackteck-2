<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockinHand;
use Illuminate\Http\Request;

class StockinHandController extends Controller
{
    //
    protected function getRoleId($roleId)
    {
        return [
            1 => 'engineer',
            2 => 'delivery_man',
            3 => 'sales_person',
            4 => 'customers',
        ][$roleId] ?? null;
    }

    public function index(Request $request)
    {
        $validated = request()->validate([
            'user_id' => 'required',
        ]);

        if (! $validated['user_id']) {
            return response()->json(['message' => 'User ID is required'], 400);
        }

        $stockinHand = StockinHand::where('user_id', $validated['user_id'])->get();
        if (! $stockinHand) {
            return response()->json(['message' => 'No stock found'], 404);
        }

        return response()->json(['stockin_hand' => $stockinHand], 200);
    }

}
