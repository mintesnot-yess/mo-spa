<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\notificationEvent;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Notification;
use App\Models\OrderedItems;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class ServiceController extends Controller
{
    
  public function index(Request $request)
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
  $services = Service::where('status', 1)
    ->where('type', $serviceGroup)
    ->with(['categories', 'itemServices.item'])
    ->get()
    ->map(function ($service) {
        if ($service->have_items === 'yes') {
            $service->items_list = $service->itemServices->map(function ($itemService) {
                return $itemService->item;
            })->filter();
        } else {
            $service->items_list = collect();
        }

        // Remove item_services from the output
        unset($service->itemServices);

        return $service;
    });

    return response()->json([
        'message' => 'Services retrieved successfully',
        'data' => $services
    ]);
}


    public function send_service_request(Request $request)
    {
        try {
            // Properly validate the request
            $validated = $request->validate([
                'customer_id' => 'required|exists:clients,id',
                'service_id' => 'required',
            ]);
            // employee_id:int, service_id:Array<int>, item_id:Array<int>
            $staff_id = null;

            if ($request->filled('emp_code')) {
                $employe = Employee::where('code', $request->emp_code)->first();

                if ($employe) {
                    $staff_id = $employe->id;
                } else {
                    return response()->json(['error' => 'Invalid employee code'], 404);
                }
            } else {
                $token = $request->bearerToken();
                $staff = null;

                if ($token) {
                    $accessToken = PersonalAccessToken::findToken($token);
                    if ($accessToken) {
                        $staff = $accessToken->tokenable;
                    }
                }
                if ($staff) {
                    $staff_id = $staff->emp_id;
                } else {
                    return response()->json(['error' => 'User is not authenticated or employee code is missing'], 400);
                }
            }


            $staff = Employee::find($staff_id);
            
            if (!$staff) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $branch_id = $staff->branch_id;
            
            // ✅ Normalize service IDs into a proper array
            $rawService = $request->input('service_id');
            if (is_array($rawService)) {
                $service_ids = $rawService;
            } elseif (is_string($rawService)) {
                $decoded = json_decode($rawService, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $service_ids = $decoded;
                } elseif (strpos($rawService, ',') !== false) {
                    $service_ids = array_map('trim', explode(',', $rawService));
                } else {
                    $service_ids = [$rawService];
                }
            } else {
                $service_ids = [$rawService];
            }
            
            // Remove null/empty values and reindex
            $service_ids = array_values(array_filter($service_ids, fn($v) => $v !== null && $v !== ''));
            
            // ✅ Restrict “ጸጉር ቆራጭ” employees to one service only
            if (trim($staff->service_group) === 'ጸጉር ቆራጭ' && count($service_ids) > 1) {
                return response()->json([
                    'message' => 'ከአንድ በላይ አገልግሎት/Service/ መላክ አይቻልም ።',
                ], 409); // 409 Conflict
            }
            
            
            $transactions = [];
            $skippedServices = [];
            
            foreach ($service_ids as $service_id) {
                
                $service = Service::find($service_id);
                
                if (!$service) {
                    $skippedServices[] = [
                        'service_id' => $service_id,
                        'reason' => 'Service not found',
                    ];
                    continue; // Skip invalid service
                }
            
                // ✅ Check for similar transaction in the last 5 minutes
                $recentTransaction = Transaction::where('client_id', $validated['customer_id'])
                    ->where('service_id', $service_id)
                    ->where('employee_id', $staff_id)
                    ->where('branch_id', $branch_id)
                    ->whereDate('created_at', Carbon::today()) // ✅ same-day check
                    ->first();
            
                if ($recentTransaction) {
                    $skippedServices[] = [
                        'service_id' => $service_id,
                        'service_name' => $service->name ?? null,
                        'reason' => 'Duplicate within 5 minutes',
                        'last_transaction_time' => $recentTransaction->created_at->toDateTimeString(),
                    ];
                    continue; // ✅ Skip this service, do NOT insert again
                }
                
                $prevService = Transaction::whereDate('created_at', now())
                    ->where('client_id', $validated['customer_id'])
                    ->whereHas('service', function ($query) {
                        $query->where('type', 'ጸጉር ቆራጭ');
                    })
                    ->first();
                    
                // Create transaction
                $transaction = new Transaction();
                $transaction->client_id = $validated['customer_id'];
                $transaction->branch_id = $branch_id;
                $transaction->employee_id = $staff_id;
                $transaction->parent_emp_id = $prevService->id ?? NULL;
                $transaction->service_id = $service_id;
                $transaction->price = $service->price;
                $transaction->created_by = $user_id ?? $staff_id;
                $transaction->updated_by = NULL;
                $transaction->save();
                
                $transactions[] = $transaction;
            }
            
            // ✅ Response handling after processing all services
            if (count($transactions) === 0) {
                return response()->json([
                    'message' => 'ከአንድ ጊዜ በላይ በድጋሚ መላክ  አይቻልም ።',
                    'skipped_services' => $skippedServices,
                ], 409); // 409 Conflict is appropriate here
            }

            $admins = User::role('admin')->get();
            
            foreach ($admins as $admin) {
                $notification = new Notification();
                $notification->user_id = $admin->id;
                $notification->title = 'Service';
                $notification->message = 'New service request has been sent from ' . ($staff->first_name) . ', Code '. ($staff->code);
                $notification->save();
                $message = [
                'id' => $notification->id,
                'created_at' => $notification->created_at,
                'title' => 'Service',
                'message' => 'New service request has been sent from ' . ($staff->first_name) .  ', Code '. ($staff->code)
            ];
                event(new notificationEvent($message, $admin->emp_id));
            }
            if ($request->item_id) {
                $items = is_array($request->item_id) ? $request->item_id : [$request->item_id];
                $itemNames = Item::whereIn('id', $items)->pluck('name')->toArray();
                $itemList = implode(', ', $itemNames);
                $itemNotifi = User::role('Item Coordinator')->get();
                $receptionNotifi = User::role('Reception')->get();
                // dd($receptionNotifi);
                foreach ($itemNotifi as $item) {
                    $notification = new Notification();
                    $notification->user_id = $item->id;
                    $notification->title = 'Items';
                    $notification->employee_id = $staff_id;
                    $notification->is_completed = 'no';
                    $notification->message = 'New service request has been sent from ' . ($staff->first_name) . ' and the following items are required' . $itemList;
                    $notification->save();
                     $message = [
                    'id' => $notification->id,
                    'is_completed' => $notification->is_completed,
                    'created_at' => $notification->created_at,
                    'title' => 'Items',
                    'message' => 'New service request has been sent from ' . ($staff->first_name) . ' and the following items are required' . $itemList
                ];
                // dd($message);
                    event(new notificationEvent($message, $item->emp_id));
                }
                
                foreach ($receptionNotifi as $receptionitem) {
                    $notification = new Notification();
                    $notification->user_id = $receptionitem->id;
                    $notification->title = 'Items';
                    $notification->employee_id = $staff_id;
                    $notification->is_completed = 'no';
                    $notification->message = 'New service request has been sent from ' . ($staff->first_name) . ' and the following items are required' . $itemList;
                    $notification->save();
                     $message = [ 
                    'id' => $notification->id,
                    'is_completed' => $notification->is_completed,
                    'created_at' => $notification->created_at,
                    'title' => 'Items',
                    'message' => 'New service request has been sent from ' . ($staff->first_name) . ' and the following items are required ' . $itemList
                ];
                    event(new notificationEvent($message, $receptionitem->emp_id));
                }
            }
            
            $totalCreated = count($transactions);
            $totalSkipped = count($skippedServices);
            
            return response()->json([
                'message' => 'Service request sent successfully. Created: {$totalCreated}, Skipped: {$totalSkipped}.',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in a structured way
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
