<?php

namespace App\Http\Controllers\OfflineCustomer;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Amc;
use App\Models\CustomerAddressDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OfflineCustomerController extends Controller
{
    //
    public function index()
    {
        $customer = Auth::guard('customer_web')->user();
        return view('offline-users-dashboard.index', compact('customer'));
    }

    public function amc()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }

        // Debug: Check what Auth::id() returns
        $customerId = Auth::guard('customer_web')->id();

        // If using Customer model, get the actual customer ID
        $customer = Auth::guard('customer_web')->user();
        if ($customer instanceof \App\Models\Customer) {
            $customerId = $customer->id;
        }

        $servicesRequest = Amc::with('customer')
            ->withCount('amcProducts')
            ->where('customer_id', $customerId)
            ->whereNotNull('amc_plan_id')
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($servicesRequest);
        return view('offline-users-dashboard.amc', compact('servicesRequest'));
    }

    /**
     * Display detailed view of a specific AMC service
     */
    public function amcView($id)
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }

        $customer = Auth::guard('customer_web')->user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:amcs,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('my-account-amc')->with('error', 'AMC service not found.');
        }

        try {
            
            $amcService = Amc::with([
                'amcPlan',
                'customer',
                'customer.companyDetails',
                'customer.branches',
                'amcProducts',
                'amcScheduleMeetings',  
                'amcScheduleMeetings.activeAssignment.engineer',
            ])
            ->withCount('amcProducts')
            ->where('id', $id)->where('customer_id', $customerId)->firstOrFail();

            return view('offline-users-dashboard.amc-view', compact('amcService'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error viewing AMC service: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error loading AMC service details.');
        }
    }
    public function accountDetail()
    {
        $customer = Auth::user();
        $customerId = $customer instanceof \App\Models\Customer ? $customer->id : $customer->getAuthIdentifier();
        $primaryAddress = CustomerAddressDetail::where('is_primary', 'yes')
            ->where('customer_id', $customerId)
            ->first();
        // dd($customer,$primaryAddress);

        return view('offline-users-dashboard.account-detail', compact('customer', 'primaryAddress'));
    }
    public function address()
    {
        if (! Auth::guard('customer_web')->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Debug: Check what Auth::id() returns
        $customerId = Auth::id();

        // If using Customer model, get the actual customer ID
        $customer = Auth::user();
        if ($customer instanceof \App\Models\Customer) {
            $customerId = $customer->id;
        }

        $addresses = CustomerAddressDetail::where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('offline-users-dashboard.address', compact('addresses'));
    }
    public function changePassword(){
        return view('offline-users-dashboard.password');
    }
}
