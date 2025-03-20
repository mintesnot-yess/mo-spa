<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.employee.index', compact('employees'));
    }
    public function create()
    {
        $services = Service::where('status', 1)->get();
        return view('Pages.employee.create', compact('services'));
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $services = Service::where('status', 1)->get();
        return view('Pages.employee.edit', compact('employee', 'services'));
    }
    public function store(Request $request)
    {
        $rules = [
            'service_id' => 'required|integer|exists:services,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'required|string|max:20|unique:employees,phone',
            'sex' => 'required|in:Male,Female',
            'dob' => 'required|date',
            'joind_date' => 'required|date',
        ];
        $validatedData = $request->validate($rules);
        $employee = new Employee();
        $user = Auth::user()->id;
        $employee->service_id = $validatedData['service_id'];
        $employee->first_name = $validatedData['first_name'];
        $employee->middle_name = $validatedData['middle_name'] ?? null;
        $employee->last_name = $validatedData['last_name'];
        $employee->email = $validatedData['email'];
        $employee->phone = $validatedData['phone'];
        $employee->sex = $validatedData['sex'];
        $employee->dob = $validatedData['dob'];
        $employee->join_date = $validatedData['joind_date'];
        $employee->created_by = $user;
        $employee->save();
        return redirect()->route('employee')->with('success', 'Employee Created successfully.');
    }
    public function update(Request $request, $id)
    {
        // Find the employee record
        $employee = Employee::findOrFail($id);

        // Validation rules
        $rules = [
            'service_id' => 'required|string|exists:services,id',
            'service_id' => 'required|string',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $id,
            'phone' => 'required|string|max:20|unique:employees,phone,' . $id,
            'sex' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'joind_date' => 'required|date',
        ];

        // Validate request data
        $validatedData = $request->validate($rules);

        $user = Auth::user()->id;
        // Update employee data
        $employee->update([
            'service_id' => $validatedData['service_id'],
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'] ?? null,
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'sex' => $validatedData['sex'],
            'dob' => $validatedData['dob'],
            'join_date' => $validatedData['joind_date'],
            'created_by' => $user,
        ]);

        return redirect()->route('employee')->with('success', 'Employee updated successfully.');
    }
    public function destroy($id)
    {
        // $expense = Expense::where('driver_id', $id)->first();
        // $order = Order::where('driver_id', $id)->first();
        // if ($expense || $order) {
        //     return redirect()->back()->with('error', 'Cannot delete: There is an expense or order associated with this Employee.');
        // }
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()->back()->with('error', 'Employee deleted successfully');
    }
    public function client_index()
    {
        $employees = Employee::all();
        $clients = Client::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.client.index', compact('clients', 'employees'));
    }
    public function client_create()
    {
        $employees = Employee::all();
        return view('Pages.client.create', compact('employees'));
    }
    public function client_edit($id)
    {
        $employees = Employee::all();
        $client = Client::findOrFail($id);
        return view('Pages.client.edit', compact('client', 'employees'));
    }
    public function client_store(Request $request)
    {
        $rules = [
            'employee_id' => 'required|integer|exists:employees,id',
            'code' => 'required|string|max:50|unique:clients,code',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:clients,phone',
            'sex' => 'required|in:Male,Female,Other',
            'category' => 'required|string',
            'remark' => 'required|string',
            'status' => 'nullable|integer|in:0,1',
        ];
        $validatedData = $request->validate($rules);
        $client = new Client();
        $user = Auth::user()->id;
        $client->employee_id = $validatedData['employee_id'];
        $client->code = $validatedData['code'];
        $client->name = $validatedData['name'];
        $client->phone = $validatedData['phone'];
        $client->sex = $validatedData['sex'];
        $client->category = $validatedData['category'];
        $client->remark = $validatedData['remark'];
        $client->created_by = $user;
        $client->status = $validatedData['status'] ?? 1;
        $client->save();
        return redirect()->route('client')->with('success', 'Customer Created successfully.');
    }
    public function client_update(Request $request, $id)
    {
        // Find the employee record
        $client = Client::findOrFail($id);

        // Validation rules
        $rules = [
            'employee_id' => 'required|integer|exists:employees,id',
            'code' => 'required|string|max:50|unique:clients,code,' . $id,
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:clients,phone,' . $id,
            'sex' => 'required|in:Male,Female,Other',
            'category' => 'required|string',
            'remark' => 'required|string',
            'status' => 'nullable|integer|in:0,1',
        ];

        // Validate request data
        $validatedData = $request->validate($rules);

        // Update employee data
        $client->update([
            'employee_id' => $validatedData['employee_id'],
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'sex' => $validatedData['sex'],
            'category' => $validatedData['category'],
            'remark' => $validatedData['remark'],
            'status' => $validatedData['status'] ?? 1,
        ]);

        return redirect()->route('client')->with('success', 'Customer updated successfully.');
    }
    public function updateStatus(Request $request)
    {
        $client = Client::find($request->id);

        if (!$client) {
            return redirect()->back()->with('error', 'Customer not found');
        }

        $client->status = $request->status;
        $client->employee_id = $request->employee_id;
        $client->save();

        return redirect()->back()->with('success', 'Customer status updated successfully!');
    }
    public function client_destroy($id)
    {
        // $order = Order::where('client_id', $id)->first();
        // if ($order) {
        //     return redirect()->back()->with('error', 'Cannot delete: There is an order associated with this client.');
        // }
        $client = Client::findOrFail($id);

        $client->delete();

        return redirect()->back()->with('error', 'Customer deleted successfully');
    }
}
