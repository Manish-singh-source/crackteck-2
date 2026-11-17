<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AmcPlan;
use App\Models\CoveredItem;
use App\Support\ApiMediaUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmcServicesController extends Controller
{
    protected function addPlanMediaUrls(AmcPlan $plan): AmcPlan
    {
        // AMC plans currently store a brochure, not a separate image column.
        $plan->brochure_url = ApiMediaUrl::make($plan->brochure);

        return $plan;
    }

    /**
     * Return covered items with a client-ready absolute image URL.
     * The database keeps the relative public path in `image`.
     */
    protected function coveredItemsForPlan(AmcPlan $plan)
    {
        return CoveredItem::whereIn('id', $plan->covered_items ?? [])
            ->get()
            ->map(function (CoveredItem $item) {
                $item->image_url = ApiMediaUrl::make($item->image);

                return $item;
            })
            ->values();
    }

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
                $amcPlansCoveredItems[] = [
                    'plan' => $this->addPlanMediaUrls($plan),
                    'covered_items' => $this->coveredItemsForPlan($plan),
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
            'amc_plan' => $this->addPlanMediaUrls($amcPlan),
            'covered_items' => $this->coveredItemsForPlan($amcPlan),
        ];

        return response()->json(['data' => $data], 200);
    }
}
