<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use Illuminate\Http\Request;

class KycLogController extends Controller
{
    /**
     * Display a listing of the KYC records.
     */
    public function index(Request $request)
    {
        $query = Kyc::with(['staff', 'role']);

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name, email, or phone
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $kycs = $query->orderBy('created_at', 'desc')->get();

        return view('/crm/accounts/kyc-log/index', compact('kycs'));
    }

    /**
     * Display the specified KYC record.
     */
    public function view($id)
    {
        $kyc = Kyc::with(['staff', 'role'])->findOrFail($id);

        return view('/crm/accounts/kyc-log/view', compact('kyc'));
    }

    /**
     * Update the specified KYC status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,submitted,under_review,approved,rejected,resubmit_required',
            'reason' => 'nullable|string',
        ]);

        $kyc = Kyc::with('staff')->findOrFail($id);
        $status = $request->status;

        switch ($status) {
            case Kyc::STATUS_APPROVED:
                $kyc->approve($request->reason);
                // Update staff kyc_status to verified
                if ($kyc->staff) {
                    $kyc->staff->update(['kyc_status' => 'verified']);
                }
                break;
            case Kyc::STATUS_REJECTED:
                $kyc->reject($request->reason);
                // Update staff kyc_status to unverified
                if ($kyc->staff) {
                    $kyc->staff->update(['kyc_status' => 'unverified']);
                }
                break;
            case Kyc::STATUS_RESUBMIT_REQUIRED:
                $kyc->markResubmitRequired($request->reason);
                // Update staff kyc_status to pending
                if ($kyc->staff) {
                    $kyc->staff->update(['kyc_status' => 'pending']);
                }
                break;
            case Kyc::STATUS_UNDER_REVIEW:
                $kyc->markUnderReview();
                break;
            default:
                $kyc->status = $status;
                $kyc->reason = $request->reason;
                $kyc->save();
                break;
        }

        return redirect()->back()->with('success', 'KYC status updated successfullyyyyyyyyyyy');
    }

    /**
     * Get KYC counts for dashboard.
     */
    public function getCounts()
    {
        $total = Kyc::count();
        $pending = Kyc::where('status', 'pending')->count();
        $submitted = Kyc::where('status', 'submitted')->count();
        $underReview = Kyc::where('status', 'under_review')->count();
        $approved = Kyc::where('status', 'approved')->count();
        $rejected = Kyc::where('status', 'rejected')->count();
        $resubmitRequired = Kyc::where('status', 'resubmit_required')->count();

        return compact('total', 'pending', 'submitted', 'underReview', 'approved', 'rejected', 'resubmitRequired');
    }
}
