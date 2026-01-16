<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorPurchaseOrderRequest;
use App\Http\Requests\UpdateVendorPurchaseOrderRequest;
use App\Models\Vendor;
use App\Models\VendorPurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Storage;

class VendorPurchaseBillController extends Controller
{
    /**
     * Display a listing of the vendor purchase bills.
     */
    public function index(Request $request)
    {
        $vendorPurchaseBills = VendorPurchaseOrder::query();

        if (request()->has('po_status') && request('po_status') !== 'all') {
            $vendorPurchaseBills->where('po_status', request('po_status'));
        }

        $vendorPurchaseBills = $vendorPurchaseBills->get();

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

    public function store(StoreVendorPurchaseOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Handle invoice upload
            if ($request->hasFile('invoice_pdf')) {
                $file = $request->file('invoice_pdf');
                $filename = time() . '_' . $file->getClientOriginalName();

                $data['invoice_pdf'] = $file->storeAs(
                    'uploads/vendor-purchase-bills',
                    $filename,
                    'public'
                );
            }

            // Calculate pending amount
            $data['po_amount_pending'] = $data['po_amount'] - $data['po_amount_paid'];

            VendorPurchaseOrder::create($data);

            DB::commit();

            return redirect()
                ->route('vendor.index')
                ->with('success', 'Vendor Purchase Bill created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Failed to create vendor purchase bill.')
                ->withInput();
        }
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
    public function update(UpdateVendorPurchaseOrderRequest $request, $id)
{
    try {
        DB::beginTransaction();

        $purchaseOrder = VendorPurchaseOrder::findOrFail($id);
        $data = $request->validated();

        // Replace invoice file if uploaded
        if ($request->hasFile('invoice_pdf')) {

            if ($purchaseOrder->invoice_pdf &&
                Storage::disk('public')->exists($purchaseOrder->invoice_pdf)) {
                Storage::disk('public')->delete($purchaseOrder->invoice_pdf);
            }

            $file = $request->file('invoice_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();

            $data['invoice_pdf'] = $file->storeAs(
                'uploads/vendor-purchase-bills',
                $filename,
                'public'
            );
        }

        // Recalculate pending amount
        $data['po_amount_pending'] = $data['po_amount'] - $data['po_amount_paid'];

        $purchaseOrder->update($data);

        DB::commit();

        return redirect()
            ->route('vendor.index')
            ->with('success', 'Vendor Purchase Bill updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()
            ->with('error', 'Failed to update vendor purchase bill.')
            ->withInput();
    }
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
