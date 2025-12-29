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
        $pincode = Pincode::all();

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
            'installation' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $pincode = new Pincode;
        $pincode->pincode = $request->pincode;
        $pincode->delivery = $request->delivery;
        $pincode->installation = $request->installation;

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
        // dd($request->all());
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
