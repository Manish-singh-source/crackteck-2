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
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
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

    // sales dashboard
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
            return response()->json(['success' => false, 'message' => 'Invalid role_id provided.'], 400);
        }
        $data = [];
        if ($staffRole == 'sales_person') {
            $meets = Meet::where('user_id', $validated['user_id'])->where('date', today())->get();
            $followup = FollowUp::where('user_id', $validated['user_id'])->where('followup_date', today())->get();
            $data = [
                'meets' => $meets,
                'followup' => $followup,
            ];
        } elseif ($staffRole == 'delivery_man') {
            $total_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->count();
            $delivered_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->where('status', 'delivered')->count();
            $pending_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->where('status', 'pending')->count();
            $processing_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->where('status', 'processing')->count();
            $shipped_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->where('status', 'shipped')->count();
            $cancelled_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->where('status', 'cancelled')->count();

            $new_orders = EcommerceOrder::where('delivery_man_id', $validated['user_id'])->where('status', 'confirmed')->orderBy('updated_at', 'desc')->get();

            $data = [
                'total_orders' => $total_orders,
                'delivered_orders' => $delivered_orders,
                'pending_orders' => $pending_orders,
                'processing_orders' => $processing_orders,
                'shipped_orders' => $shipped_orders,
                'cancelled_orders' => $cancelled_orders,
                'new_orders' => $new_orders,
            ];
        }

        return response()->json($data, 200);
    }

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

        $lostLeads = Lead::where('user_id', $validated['user_id'])->where('status', 'Lost')->count();
        $newLeads = Lead::where('user_id', $validated['user_id'])->where('status', 'New')->count();
        $contactedLeads = Lead::where('user_id', $validated['user_id'])->where('status', 'Contacted')->count();
        $qualifiedLeads = Lead::where('user_id', $validated['user_id'])->where('status', 'Qualified')->count();
        $quotedLeads = Lead::where('user_id', $validated['user_id'])->where('status', 'Quoted')->count();

        return response()->json(['lost_leads' => $lostLeads, 'new_leads' => $newLeads, 'contacted_leads' => $contactedLeads, 'qualified_leads' => $qualifiedLeads, 'quoted_leads' => $quotedLeads], 200);
    }
}
