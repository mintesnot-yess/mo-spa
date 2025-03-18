<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralPermission;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:show_role', ['only' => ['index','show']]);
        $this->middleware('permission:show_give_permission', ['only' => ['assignPermission']]);        
        $this->middleware('permission:edit_give_permission', ['only' => ['assignRolePermission']]);        
    }
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.rolePermission.rolePermission', compact('roles'));
    }
    public function assignPermission($id)
    {

        $role  = Role::findOrFail($id);
        if ($role->name === 'Admin') {
            return redirect()->back()->with('error', 'Can not assign permission for Admin role.');
        }
        $permissions = GeneralPermission::all();
        $rolePermissions = $role->permissions->pluck('name');
        $checkPermissions = Permission::all();
        // dd($rolePermissions);
        return view('Pages.rolePermission.assignPermission', compact('permissions', 'rolePermissions', 'role', 'checkPermissions'));
    }
    public function assignRolePermission(Request $request, $id)
    {
        // Fetch role by ID
        $role = Role::find($id);
        if ($role) {
            if ($role->name === 'Admin') {
                return redirect()->back()->with('error', 'Can not assign permission for Admin role.');
            }
            $permissionNames = $request->input();
            $permissionKeys = array_keys($permissionNames);
            // dd($permissionKeys);
            $permissions = Permission::whereIn('name', $permissionKeys)->get();

            // Sync permissions with the role
            $role->syncPermissions($permissions);

            //  return redirect()->route('role')->with('success', 'Permissions assigned successfully.');
            return redirect()->route('rolepermission')->with('success', 'Permissions assigned successfully!');
        }

        return redirect()->back()->with('error', 'Role not found.');
    }
}
