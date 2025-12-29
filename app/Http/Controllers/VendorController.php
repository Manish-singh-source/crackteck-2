<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    //
    public function index()
    {
        $vendors = Vendor::all();

        return view('warehouse/vendor/index', compact('vendors'));
    }

    public function create()
    {
        return view('warehouse/vendor/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:vendors,email',
            'address1' => 'required|min:3',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',
            'pan_no' => 'nullable|unique:vendors,pan_no',
            'gst_no' => 'nullable|unique:vendors,gst_no',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vendor = new Vendor;
        // VD-25-0001
        $vendor->vendor_code = 'VD-'.date('y').'-'.str_pad(Vendor::count() + 1, 4, '0', STR_PAD_LEFT);
        $vendor->first_name = $request->first_name;
        $vendor->last_name = $request->last_name;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->address1 = $request->address1;
        $vendor->address2 = $request->address2;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->country = $request->country;
        $vendor->pincode = $request->pincode;
        $vendor->pan_no = $request->pan_no;
        $vendor->gst_no = $request->gst_no;
        $vendor->status = $request->status;

        $vendor->save();

        if (! $vendor) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('vendor_list.index')->with('success', 'Vendor added successfully.');
    }

    public function edit($id)
    {
        $vendor = Vendor::find($id);

        return view('warehouse/vendor/edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:vendors,email,'.$id,
            'address1' => 'required|min:3',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',
            'pan_no' => 'nullable|unique:vendors,pan_no,'.$id,
            'gst_no' => 'nullable|unique:vendors,gst_no,'.$id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vendor = Vendor::findOrFail($id);
        $vendor->first_name = $request->first_name;
        $vendor->last_name = $request->last_name;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->address1 = $request->address1;
        $vendor->address2 = $request->address2;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->country = $request->country;
        $vendor->pincode = $request->pincode;
        $vendor->pan_no = $request->pan_no;
        $vendor->gst_no = $request->gst_no;
        $vendor->status = $request->status;

        $vendor->save();

        if (! $vendor) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('vendor_list.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendor_list.index')->with('success', 'Vendor deleted successfully.');
    }
}
