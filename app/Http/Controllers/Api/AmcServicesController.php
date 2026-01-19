<?php

namespace App\Http\Controllers\Api;

use App\Models\AmcPlan;
use App\Models\Customer;
use App\Models\Engineer;
use App\Models\AmcService;
use App\Models\CoveredItem;
use App\Models\DeliveryMan;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AmcServicesController extends Controller
{
    //
    public function generateServiceId()
    {
        $year = date('Y');
        $lastService = NonAmcService::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastService ? (intval(substr($lastService->service_id, -4)) + 1) : 1;

        return 'SRV-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function calculateEndDate($startDate, $duration)
    {
        $duration = strtolower($duration);
        $startDate = \Carbon\Carbon::parse($startDate);

        if (strpos($duration, 'months') !== false) {
            $months = intval($duration);

            return $startDate->addMonths($months);
        } elseif (strpos($duration, 'years') !== false) {
            $years = intval($duration);

            return $startDate->addYears($years);
        }

        // Default to 1 year if duration format is unclear
        return $startDate->addYear();
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

    public function getAmcPlans(Request $request)
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

        if ($staffRole == 'customers') {
            $amcPlans = AmcPlan::where('status', 'active')->get();
            $amcPlansCoveredItems = [];
            foreach ($amcPlans as $plan) {
                $amcPlansCoveredItems[] = [
                    'plan' => $plan,
                    'covered_items' => $plan->coveredItems(),
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
            'covered_items' => $amcPlan->coveredItems(),
        ];

        return response()->json(['data' => $data], 200);
    }
}
