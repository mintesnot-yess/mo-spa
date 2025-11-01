<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\notificationEvent;
use App\Events\staffCustomerStatusChange;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Employee;
use App\Events\CustomerStatusChange;
use App\Models\Client;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function activeCustomers(Request $request)
    {
        $token = $request->bearerToken();
        $user = null;

   if ($token) {
       $accessToken = PersonalAccessToken::findToken($token);
       if ($accessToken) {
           $user = $accessToken->tokenable;
       }
   }
       $serviceGroups = $request->query('service_group') ?? NULL;
       $serviceGroup = $serviceGroups;
       // $user = Auth::user(); 

   if (!$user && !$serviceGroups) {
       return response()->json([
           'message' => 'Service group is required for guests.',
       ], 400);
   }

   if ($user && !$serviceGroups) {
       $employee = Employee::find($user->emp_id);
       $serviceGroup = $employee->service_group ?? null;
   }

   if (!$serviceGroup) {
       return response()->json([
           'message' => 'Service group is missing.',
       ], 400);
   }
//         $clients = Client::with(['employee' => function($query) {
//         $query->select('id', 'first_name', 'service_group');
//     }])
//     ->where('status', 1)
//   ->whereHas('employee', function ($query) use ($serviceGroup) {
//     $query->where('service_group', $serviceGroup);
// })
//     ->get();
$serviceGroupEmployeeIds = Employee::where('service_group', $serviceGroup)->pluck('id')->toArray();
$employees = Employee::whereIn('id', $serviceGroupEmployeeIds) 
    ->select('id', 'first_name', 'service_group')
    ->get()
    ->keyBy('id');
$clients = Client::where('status', 1)
    ->where(function ($query) use ($serviceGroupEmployeeIds) {
        foreach ($serviceGroupEmployeeIds as $id) {
            $query->orWhereJsonContains('employee_id', (string) $id);
        }
    })
    ->get();
    
    $clients->transform(function ($client) use ($employees) {
    $clientEmployeeDetails = [];

    foreach ($client->employee_id as $empId) {
        if ($employees->has($empId)) {
            $clientEmployeeDetails[] = $employees[$empId];
        }
    }

    $client->employee_details = $clientEmployeeDetails;
    return $client;
});

    // dd($clients,$serviceGroupEmployeeIds);

        return response()->json([
            'message' => 'Active customers retrieved successfully',
            'data' => $clients
        ]);
    }
    public function receptionactiveCustomers(Request $request)
    {
        
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        } 
        $clients = Client::where('status', 1)
                  ->get();

        return response()->json([
            'message' => 'Active customers retrieved successfully',
            'data' => $clients
        ]);
    }
    public function activeStaff()
    {
        // Fetch active clients (status = 1)
        $staffs = Employee::where('status', 1)->get();        
        return response()->json([
            'message' => 'Active staff retrieved successfully',
            'data' => $staffs
        ]);
    }
    public function staffCustomers(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        } 
        $user = Auth::user();  
        
        $clients =  Client::where('status', 1)
        ->whereJsonContains('employee_id', (string) $user->emp_id)
        ->get();

        return response()->json([
            'message' => 'Staff customers retrieved successfully',
            'data' => $clients
        ]);
    }
    public function scanCustomer(Request $request){
         // Ensure the user is authenticated
         if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        } 
        $user = auth()->user();
        $branch_id = $user->employee->branch_id;
        $client = Client::where('code',$request->customer_code)->first();
        $employee = Employee::where('branch_id',$branch_id)->where('status', 1)->get();
        return response()->json([
            'message' => 'Data retrieved successfully',
            'data'=>[
            'customer' => $client,
            'staff' => $employee
            ],
            
        ]);
    }
    public function activateCustomer(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        } 
         $user = auth()->user();
        $branch_id = $user->employee->branch_id;
        $client = Client::find($request->customer_id);
        
        $oldEmployeeIds = is_array($client->employee_id) ? $client->employee_id : [];
$employeeIds = is_array($request->employee_id) ? $request->employee_id : [];
        // Ensure both are arrays of strings (optional but safer)
$oldEmployeeIds = array_map('strval', $oldEmployeeIds);
$employeeIds = array_map('strval', $employeeIds);

// Get all unique IDs (merged)
$allEmployeeIds = collect($oldEmployeeIds)->merge($employeeIds)->unique()->values();

// Get removed employee IDs (in old but not in new)
$removedEmployeeIds = array_diff($oldEmployeeIds, $employeeIds);
        $client->status = 1;
        $client->branch_id = $branch_id;
        $client->employee_id = $employeeIds;
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

        return response()->json([
            'message' => 'customer activated successfully',
            'data' => $client
        ]);
    }
}
