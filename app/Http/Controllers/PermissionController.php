<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    //
    public function indexPermission(){
        $permissions=Permission::all();
        return view('backend.users.permission.permission',compact('permissions'));
    }
    public function createPermission(){
        return view('backend.users.permission.create_permission');
    }

    public function addPermissions(Request $request){
        $request->validate([
            'permission_name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->permission_name]);

        // clear Spatie permission cache so new permission is available immediately
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');

    }

    public function editPermissions($id){
        $permission=Permission::findOrFail($id);
        return view('backend.users.permission.edit_permission', compact('permission'));
    }


    public function updatePermissions(Request $request, $id)
    {
        $request->validate([
            'permission_name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->permission_name,
        ]);

        // IMPORTANT: clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('update_message', 'Permission updated successfully.');
    }

    public function destroyPermissions($id)
    {
        $permission = Permission::findOrFail($id);

        // detach from roles
        $permission->roles()->detach();

        $permission->delete();

        // clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', 'Permission deleted successfully');
    }

}
