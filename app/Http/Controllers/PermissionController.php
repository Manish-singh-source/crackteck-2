<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permission = Permission::all();

        return view('/crm/access-control/permission/index', compact('permission'));
    }

    public function create()
    {
        return view('/crm/access-control/permission/create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $permission = Permission::create(['name' => $request->name]);

        if (! $permission) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('permission.index')->with('success', 'Permission added successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);

        return view('/crm/access-control/permission/edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $permission = Permission::where('id', $id)->update(['name' => $request->name]);

        if (! $permission) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('permission.index')->with('success', 'Permission added successfully.');
    }

    public function delete($id)
    {
        $permission = Permission::findorFail($id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permission Deleted successfully.');
    }
}
