<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

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

    public function store(StoreWarehouseRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            // Generate warehouse code
            $data['warehouse_code'] = 'WH-' . date('y') . '-' .
                str_pad(Warehouse::count() + 1, 4, '0', STR_PAD_LEFT);

            // Handle file upload
            if ($request->hasFile('licence_doc')) {
                $file = $request->file('licence_doc');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs(
                    'uploads/warehouses/licence-docs',
                    $filename,
                    'public'
                );
                $data['licence_doc'] = $path;
            }

            Warehouse::create($data);

            DB::commit();

            return redirect()
                ->route('warehouses-list.index')
                ->with('success', 'Warehouse added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
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

    public function update(UpdateWarehouseRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $warehouse = Warehouse::findOrFail($id);
            $data = $request->validated();

            // Handle licence document replacement
            if ($request->hasFile('licence_doc')) {

                // delete old file
                if ($warehouse->licence_doc && Storage::disk('public')->exists($warehouse->licence_doc)) {
                    Storage::disk('public')->delete($warehouse->licence_doc);
                }

                $file = $request->file('licence_doc');
                $filename = time() . '_' . $file->getClientOriginalName();

                $data['licence_doc'] = $file->storeAs(
                    'uploads/warehouses/licence-docs',
                    $filename,
                    'public'
                );
            }

            $warehouse->update($data);

            DB::commit();

            return redirect()
                ->route('warehouses-list.index')
                ->with('success', 'Warehouse updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
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
