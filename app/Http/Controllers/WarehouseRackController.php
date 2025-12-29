<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRackRequest;
use App\Models\Warehouse;
use App\Models\WarehouseRack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseRackController extends Controller
{
    //
    public function index()
    {
        $warehouse_racks = WarehouseRack::with('warehouse')->get();

        return view('/warehouse/rack/index', compact('warehouse_racks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();

        return view('/warehouse/rack/create', compact('warehouses'));
    }

    public function store(StoreWarehouseRackRequest $request)
    {

        $warehouse_rack = WarehouseRack::create($request->validated());

        // $warehouse_rack = new WarehouseRack();

        // $warehouse_rack->warehouse_id = $request->warehouse_id;
        // $warehouse_rack->rack_name = $request->rack_name;
        // $warehouse_rack->zone_area = $request->zone_area;
        // $warehouse_rack->rack_no = $request->rack_no;
        // $warehouse_rack->level_no = $request->level_no;
        // $warehouse_rack->position_no = $request->position_no;
        // $warehouse_rack->floor = $request->floor;
        // $warehouse_rack->quantity = $request->quantity;

        // $warehouse_rack->save();

        if (! $warehouse_rack) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('rack.index')->with('success', 'Warehouse Rack added successfully.');
    }

    public function edit($id)
    {
        $warehouse_rack = WarehouseRack::with('warehouse')->findOrFail($id);
        $warehouses = Warehouse::all();

        return view('/warehouse/rack/edit', compact('warehouse_rack', 'warehouses'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'warehouse_id' => 'required',
            'rack_name' => 'required',
            'zone_area' => 'required',
            'rack_no' => 'required',
            'level_no' => 'nullable',
            'position_no' => 'nullable',
            'floor' => 'nullable',
            'quantity' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $warehouse_rack = WarehouseRack::findOrFail($id);
        $warehouse_rack->warehouse_id = $request->warehouse_id;
        $warehouse_rack->rack_name = $request->rack_name;
        $warehouse_rack->zone_area = $request->zone_area;
        $warehouse_rack->rack_no = $request->rack_no;
        $warehouse_rack->level_no = $request->level_no;
        $warehouse_rack->position_no = $request->position_no;
        $warehouse_rack->floor = $request->floor;
        $warehouse_rack->quantity = $request->quantity;
        $warehouse_rack->save();

        return redirect()->route('rack.index')->with('success', 'Warehouse Rack updated successfully.');
    }

    public function delete($id)
    {
        $warehouse_rack = WarehouseRack::findOrFail($id);
        $warehouse_rack->delete();

        return redirect()->route('rack.index')->with('success', 'Warehouse Rack deleted successfully.');
    }

    public function getDependentData(Request $request)
    {
        $type = $request->type; // rack / zone / rack_no / level / position
        $id = $request->id;   // selected parent id

        $query = WarehouseRack::query();

        if ($type == 'rack') {
            $data = $query->where('warehouse_id', $id)->pluck('rack_name', 'id');
        } elseif ($type == 'zone') {
            $data = $query->where('id', $id)->pluck('zone_area', 'id');
        } elseif ($type == 'rack_no') {
            $data = $query->where('id', $id)->pluck('rack_no', 'id');
        } elseif ($type == 'level') {
            $data = $query->where('id', $id)->pluck('level_no', 'id');
        } elseif ($type == 'position') {
            $data = $query->where('id', $id)->pluck('position_no', 'id');
        } else {
            $data = [];
        }

        return response()->json($data);
    }
}
