<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::all();
        return view('backend.users.roles.roles', compact('roles'));
    }

    public function create()
    {
        $permissions=Permission::all();
        $users=User::select('name','id')->get();
        return view('backend.users.roles.create_role',compact('permissions','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role=Role::create(['name'=>$request->name]);
        foreach ($request->permissions as $permission) 
            {
                $role->givePermissionTo($permission);
            }

        if ($request->filled('users')) 
            {
                foreach ($request->users as $userId) 
                {
                    $user = User::find($userId);

                    if ($user) 
                    {
                        $user->assignRole($role->name);
                    }
                }
            }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $role=Role::findOrFail($role->id);

        $permissions=Permission::all();
        $users=User::select('name','id')->get();
        
        return view('backend.users.roles.edit_role', compact('role','permissions','users'));
    }

    public function update(Request $request, Role $role)
{
    $request->validate([
        'role_name' => 'required|unique:roles,name,' . $role->id,
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,name',
        'users' => 'nullable|array',
        'users.*' => 'exists:users,id',
    ]);

    $role->update([
        'name' => $request->role_name,
    ]);

    // Sync permissions
    $role->syncPermissions($request->permissions ?? []);

    // Sync users
    User::all()->each(function ($user) use ($role, $request) {
        if (in_array($user->id, $request->users ?? [])) {
            $user->assignRole($role);
        } else {
            $user->removeRole($role);
        }
    });

    app(PermissionRegistrar::class)->forgetCachedPermissions();

    return redirect()
        ->route('roles.index')
        ->with('update_message', 'Role updated successfully.');
}

    public function destroy(Role $role)
    {
        // Detach permissions
        $role->syncPermissions([]);

        // Remove role from users
        $role->users()->detach();

        $role->delete();

        // Clear cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('roles.index')
            ->with('delete_message', 'Role deleted successfully.');
    }
}
