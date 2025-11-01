<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:add_role', ['only' => ['create','store']]);
        $this->middleware('permission:edit_role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }
    
    public function create(){
        return view('Pages.rolePermission.create');
    }
    public function store(Request $request){
        $request ->validate([
            'name' =>'required|unique:roles,name',
        ]);
        $role = Role::create([
            'name' => $request-> name
        ]);
        return redirect()->route('rolepermission')->with('success', 'Role Created Successfully !');
    }
    public function edit($id){
        $role = Role::find($id);
        if($role->name === 'Admin'){            
            return redirect()->back()->with('error', 'Role Admin can not be edited.');
        }
        return view('Pages.rolePermission.edit', ['role' => $role]);
    }
    public function update(Request $request,$id){
        $request ->validate([
            'name' =>'required'
            ]);
            $role = Role::find($id);
            // dd($role);
            $role->update([
            'name' => $request-> name
        ]);

        return redirect()->route('rolepermission')->with('success', 'Role Updated Successfully !');
    }
    public function delete($id){

        $role = Role::find($id);
        if($role->name === 'Admin'){            
            return redirect()->back()->with('error', 'Role Admin can not be deleted.');
        }
         // Check if any users have this role
    $usersWithRole = User::role($role->name)->count();

    if ($usersWithRole > 0) {
        return redirect()->back()->with('error', "The role '{$role->name}' cannot be deleted because it is currently assigned to {$usersWithRole} user(s).");
    }
        $role->delete();
        return redirect()->route('rolepermission')->with('error','Role Deleted Successfully !');
    }
}
