<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Meet;
use App\Models\Order;
use App\Models\ReplacementRequest;
use App\Models\WebsiteBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
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
        $validated = Validator::make($request->all(), [
            'role_id' => 'nullable|in:1,2,3,4',
            'user_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();
        $staffRole = $this->getRoleId($validated['role_id']);
        if (! $staffRole) {
            return response()->json(['success' => false, 'message' => 'Invalid Role ID provided.'], 400);
        }
        $data = [];
        if ($staffRole == 'sales_person') {
            $meets = Meet::where('staff_id', $validated['user_id'])->where('date', today())->get();
            $followup = FollowUp::where('staff_id', $validated['user_id'])->where('followup_date', today())->get();
            $data = [
                'meets' => $meets,
                'followup' => $followup,
            ];
        } elseif ($staffRole == 'delivery_man') {
            $data = [
                'total_orders' => Order::where('assigned_person_id', $validated['user_id'])->count(),
                'pending_orders' => Order::where('assigned_person_id', $validated['user_id'])->where('status', 'order_accepted')->orderBy('updated_at', 'desc')->count(),
                'new_orders' => Order::where('assigned_person_id', $validated['user_id'])->where('status', 'assigned_delivery_man')->orderBy('updated_at', 'desc')->count(),
                'shipped_orders' => Order::where('assigned_person_id', $validated['user_id'])->where('status', 'product_taken')->orderBy('updated_at', 'desc')->count(),
                'delivered_orders' => Order::where('assigned_person_id', $validated['user_id'])->where('status', 'delivered')->orderBy('updated_at', 'desc')->count(),
                'cancelled_orders' => Order::where('assigned_person_id', $validated['user_id'])->where('status', 'cancelled')->orderBy('updated_at', 'desc')->count(),
                'returned_orders' => Order::where('assigned_person_id', $validated['user_id'])->where('status', 'returned')->orderBy('updated_at', 'desc')->count(),
                'replacement_requests' => ReplacementRequest::where('assigned_person_type', 'delivery_man')->where('assigned_person_id', $validated['user_id'])->count(),
            ];
        } elseif ($staffRole == 'engineer') {
            $data = [
                'replacement_requests' => ReplacementRequest::where('assigned_person_type', 'engineer')->where('assigned_person_id', $validated['user_id'])->count(),
            ];
        }

        return response()->json($data, 200);
    }

    public function salesOverview(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        $newLeads = Lead::where('staff_id', $validated['user_id'])->where('status', 'new')->count();
        $contactedLeads = Lead::where('staff_id', $validated['user_id'])->where('status', 'contacted')->count();
        $qualifiedLeads = Lead::where('staff_id', $validated['user_id'])->where('status', 'qualified')->count();
        $quotedLeads = Lead::where('staff_id', $validated['user_id'])->where('status', 'won')->count();
        $lostLeads = Lead::where('staff_id', $validated['user_id'])->where('status', 'lost')->count();

        return response()->json(['lost_leads' => $lostLeads, 'new_leads' => $newLeads, 'contacted_leads' => $contactedLeads, 'qualified_leads' => $qualifiedLeads, 'quoted_leads' => $quotedLeads], 200);
    }

    public function banners(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            'role_id' => 'required|in:4',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $banners = WebsiteBanner::where('is_active', '1')->where('channel', 'mobile')->get();

        return response()->json(['banners' => $banners], 200);
    }
}
