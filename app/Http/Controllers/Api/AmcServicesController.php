<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AmcPlan;
use App\Models\CoveredItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmcServicesController extends Controller
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

    public function getAmcPlans(Request $request)
    {
        $validated = Validator::make($request->all(), [
            // validation rules if any
            'role_id' => 'required|in:3,4',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        $staffRole = $this->getRoleId($validated['role_id']);

        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }

        if ($staffRole == 'customers' || $staffRole == 'sales_person') {
            $amcPlans = AmcPlan::where('status', 'active')->get();
            $amcPlansCoveredItems = [];
            foreach ($amcPlans as $plan) {
                $detail = CoveredItem::whereIn('id', $plan->covered_items)->get();
                $amcPlansCoveredItems[] = [
                    'plan' => $plan,
                    'covered_items' => $detail ?? [],
                ];
            }

            return response()->json(['amc_plans' => $amcPlansCoveredItems], 200);
        }
    }

    public function amcPlanDetails(Request $request, $id)
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

        $amcPlan = AmcPlan::find($id);
        if (! $amcPlan) {
            return response()->json(['success' => false, 'message' => 'AMC Plan not found.'], 404);
        }

        $data = [
            'amc_plan' => $amcPlan,
            'covered_items' => CoveredItem::whereIn('id', $amcPlan->covered_items)->get(),
        ];

        return response()->json(['data' => $data], 200);
    }
}
