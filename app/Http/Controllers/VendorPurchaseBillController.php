<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorPurchaseBill;
use App\Models\VendorPurchaseOrder;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class VendorPurchaseBillController extends Controller
{
    /**
     * Display a listing of the vendor purchase bills.
     */
    public function index()
    {
        $vendorPurchaseBills = VendorPurchaseOrder::orderBy('created_at', 'desc')->get();
        return view('/warehouse/vendor-purchase-bills/index', compact('vendorPurchaseBills'));
    }

    /**
     * Show the form for creating a new vendor purchase bill.
     */
    public function create()
    {
        $vendors = Vendor::all();
        return view('/warehouse/vendor-purchase-bills/create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'po_number' => 'required|string|max:100',
            'invoice_number' => 'required|string|max:100',
            'invoice_pdf' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'purchase_date' => 'required|date',
            'po_amount_due_date' => 'required|date',
            'po_amount' => 'required|numeric|min:0',
            'po_amount_paid' => 'nullable|numeric|min:0',
            'po_status' => 'required|in:pending,approved,rejected,cancelled',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Handle file upload
        if ($request->hasFile('invoice_pdf')) {
            $file = $request->file('invoice_pdf');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/vendor-purchase-bills'), $filename);
            $validatedData['invoice_pdf'] = 'uploads/vendor-purchase-bills/'.$filename;
        }
        $validatedData['po_amount_pending'] = $validatedData['po_amount'] - $validatedData['po_amount_paid'];

        $vendorPurchaseBill = VendorPurchaseOrder::create($validatedData);

        if (! $vendorPurchaseBill) {
            return back()->with('error', 'Failed to create vendor purchase bill. Please try again.');
        }

        return redirect()->route('vendor.index')->with('success', 'Vendor Purchase Bill created successfully.');
    }

    /**
     * Display the specified vendor purchase bill.
     */
    public function view($id)
    {
        $vendorPurchaseBill = VendorPurchaseOrder::findOrFail($id);

        return view('/warehouse/vendor-purchase-bills/view', compact('vendorPurchaseBill'));
    }

    /**
     * Show the form for editing the specified vendor purchase bill.
     */
    // public function edit($id)
    // {
    //     $vendorPurchaseBill = VendorPurchaseBill::findOrFail($id);
    //     return view('/warehouse/vendor-purchase-bills/edit', compact('vendorPurchaseBill'));
    // }

    public function edit($id)
    {
        $vendorPurchaseBill = VendorPurchaseOrder::find($id);
        $vendors = Vendor::all();

        if (! $vendorPurchaseBill) {
            return redirect()->route('vendor.index')->with('error', 'Record not found.');
        }

        return view('/warehouse/vendor-purchase-bills/edit', compact('vendorPurchaseBill', 'vendors'));
    }

    /**
     * Update the specified vendor purchase bill in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'po_number' => 'required|string|max:100',
            'invoice_number' => 'required|string|max:100',
            'invoice_pdf' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'purchase_date' => 'required|date',
            'po_amount_due_date' => 'required|date',
            'po_amount' => 'required|numeric|min:0',
            'po_amount_paid' => 'nullable|numeric|min:0',
            'po_amount_pending' => 'nullable|numeric|min:0',
            'po_status' => 'required|in:pending,approved,rejected,cancelled',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Handle file upload
        if ($request->hasFile('invoice_pdf')) {
            $file = $request->file('invoice_pdf');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/vendor-purchase-bills'), $filename);
            $validatedData['invoice_pdf'] = 'uploads/vendor-purchase-bills/'.$filename;
        }

        $validatedData['po_amount_pending'] = $validatedData['po_amount'] - $validatedData['po_amount_paid'];

        VendorPurchaseOrder::where('id', $id)->update($validatedData);

        return redirect()->route('vendor.index')->with('success', 'Vendor Purchase Bill updated successfully.');
    }

    /**
     * Remove the specified vendor purchase bill from storage.
     */
    public function destroy($id)
    {
        $vendorPurchaseBill = VendorPurchaseOrder::withCount('products')->find($id);
        if (! $vendorPurchaseBill) {
            return redirect()->route('vendor.index')->with('error', 'Record not found.');
        }
        // Delete attachment file if exists
        if ($vendorPurchaseBill->invoice_pdf && file_exists(public_path($vendorPurchaseBill->invoice_pdf))) {
            unlink(public_path($vendorPurchaseBill->invoice_pdf));
        }

        if ($vendorPurchaseBill->products_count > 0) {
            return redirect()->route('vendor.index')->with('error', 'Cannot delete vendor purchase bill with products.');
        }

        $vendorPurchaseBill->delete();

        if (! $vendorPurchaseBill) {
            return redirect()->route('vendor.index')->with('error', 'Failed to delete vendor purchase bill. Please try again.');
        }

        return redirect()->route('vendor.index')->with('success', 'Vendor Purchase Bill deleted successfully.');
    }
}
