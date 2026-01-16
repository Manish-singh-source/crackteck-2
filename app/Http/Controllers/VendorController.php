<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    //
    public function index(Request $request)
    {
        $vendors = Vendor::query();

        if (request()->has('status') && request('status') !== 'all') {
            $vendors->where('status', request('status'));
        }

        $vendors = $vendors->get();

        return view('warehouse/vendor/index', compact('vendors'));
    }

    public function create()
    {
        return view('warehouse/vendor/create');
    }

    public function store(StoreVendorRequest $request)
    {
        $data = $request->validated();

        // Generate vendor code: VD-25-0001
        $data['vendor_code'] = 'VD-' . date('y') . '-' . str_pad(Vendor::count() + 1, 4, '0', STR_PAD_LEFT);

        $vendor = Vendor::create($data);

        if (!$vendor) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()
            ->route('vendor_list.index')
            ->with('success', 'Vendor added successfully.');
    }

    public function edit($id)
    {
        $vendor = Vendor::find($id);

        return view('warehouse/vendor/edit', compact('vendor'));
    }

    public function update(UpdateVendorRequest $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        // Get validated data
        $data = $request->validated();

        $vendor->update($data);

        return redirect()
            ->route('vendor_list.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::withCount('products')->find($id);
        if (! $vendor) {
            return back()->with('error', 'Vendor not found.');
        }
        if ($vendor->products_count > 0) {
            return back()->with('error', 'Cannot delete vendor with associated products.');
        }
        $vendor->delete();

        return redirect()->route('vendor_list.index')->with('success', 'Vendor deleted successfully.');
    }
}
