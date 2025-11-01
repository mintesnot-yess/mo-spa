<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Item;
use App\Models\Notification;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StafUserController extends Controller
{
    public function staff()
    {
        $users = User::where('id', '!=', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('Pages.user.index', compact('users'));
    }
    public function staff_create()
    {
        // Fetch all customers from the database
        $roles = Role::all();
        $empIds = User::pluck('emp_id');
        $employees = Employee::whereNotIn('id',$empIds)->get();
        // Pass the users to the view
        return view('Pages.user.create', compact('roles','employees'));
    }
    public function staff_store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'role' => ['required'],
            // 'email' => 'required|email|unique:users,email',
            'employee' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $filesImage = "Defulte.png";
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $slug = Str::slug($request->name_en);
            $currentDate = Carbon::now()->toDateString();
            $filesImage = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!file_exists('file')) {
                mkdir('file', 0777, true);
            }
            $image->move('file', $filesImage);
        }
        $employee = Employee::find($request->employee);
        $user = User::create([
            'name' => trim($employee->first_name . ' ' . ($employee->middle_name ?? $employee->last_name)),
            'emp_id'=> $request->employee,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'password' => Hash::make($request->password),
            'image' => $filesImage,
        ]);
        $role = Role::find($request->role);
        $user->syncRoles($role);

        return redirect()->route('staff.index')->with('success', 'Staff user successfully Added');
    }
    public function user_from_employee(Request $request)
    {
        
        $request->validate([
            'role' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $filesImage = "Defulte.png";
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $slug = Str::slug($request->name_en);
            $currentDate = Carbon::now()->toDateString();
            $filesImage = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!file_exists('file')) {
                mkdir('file', 0777, true);
            }
            $image->move('file', $filesImage);
        }
        $employee = Employee::find($request->emp_id);
        
        $user = User::create([
            'emp_id'=> $request->emp_id,
            'name' => $employee->first_name . ' ' . $employee->middle_name,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'password' => Hash::make($request->password),
            'image' => $filesImage,
        ]);

        $role = Role::find($request->role);
        $user->syncRoles($role);
        return redirect()->back()->with('success', 'Employee successfully Added to staf user');
    }
    public function staff_edit($id)
    {
        
        $user = User::find($id);
        $roles = Role::all();
        $empIds = User::where('id', '!=', $user->id)->pluck('emp_id');
        $employees = Employee::whereNotIn('id',$empIds)->get();
        
        return view('Pages.user.edit', compact('user', 'roles','employees'));
    }
    public function staff_update(Request $request, $id)
    {
        $request->validate([
            'employee' => ['required'],
            'role' => ['required'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $user = User::find($id);
        $filesImage = $user->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $slug = Str::slug($request->name_en);
            $currentDate = Carbon::now()->toDateString();
            $filesImage = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!file_exists('file')) {
                mkdir('file', 0777, true);
            }
            $image->move('file', $filesImage);
        }
        $employee = Employee::find($request->employee);
        $user->name = $employee->first_name . ' ' . $employee->middle_name;
        $user->emp_id = $request->employee;
        $user->email = $employee->email;
        $user->phone = $employee->phone;
        $user->image = $filesImage;

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
        $trnasaction = Transaction::where(function($query) use ($id) {
                 $query->where('created_by', $id)
                          ->orWhere('updated_by', $id);
                })->count();
        if ($trnasaction > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$trnasaction} transaction(s).");
           }
        $service = Service::where(function($query) use ($id) {
                 $query->where('created_by', $id)
                          ->orWhere('updated_by', $id);
                })->count();
        if ($service > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$service} service(s).");
           }
         
        $branch = Branch::where('created_by', $id)->count();
        if ($branch > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$branch} branch(s).");
           }
        $category = Category::where('created_by', $id)->count();
        if ($category > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$category} category(s).");
           }
        $client = Client::where('created_by', $id)->count();
        if ($client > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$client} customer(s).");
           }
        $employee = Employee::where('created_by', $id)->count();
        if ($employee > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$employee} employee(s).");
           }
           
        $item = Item::where('created_by', $id)->count();
        if ($item > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$item} item(s).");
           }
        $serviceItem = ServiceItems::where('created_by', $id)->count();
        if ($serviceItem > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$serviceItem} service Items(s).");
           }
        $notification = Notification::where('user_id', $id)->count();
        if ($notification > 0) {
        return redirect()->back()->with('error', "The user cannot be deleted because it is currently Associated to {$notification} notification(s).");
           }
         
        $user = User::find($id);
        $user->delete();

        return redirect()->route('staff.index')->with('error', 'Staff user successfully Deleted');
    }

    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'user not found'], 404);
        }
    
        $user->status = $request->status;
        $user->save();
    
        return response()->json(['success' => true, 'message' => 'User status updated successfully!']);
    }
}
