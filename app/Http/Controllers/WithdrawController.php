<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $query = WithdrawalRequest::with('staff')->latest('requested_at');

        foreach (['status', 'staff_id'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }
        if ($request->filled('from')) {
            $query->whereDate('requested_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('requested_at', '<=', $request->input('to'));
        }

        $withdrawals = $query->paginate(20)->withQueryString();
        $staff = Staff::where('status', 'active')->orderBy('first_name')->get();

        return view('crm.accounts.withdraw', compact('withdrawals', 'staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'integer', 'exists:staff,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'reason' => ['required', 'string', 'max:500'],
            'payout_method' => ['required', 'in:cash,upi,bank_transfer'],
            'payout_details' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['payout_method'] !== 'cash' && empty($validated['payout_details'])) {
            return back()->withErrors(['payout_details' => 'UPI ID or bank details are required for this payout method.'])->withInput();
        }

        $staff = Staff::where('status', 'active')->findOrFail($validated['staff_id']);
        WithdrawalRequest::create([
            ...$validated,
            'withdrawal_no' => 'WDR-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
            'requester_role' => $staff->staff_role ?: 'staff',
            'requested_at' => now(),
        ]);

        return redirect()->route('withdraw')->with('success', 'Payout request created and sent for approval.');
    }

    public function updateStatus(Request $request, WithdrawalRequest $withdrawal)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected,paid'],
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);
        $allowed = ['pending' => ['approved', 'rejected'], 'approved' => ['paid']];
        if (! in_array($validated['status'], $allowed[$withdrawal->status] ?? [], true)) {
            return back()->withErrors(['status' => 'This payout request cannot be moved to the selected status.']);
        }
        if ($validated['status'] === 'rejected' && empty($validated['rejection_reason'])) {
            return back()->withErrors(['rejection_reason' => 'A rejection reason is required.']);
        }
        if ($validated['status'] === 'paid' && empty($validated['payment_reference'])) {
            return back()->withErrors(['payment_reference' => 'Payment reference / UTR is required before marking paid.']);
        }

        $withdrawal->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null,
            'payment_reference' => $validated['status'] === 'paid' ? $validated['payment_reference'] : $withdrawal->payment_reference,
            'approved_at' => $validated['status'] === 'approved' ? now() : $withdrawal->approved_at,
            'paid_at' => $validated['status'] === 'paid' ? now() : $withdrawal->paid_at,
            'processed_by' => auth()->id(),
        ]);

        return redirect()->route('withdraw')->with('success', 'Payout request status updated.');
    }
}
