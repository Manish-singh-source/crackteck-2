<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffWallet;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the staff wallet expenses.
     */
    public function index(Request $request)
    {
        return view('/crm/accounts/expenses/index');
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        $staffTypes = [
            'engineer' => 'Engineer',
            'delivery_man' => 'Delivery Man',
        ];

        $staff = Staff::whereIn('staff_role', ['engineer', 'delivery_man'])
            ->where('status', 'active')
            ->get();

        return view('/crm/accounts/expenses/create', compact('staff', 'staffTypes'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_type' => 'required|string|in:engineer,delivery_man',
            'staff_id' => 'required|integer|exists:staff,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle receipt file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receipt = $request->file('receipt');
            $receiptName = time().'_'.$receipt->getClientOriginalName();
            $receipt->storeAs('public/receipts', $receiptName);
            $receiptPath = 'receipts/'.$receiptName;
        }

        StaffWallet::create([
            'staff_type' => $validated['staff_type'],
            'staff_id' => $validated['staff_id'],
            'amount' => $validated['amount'],
            'reason' => $validated['reason'],
            'receipt' => $receiptPath,
            'status' => 'admin_approved',
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense submitted successfully');
    }

    /**
     * Display the specified expense.
     */
    public function view($id)
    {
        $expense = StaffWallet::with('staff')->findOrFail($id);

        return view('/crm/accounts/expenses/view', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit($id)
    {
        $expense = StaffWallet::findOrFail($id);

        $staffTypes = [
            'engineer' => 'Engineer',
            'delivery_man' => 'Delivery Man',
        ];

        $staff = Staff::whereIn('staff_role', ['engineer', 'delivery_man'])
            ->where('status', 'active')
            ->get();

        return view('/crm/accounts/expenses/edit', compact('expense', 'staff', 'staffTypes'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = StaffWallet::findOrFail($id);

        $validated = $request->validate([
            // 'staff_type' => 'required|string|in:engineer,delivery_man',
            // 'staff_id' => 'required|integer|exists:staff,id',
            'amount' => 'required|numeric|min:0',
            // 'reason' => 'required|string',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|string|in:pending,admin_approved,admin_rejected,paid',
        ]);

        // Handle receipt file upload
        if ($request->hasFile('receipt')) {
            $receipt = $request->file('receipt');
            $receiptName = time().'_'.$receipt->getClientOriginalName();
            $receipt->storeAs('public/receipts', $receiptName);
            $validated['receipt'] = 'receipts/'.$receiptName;
        } else {
            unset($validated['receipt']);
        }

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function delete($id)
    {
        $expense = StaffWallet::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully');
    }

    /**
     * Update expense status (approve/reject/pay).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,admin_approved,admin_rejected,paid',
        ]);

        $expense = StaffWallet::findOrFail($id);
        $expense->update(['status' => $validated['status']]);

        return redirect()->route('expenses.index')->with('success', 'Expense status updated successfully');
    }
}
