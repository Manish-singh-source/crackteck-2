<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\Engineer;
use App\Models\SalesPerson;
use App\Models\StockinHand;
use Illuminate\Http\Request;

class StockinHandController extends Controller
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

    public function index(Request $request)
    {
        // List of the stock available in the engineer hand
        $validated = request()->validate([
            // validation rules if any
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

    // public function show(Request $request, $id)
    // {
    //     // List of the stock available in the engineer hand
    //     return response()->json(['message' => 'Stock in hand'], 200);
    // }

    // public function store(Request $request)
    // {
    //     // List of the products available in warehouse
    //     return response()
    // }

}
