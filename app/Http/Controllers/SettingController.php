<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Expense;
use App\Models\LoadType;
use App\Models\Location;
use App\Models\Order;
use App\Models\PaymentCollection;
use Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;

class SettingController extends Controller
{
    
    public function setting()
    {
        $user = Auth::user();
        return view('Pages.setting', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $user->id,
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        // Update user information
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();

        return redirect()->back()->with('success', 'Profile successfully updated');
    }
    public function update_password(Request $request)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        $rules = [
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        if ($request->password) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Password successfully updated');
    }
  
    public function loadType_index()
    {
        $loadTypes = LoadType::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.loadType.index', compact('loadTypes'));
    }
    public function loadType_create()
    {
        return view('Pages.loadType.create');
    }
    public function loadType_edit($id)
    {
        $loadType = LoadType::findOrFail($id);
        return view('Pages.loadType.edit', compact('loadType'));
    }
    public function loadType_store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
        $validatedData = $request->validate($rules);
        $loadType = new LoadType();
        $loadType->name = $validatedData['name'];
        $loadType->save();
        return redirect()->route('loadType')->with('success', 'loadType updated successfully.');
    }
    public function loadType_update(Request $request, $id)
    {
        // Validate the request
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $validatedData = $request->validate($rules);
        $loadType = LoadType::findOrFail($id);

        $loadType->name = $validatedData['name'];
        $loadType->save();
        return redirect()->route('loadType')->with('success', 'loadType updated successfully.');
    }
     public function loadType_destroy($id)
    {
        $orders = Order::where('loadType_id', $id)
            ->get();
        if ($orders) {
            return redirect()->back()->with('error', 'Cannot delete: There is an order is associated with this load type.');
        }
        $loadType = LoadType::findOrFail($id);

        $loadType->delete();

        return redirect()->back()->with('error', 'load type deleted successfully');
    }
    public function location_index()
    {
        $locations = Location::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.location.index', compact('locations'));
    }
    public function location_create()
    {
        return view('Pages.location.create');
    }
    public function location_edit($id)
    {
        $location = Location::findOrFail($id);
        return view('Pages.location.edit', compact('location'));
    }
    public function location_store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
        $validatedData = $request->validate($rules);
        $location = new Location();
        $location->name = $validatedData['name'];
        $location->save();
        return redirect()->route('location')->with('success', 'location updated successfully.');
    }
    public function location_update(Request $request, $id)
    {
        // Validate the request
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $validatedData = $request->validate($rules);
        $location = Location::findOrFail($id);

        $location->name = $validatedData['name'];
        $location->save();
        return redirect()->route('location')->with('success', 'location updated successfully.');
    }
    public function location_destroy($id)
    {
        $orders = Order::where('loading_place', $id)
            ->orWhere('destination', $id)
            ->first();
        if ($orders) {
            return redirect()->back()->with('error', 'Cannot delete: There is an order is associated with this location.');
        }
        $location = Location::findOrFail($id);

        $location->delete();

        return redirect()->back()->with('error', 'Location deleted successfully');
    }
}
