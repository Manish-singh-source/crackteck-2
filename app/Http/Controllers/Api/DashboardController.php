<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\EcommerceOrder;
use App\Models\Engineer;
use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Meet;
use App\Models\Order;
use App\Models\SalesPerson;
use App\Models\WebsiteBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
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

    // Dashboard data based on role 
    // role_id: 1 => engineer, 2 => delivery man completed 
    // 3 => sales person, 4 => customers pending 
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
            $total_orders = Order::where('assigned_person_id', $validated['user_id'])->count();
            $pending_orders = Order::where('assigned_person_id', $validated['user_id'])->where('order_status', '0')->orderBy('updated_at', 'desc')->count();
            $new_orders = Order::where('assigned_person_id', $validated['user_id'])->where('order_status', '1')->orderBy('updated_at', 'desc')->get();
            $processing_orders = Order::where('assigned_person_id', $validated['user_id'])->where('order_status', '2')->orderBy('updated_at', 'desc')->count();
            $shipped_orders = Order::where('assigned_person_id', $validated['user_id'])->where('order_status', '3')->orderBy('updated_at', 'desc')->count();
            $delivered_orders = Order::where('assigned_person_id', $validated['user_id'])->where('order_status', '4')->orderBy('updated_at', 'desc')->count();
            $cancelled_orders = Order::where('assigned_person_id', $validated['user_id'])->where('order_status', '5')->orderBy('updated_at', 'desc')->count();

            $data = [
                'total_orders' => $total_orders,
                'pending_orders' => $pending_orders,
                'new_orders' => $new_orders,
                'processing_orders' => $processing_orders,
                'shipped_orders' => $shipped_orders,
                'delivered_orders' => $delivered_orders,
                'cancelled_orders' => $cancelled_orders,
            ];
        }

        return response()->json($data, 200);
    }

    // Sales Overview for Sales Person
    public function salesOverview(Request $request)
    {
        $validated = Validator::make($request->all(), ([
            // validation rules if any
            'user_id' => 'required',
        ]));

        if ($validated->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $validated->errors()], 422);
        }
        $validated = $validated->validated();

        $newLeads = Lead::where('staff_id', $validated['user_id'])->where('status', '0')->count();
        $contactedLeads = Lead::where('staff_id', $validated['user_id'])->where('status', '1')->count();
        $qualifiedLeads = Lead::where('staff_id', $validated['user_id'])->where('status', '2')->count();
        // replaced quoted with won
        $quotedLeads = Lead::where('staff_id', $validated['user_id'])->where('status', '4')->count();
        $lostLeads = Lead::where('staff_id', $validated['user_id'])->where('status', '5')->count();

        return response()->json(['lost_leads' => $lostLeads, 'new_leads' => $newLeads, 'contacted_leads' => $contactedLeads, 'qualified_leads' => $qualifiedLeads, 'quoted_leads' => $quotedLeads], 200);
    }

    public function banners(Request $request)
    {
        $banners = WebsiteBanner::where('is_active', "1")->where('channel', 'mobile')->get();
        return response()->json(['banners' => $banners], 200);
    }
}
