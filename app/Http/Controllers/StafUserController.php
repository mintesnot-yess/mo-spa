<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StafUserController extends Controller
{
    public function staff()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('Pages.user.index', compact('users'));
    }
    public function staff_create()
    {
        // Fetch all customers from the database
        $roles = Role::all();;

        // Pass the users to the view
        return view('Pages.user.create', compact('roles'));
    }
    public function staff_store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,            
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $role = Role::find($request->role);
        $user->syncRoles($role);

        return redirect()->route('staff.index')->with('success', 'Staff user successfully Added');
    }
    public function staff_edit($id)
    {
        // Fetch all customers from the database
        $user = User::find($id);
        $roles = Role::all();
        // Pass the users to the view
        return view('Pages.user.edit', compact('user', 'roles'));
    }
    public function staff_update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'role' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $role = Role::find($request->role);
        $user->syncRoles($role);

        return redirect()->route('staff.index')->with('success', 'Staff user successfully Updated');
    }
    public function staff_delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('staff.index')->with('error', 'Staff user successfully Deleted');
    }
}
