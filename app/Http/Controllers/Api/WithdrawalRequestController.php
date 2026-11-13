<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WithdrawalRequestController extends Controller
{
    public function index(Request $request)
    {
        $staff = $this->staff($request);

        return response()->json([
            'success' => true,
            'data' => WithdrawalRequest::where('staff_id', $staff->id)
                ->latest('requested_at')
                ->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $staff = $this->staff($request);
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'reason' => ['required', 'string', 'max:500'],
            'payout_method' => ['required', 'in:cash,upi,bank_transfer'],
            'payout_details' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['payout_method'] !== 'cash' && empty($validated['payout_details'])) {
            return response()->json(['success' => false, 'message' => 'UPI ID or bank details are required for this payout method.'], 422);
        }

        $withdrawal = WithdrawalRequest::create([
            ...$validated,
            'staff_id' => $staff->id,
            'requester_role' => $staff->staff_role ?: 'staff',
            'withdrawal_no' => 'WDR-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
            'requested_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Payout request submitted.', 'data' => $withdrawal], 201);
    }

    private function staff(Request $request): Staff
    {
        $user = $request->user();

        abort_unless($user instanceof Staff, 403, 'Only staff members can access payout requests.');

        return $user;
    }
}
