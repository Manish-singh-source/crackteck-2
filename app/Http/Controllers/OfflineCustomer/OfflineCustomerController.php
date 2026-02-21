<?php

namespace App\Http\Controllers\OfflineCustomer;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddressDetail;
use Illuminate\Http\Request;

class OfflineCustomerController extends Controller
{
    //
    public function index(){
        return view('offline-users-dashboard.index');
    }
    public function amc(){
        return view('offline-users-dashboard.amc');
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
