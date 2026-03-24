<?php

namespace App\Http\Controllers;

use App\Models\CashReceived;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\OrderPayment;
use App\Models\ServiceRequestPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * CRM Controller for Cash Received from Customer (Accounts Section)
 * 
 * This controller handles the CRM interface for viewing and managing
 * cash collections by staff members (Delivery Man / Engineer).
 */
class CashReceivedController extends Controller
{
    /**
     * Display a listing of all cash received entries (Accounts Section).
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = CashReceived::with(['customer', 'staff', 'order', 'serviceRequest']);

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('staff_id') && $request->staff_id) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->has('customer_id') && $request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Get all cash received entries with pagination
        $perPage = $request->input('per_page', 15);
        $cashReceivedList = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Get staff list for filter
        $staffList = Staff::orderBy('first_name')->orderBy('last_name')->get();

        // Get customer list for filter
        $customerList = Customer::orderBy('first_name')->orderBy('last_name')->get();

        return view('crm.accounts.cash-received.index', compact(
            'cashReceivedList',
            'staffList',
            'customerList'
        ));
    }

    /**
     * Display the details of a specific cash received entry.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function view(int $id)
    {
        $cashReceived = CashReceived::with([
            'customer',
            'staff',
            'order',
            'serviceRequest'
        ])->findOrFail($id);

        // Determine the type and related ID
        $type = $cashReceived->isOrderBased() ? 'Order' : 'Service Request';
        $relatedId = $cashReceived->isOrderBased() ? $cashReceived->order_id : $cashReceived->service_request_id;

        // Get related payment details if available
        $paymentDetails = null;
        if ($cashReceived->isOrderBased()) {
            $paymentDetails = OrderPayment::where('order_id', $cashReceived->order_id)->first();
        } elseif ($cashReceived->isServiceRequestBased()) {
            $paymentDetails = ServiceRequestPayment::where('service_request_id', $cashReceived->service_request_id)->first();
        }

        return view('crm.accounts.cash-received.view', compact(
            'cashReceived',
            'type',
            'relatedId',
            'paymentDetails'
        ));
    }

    /**
     * Mark cash as received by the Account Team.
     * 
     * This action:
     * 1. Updates cash_received.status from 'customer_paid' to 'received'
     * 2. Updates order_payments.status to 'completed' (if order-based)
     * 3. Updates service_request_payments.payment_status to 'completed' (if service request-based)
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsReceived(int $id)
    {
        try {
            $cashReceived = CashReceived::findOrFail($id);

            // Check if already marked as received
            if ($cashReceived->status === CashReceived::STATUS_RECEIVED) {
                return redirect()
                    ->route('cash-received.view', $id)
                    ->with('error', 'This cash entry has already been marked as received.');
            }

            // Start database transaction
            DB::beginTransaction();

            // Update cash_received status to 'received'
            $cashReceived->update([
                'status' => CashReceived::STATUS_RECEIVED,
            ]);

            // Update related payment records
            if ($cashReceived->isOrderBased()) {
                // Update order_payments status to 'completed'
                OrderPayment::where('order_id', $cashReceived->order_id)
                    ->update(['status' => 'completed']);
            } elseif ($cashReceived->isServiceRequestBased()) {
                // Update service_request_payments payment_status to 'completed'
                ServiceRequestPayment::where('service_request_id', $cashReceived->service_request_id)
                    ->update(['payment_status' => 'completed']);
            }

            DB::commit();

            return redirect()
                ->route('cash-received.view', $id)
                ->with('success', 'Cash has been successfully marked as received by Account Team.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('cash-received.index')
                ->with('error', 'Cash received entry not found.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CashReceived markAsReceived error: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('cash-received.view', $id)
                ->with('error', 'An error occurred while updating the status. Please try again.');
        }
    }

    /**
     * Get list of staff for AJAX requests.
     */
    public function getStaffList(Request $request)
    {
        $query = $request->get('q', '');
        
        $staff = Staff::where('name', 'LIKE', "%$query%")
            ->select('id', 'name', 'role')
            ->limit(10)
            ->get();

        return response()->json($staff);
    }

    /**
     * Get list of customers for AJAX requests.
     */
    public function getCustomerList(Request $request)
    {
        $query = $request->get('q', '');
        
        $customers = Customer::where('name', 'LIKE', "%$query%")
            ->select('id', 'name', 'email', 'phone')
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}