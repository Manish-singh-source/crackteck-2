<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    //
    public function index()
    {
        $warehouses = Warehouse::all();

        return view('/warehouse/warehouses-list/index', compact('warehouses'));
    }

    public function create()
    {
        return view('/warehouse/warehouses-list/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'type' => 'required',
            'address1' => 'required|min:3',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',
            'contact_person_name' => 'required|min:3',
            'phone_number' => 'required|digits:10',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check for default warehouse
        if ($request->default_warehouse == 1 && Warehouse::where('default_warehouse', 1)->exists()) {
            return back()->with('error', 'One warehouse has already default value kindly check.')->withInput();
        }

        $warehouse = new Warehouse;
        // warehouse_code
        $warehouse->warehouse_code = 'WH-'.date('y').'-'.str_pad(Warehouse::count() + 1, 4, '0', STR_PAD_LEFT);
        $warehouse->name = $request->name;
        $warehouse->type = $request->type;
        $warehouse->address1 = $request->address1;
        $warehouse->address2 = $request->address2;
        $warehouse->city = $request->city;
        $warehouse->state = $request->state;
        $warehouse->country = $request->country;
        $warehouse->pincode = $request->pincode;

        $warehouse->contact_person_name = $request->contact_person_name;
        $warehouse->phone_number = $request->phone_number;
        $warehouse->alternate_phone_number = $request->alternate_phone_number;
        $warehouse->email = $request->email;

        $warehouse->working_hours = $request->working_hours;
        $warehouse->working_days = $request->working_days;
        $warehouse->max_store_capacity = $request->max_store_capacity;
        $warehouse->supported_operations = $request->supported_operations;
        $warehouse->zone_conf = $request->zone_conf;

        $warehouse->gst_no = $request->gst_no;
        $warehouse->licence_no = $request->licence_no;
        $warehouse->licence_doc = $request->licence_doc;
        $warehouse->default_warehouse = $request->default_warehouse;
        $warehouse->verification_status = $request->verification_status;
        $warehouse->status = $request->status;
        $warehouse->save();

        return redirect()->route('warehouses-list.index')->with('success', 'Warehouse added successfully.');
    }

    public function view($id)
    {
        $warehouse = Warehouse::find($id);

        return view('/warehouse/warehouses-list/view', compact('warehouse'));
    }

    public function edit($id)
    {
        $warehouse = Warehouse::find($id);

        return view('/warehouse/warehouses-list/edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'type' => 'required',
            'address1' => 'required|min:3',
            'address2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|digits:6',
            'contact_person_name' => 'required|min:3',
            'phone_number' => 'required|digits:10',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check for default warehouse
        if ($request->default_warehouse == 1 && Warehouse::where('default_warehouse', 1)->where('id', '!=', $id)->exists()) {
            return back()->with('error', 'One warehouse has already default value kindly check.')->withInput();
        }

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->name = $request->name;
        $warehouse->type = $request->type;
        $warehouse->address1 = $request->address1;
        $warehouse->address2 = $request->address2;
        $warehouse->city = $request->city;
        $warehouse->state = $request->state;
        $warehouse->country = $request->country;
        $warehouse->pincode = $request->pincode;

        $warehouse->contact_person_name = $request->contact_person_name;
        $warehouse->phone_number = $request->phone_number;
        $warehouse->alternate_phone_number = $request->alternate_phone_number;
        $warehouse->email = $request->email;

        $warehouse->working_hours = $request->working_hours;
        $warehouse->working_days = $request->working_days;
        $warehouse->max_store_capacity = $request->max_store_capacity;
        $warehouse->supported_operations = $request->supported_operations;
        $warehouse->zone_conf = $request->zone_conf;

        $warehouse->gst_no = $request->gst_no;
        $warehouse->licence_no = $request->licence_no;
        $warehouse->licence_doc = $request->licence_doc;
        $warehouse->default_warehouse = $request->default_warehouse;
        $warehouse->verification_status = $request->verification_status;
        $warehouse->status = $request->status;
        $warehouse->save();

        return redirect()->route('warehouses-list.index')->with('success', 'Warehouse updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        $warehouse->default_warehouse = $request->default_warehouse;
        $warehouse->status = $request->status;
        $warehouse->verification_status = $request->verification_status;

        $warehouse->save();

        return redirect()->route('warehouses-list.index')->with('success', 'Warehouse updated successfully.');
    }

    public function delete($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('warehouses-list.index')->with('success', 'Warehouse deleted successfully.');
    }
}
