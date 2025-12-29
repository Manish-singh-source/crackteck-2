<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::all();

        return view('/crm/access-control/roles/index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('/crm/access-control/roles/create', compact('permissions'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::create(['name' => $request->name]);

        $role->syncPermissions($request->permission);

        if (! $role) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('roles.index')->with('success', 'Role Store successfully.');
    }

    public function edit($id)
    {
        $roles = Role::find($id);
        // dd($roles->permissions);
        $permissions = Permission::all();

        return view('/crm/access-control/roles/edit', compact('roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::find($id);
        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permission);

        if (! $role) {
            return back()->with('error', 'Something went wrong.');
        }

        return redirect()->route('roles.index')->with('success', 'Role Update successfully.');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
