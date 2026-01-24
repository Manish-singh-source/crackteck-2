<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PincodeController extends Controller
{
    //
    public function index()
    {
        $pincode = Pincode::query();
        
        if($status = request()->get('delivery_status')) {
            $pincode = $pincode->where('delivery', $status);
        }
        if($status = request()->get('installation_status')) {
            $pincode = $pincode->where('installation', $status);
        }
        if($status = request()->get('repair_status')) {
            $pincode = $pincode->where('repair', $status);
        }
        if($status = request()->get('quick_service_status')) {
            $pincode = $pincode->where('quick_service', $status);
        }
        if($status = request()->get('amc_status')) {
            $pincode = $pincode->where('amc', $status);
        }
        $pincode = $pincode->get();


        return view('/crm/manage-pincodes/index', compact('pincode'));
    }

    public function create()
    {
        return view('/crm/manage-pincodes/create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pincode' => 'required',
            'delivery' => 'required',
            'repair' => 'required',
            'quick_service' => 'required',
            'amc' => 'required',
            'installation' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pincode = new Pincode;
        $pincode->pincode = $request->pincode;
        $pincode->delivery = $request->delivery;
        $pincode->installation = $request->installation;
        $pincode->repair = $request->repair;
        $pincode->quick_service = $request->quick_service;
        $pincode->amc = $request->amc;
        $pincode->save();

        if (! $pincode) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('pincodes.index')->with('success', 'Pincode added successfully.');
    }

    public function edit($id)
    {
        $pincode = Pincode::find($id);

        return view('/crm/manage-pincodes/edit', compact('pincode'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pincode' => 'required',
            'delivery' => 'required',
            'repair' => 'required',
            'quick_service' => 'required',
            'amc' => 'required',
            'installation' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pincode = Pincode::findOrFail($id);
        $pincode->pincode = $request->pincode;
        $pincode->delivery = $request->delivery;
        $pincode->repair = $request->repair;
        $pincode->quick_service = $request->quick_service;
        $pincode->amc = $request->amc;
        $pincode->installation = $request->installation;

        $pincode->save();

        return redirect()->route('pincodes.index')->with('success', 'Pincode updated successfully.');
    }

    public function delete($id)
    {
        $pincode = Pincode::findOrFail($id);
        $pincode->delete();

        return redirect()->route('pincodes.index')->with('success', 'Pincode deleted successfully.');
    }
}
