<?php

namespace App\Http\Controllers;

use App\Events\CustomerStatusChange;
use App\Events\staffCustomerStatusChange;
use App\Events\notificationEvent;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('created_at', 'desc')->get();
        $roles = Role::all();

        return view('Pages.employee.index', compact('employees', 'roles'));
    }
    public function create()
    {
        $services = Service::where('status', 1)->get();
        $branches = Branch::all();
        $categories = Category::all();
        return view('Pages.employee.create', compact('services','categories', 'branches'));
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $services = Service::where('status', 1)->get();
        $branches = Branch::all();
        $categories = Category::all();
        return view('Pages.employee.edit', compact('employee','categories', 'services', 'branches'));
    }
     public function store(Request $request)
    {
        $rules = [
            'service_group' => 'required',
            'code' => 'required',
            'branch_id' => 'required|integer|exists:branches,id',
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
        $employee->service_group = $validatedData['service_group'];
        $employee->code = $validatedData['code'];
        $employee->branch_id = $validatedData['branch_id'];
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
            'service_group' => 'required',
            'code' => 'required|unique:employees,code,' . $id,
            'branch_id' => 'required|string|exists:branches,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',

                // Ignore current employee email in uniqueness check
                Rule::unique('employees', 'email')->ignore($id),

                // Custom rule to check if email is already used in the users table
                function ($attribute, $value, $fail) use ($id) {
                    $employee = Employee::find($id);
                    $user = User::where('email', $value)->first();
                    // If a user exists with this email and it's not linked to this employee
                    if ($user && $user->emp_id != $employee->id) {
                        $fail('The email is already used by another user.');
                    }
                }
            ],
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
            'service_group' => $validatedData['service_group'],
            'branch_id' => $validatedData['branch_id'],
            'code' => $validatedData['code'],
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
        $user = User::where('emp_id', $employee->id)->first();

        if($user){
        $user->name =  $employee->first_name . ' ' . $employee->middle_name;
        $user->email = $employee->email;
        $user->phone = $employee->phone;
        $user->save();
        }
        // $notification = new Notification();
        // $notification->user_id = $user->id;
        // $notification->title = 'Profile Updated';
        // $notification->message = 'Your Profile Updated bY Admin';
        // $notification->save();


        return redirect()->route('employee')->with('success', 'Employee updated successfully.');
    }
    public function destroy($id)
    {
          $trnasaction = Transaction::where('employee_id',$id)->count();
        if ($trnasaction > 0) {
        return redirect()->back()->with('error', "The employee cannot be deleted because it is currently Associated to {$trnasaction} transaction(s).");
    }
          $parenttrnasaction = Transaction::where('parent_emp_id',$id)->count();
        if ($parenttrnasaction > 0) {
        return redirect()->back()->with('error', "The employee cannot be deleted because it is currently Associated to {$parenttrnasaction} transaction(s).");
    }
         $employee = Employee::where('branch_id',$id)->count();
        if ($employee > 0) {
        return redirect()->back()->with('error', "The branch cannot be deleted because it is currently Associated to {$employee} employee(s).");
    }
         $client = Client::where('employee_id',$id)->count();
        if ($client > 0) {
        return redirect()->back()->with('error', "The employee cannot be deleted because it is currently Associated to {$client} customer(s).");
    }
         $user = User::where('emp_id',$id)->count();
        if ($user > 0) {
        return redirect()->back()->with('error', "The employee cannot be deleted because it is currently Associated to {$user} system user(s).");
    }
         $notification = Notification::where('user_id',$id)->count();
        if ($notification > 0) {
        return redirect()->back()->with('error', "The employee cannot be deleted because it is currently Associated to {$notification} notification(s).");
    }
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()->back()->with('error', 'Employee deleted successfully');
    }



    public function client_index()
    {
        $employees = Employee::where('status', 1)
        ->whereIn('service_group', ['ስፓ', 'ጸጉር ቆራጭ', 'የውስጥ ስራዎች'])
        ->orderBy('first_name', 'asc')
        ->get();

        $branches = Branch::all();

        return view('Pages.client.index', compact('employees', 'branches'));
    }


    public function client_create()
    {
        $employees = Employee::where('status',1)
                            ->whereIn('service_group', ['ስፓ', 'ጸጉር ቆራጭ', 'የውስጥ ስራዎች'])
                            ->orderBy('first_name', 'asc')
                            ->get();
        $branchs = Branch::all();
        
        return view('Pages.client.create', compact('employees','branchs'));
    }


    public function client_edit($id)
    {
        $employees = Employee::where('status',1)
                            ->whereIn('service_group', ['ስፓ', 'ጸጉር ቆራጭ', 'የውስጥ ስራዎች'])
                            ->orderBy('first_name', 'asc')
                            ->get();
        $branchs = Branch::all();
        $client = Client::findOrFail($id);
        return view('Pages.client.edit', compact('client', 'employees','branchs'));
    }


    public function client_store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'employee_id' => 'required|exists:employees,id',
            'code' => 'required|string|max:50|unique:clients,code',
            'branch_id' => 'required|integer|exists:branches,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'sex' => 'required|in:Male,Female,Other',
            'category' => 'required|string',
            'status' => 'nullable|integer|in:0,1',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        
        $validatedData = $request->validate($rules);
        
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
        
        $client = new Client();
        $user = Auth::user()->id;
        $client->employee_id = $validatedData['employee_id'];
        $client->branch_id = $validatedData['branch_id'];
        $client->code = $validatedData['code'];
        $client->name = $validatedData['name'];
        $client->phone = $validatedData['phone'];
        $client->sex = $validatedData['sex'];
        $client->category = $validatedData['category'];
        $client->remark = $validatedData['remark'] ?? NULL;
        $client->created_by = $user;
        $client->status = $validatedData['status'] ?? 1;
        $client->image = $filesImage;
        $client->save();
        return redirect()->route('client')->with('success', 'Customer Created successfully.');
    }


    public function client_update(Request $request, $id)
    {
        // Find the employee record
        $client = Client::findOrFail($id);
        $filesImage = $client->image;
        // Validation rules
        $rules = [
            'employee_id' => 'required|exists:employees,id',
            'branch_id' => 'required|integer|exists:branches,id',
            'code' => ['required', 'string','max:50', Rule::unique('clients', 'code')->ignore($id),],
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'sex' => 'required|in:Male,Female,Other',
            'category' => 'required|string',
            'status' => 'nullable|integer|in:0,1',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        // Validate request data
        $validatedData = $request->validate($rules);
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


        // Update employee data
        $client->update([
            'employee_id' => $validatedData['employee_id'],
            'branch_id' => $validatedData['branch_id'],
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'sex' => $validatedData['sex'],
            'category' => $validatedData['category'],
            'remark' => $validatedData['remark'] ?? NULL,
            'status' => $validatedData['status'] ?? 1,
            'image' => $filesImage,
        ]);

        return redirect()->route('client')->with('success', 'Customer updated successfully.');
    }


    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $client = Client::find($request->id);

        if (!$client) {
            return redirect()->back()->with('error', 'Customer not found');
        }

        $user = Auth::user();
        $branch_id = $user->employee->branch_id ?? NUll;

        $oldEmployeeIds = is_array($client->employee_id) ? $client->employee_id : [];
        $employeeIds = is_array($request->employee_id) ? $request->employee_id : [];

        // Ensure both are arrays of strings (optional but safer)
        $oldEmployeeIds = array_map('strval', $oldEmployeeIds);
        $employeeIds = array_map('strval', $employeeIds);

        // Get all unique IDs (merged)
        $allEmployeeIds = collect($oldEmployeeIds)->merge($employeeIds)->unique()->values();

        // Get removed employee IDs (in old but not in new)
        $removedEmployeeIds = array_diff($oldEmployeeIds, $employeeIds);

        // Get newly assigned employee IDs (in new but not in old)
        // $addedEmployeeIds = array_diff($newEmployeeIds, $oldEmployeeIds);
        // Merge and make unique
        // $employeeIds = collect($oldEmployeeIds)
        //     ->merge($newEmployeeIds)
        //     ->unique()
        //     ->values(); // optional: reset keys

        // Save array of employee IDs to the client
        $client->status = $request->status;
        $client->branch_id = $branch_id;
        $client->employee_id = $employeeIds; // Store as array
        $client->save();

        foreach ($employeeIds as $employeeId) {
            $user = User::where('emp_id', $employeeId)->first();

            if ($user) {
                $notification = new Notification();
                $notification->user_id = $user->id;
                $notification->title = 'New customer assigned';
                $notification->message = 'Customer ' . $client->name . ' has been assigned to you';
                $notification->save();

                $message = [
                    'id' => $notification->id,
                    'created_at' => $notification->created_at,
                    'title' => 'New customer assigned',
                    'message' => 'Customer ' . $client->name . ' has been assigned to you',
                ];

                event(new notificationEvent($message, $employeeId));
            }
        }
        //     $clients = Client::where('status', 1)
        //     ->where(function ($query) use ($serviceGroupEmployeeIds) {
        //         foreach ($serviceGroupEmployeeIds as $id) {
        //             $query->orWhereJsonContains('employee_id', (string) $id);
        //         }
        //     })
        //     ->get();

        //     $clients->transform(function ($client) use ($employees) {
        //     $clientEmployeeDetails = [];

        //     foreach ($client->employee_id as $empId) {
        //         if ($employees->has($empId)) {
        //             $clientEmployeeDetails[] = $employees[$empId];
        //         }
        //     }

        //     $client->employee_details = $clientEmployeeDetails;
        //     return $client;
        // });
        foreach ($employeeIds as $employeeId) {
                $customers = Client::where('status', 1)
                ->whereJsonContains('employee_id', (string) $employeeId)
                ->get();
                broadcast(new staffCustomerStatusChange($customers, (string) $employeeId));
            }
        foreach ($removedEmployeeIds as $employeeId) {
                $customers = Client::where('status', 1)
                ->whereJsonContains('employee_id', (string) $employeeId)
                ->get();
                broadcast(new staffCustomerStatusChange($customers, (string) $employeeId));
            }
            $activeCustomers = Client::where('status', 1)->get();

            broadcast(new CustomerStatusChange($activeCustomers));

            return redirect()->back()->with('success', 'Customer status updated successfully!');
    }

    public function client_destroy($id)
    {
         $trnasaction = Transaction::where('client_id',$id)->count();
        if ($trnasaction > 0) {
        return redirect()->back()->with('error', "The client cannot be deleted because it is currently Associated to {$trnasaction} transaction(s).");
         }
        $client = Client::findOrFail($id);

        $client->delete();

        return redirect()->back()->with('error', 'Customer deleted successfully');
    }


    public function empupdateStatus(Request $request)
    {
        $employee = Employee::find($request->id);

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'employee not found'], 404);
        }

        $employee->status = $request->status;
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Employee status updated successfully!']);
    }

    public function getClient(Request $request)
    {
        // $query = Client::with(['branch', 'user'])->orderBy('created_at', 'desc');
        $query = Client::with(['branch', 'user'])
                    ->orderBy('status', 'desc')  
                    ->orderBy('created_at', 'desc');

        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('employee_id')) {
            $query->whereJsonContains('employee_id', $request->employee_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('image', fn($row) =>
                '<img src="' . asset('file/' . $row->image) . '" style="width: 70px; height: 50px;">'
            )
            ->addColumn('status', function ($row) {
                $statusClass = $row->status == 1 ? 'bg-success' : 'bg-danger';
                $statusText = $row->status == 1 ? 'Active' : 'Inactive';
                $employeeIds = htmlspecialchars(json_encode($row->employee_id ?? []));

                return '
                    <a href="#"
                    class="navbar-nav-link navbar-nav-link-icon rounded-pill client-status-btn"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#statuses"
                    data-id="' . $row->id . '"
                    data-status="' . $row->status . '"
                    data-employee=\'' . $employeeIds . '\'>
                        <span class="badge ' . $statusClass . '">' . $statusText . '</span>
                    </a>';
            })
            ->addColumn('action', function ($row) {
                $edit = '';
                $delete = '';

                if (auth()->user()->can('edit_customer')) {
                    $edit = '<a href="' . route('client.edit', $row->id) . '" class="dropdown-item">
                                <i class="ph-pencil-line me-2"></i>Edit
                            </a>';
                }

                if (auth()->user()->can('delete_customer')) {
                    $delete = '<form action="' . route('client.delete', $row->id) . '" method="POST" style="display:inline;">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this Client?\');">
                                        <i class="ph-trash me-2"></i>Delete
                                    </button>
                            </form>';
                }

                return '<div class="d-inline-flex">
                            <div class="dropdown">
                                <a href="#" class="text-body" data-bs-toggle="dropdown"><i class="ph-list"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    ' . $edit . $delete . '
                                </div>
                            </div>
                        </div>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
        }
    }
