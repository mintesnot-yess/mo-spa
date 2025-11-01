<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\notificationEvent;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);
        // Find user by phone
        $user = User::where('phone', $request->phone)->first();
        
        // Check if user exists and password is correct
        if (!$user) {
            throw ValidationException::withMessages([
                'message' => ['Invalid phone or password.'],
            ]);
        }
// dd($request->all(),$user);
        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['Invalid phone or password.'],
            ]);
        }
        if($user->status == 0){
            throw ValidationException::withMessages([
               'message' => ['Account is deactivated.'],
            ]);            
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $roles = $user->getRoleNames();
        $role = count($roles) === 1 ? $roles[0] : $roles;
        $employee = Employee::find($user->emp_id);
        //    return new UserResource($user);
        $responseData = [
            'message' => 'Login successful',
            'data' => [
                'id' => $user->id,
                'emp_id' => $user->emp_id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'role' => $role,
                'employee_code' => $employee->code,
                'service_group' => $employee->service_group,
            ],
                'token' => $token,
        ];

        return response()->json($responseData);
    }
    public function notification(Request $request)
    {
        $user = auth()->user();
        $type = $request->query('type') ?? NULL;
        $completed = $request->query('completed') ?? NULL;
        $notification = Notification::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        if($type){
        $notification = Notification::where('user_id', $user->id)->where('is_read', false)->orderBy('created_at', 'desc')->get();
        }
        if($completed){
        $notification = Notification::where('user_id', $user->id)->where('is_completed', 'no')->orderBy('created_at', 'desc')->get();
        }
        //    return new UserResource($user);
        $responseData = [
            'message' => 'Notifiction retrieved successful',
            'data' => $notification
        ];

        return response()->json($responseData);
    }
    public function profile(){
        $user = auth()->user();
        $roles = $user->getRoleNames();
        $role = count($roles) === 1 ? $roles[0] : $roles;
        $employee = Employee::find($user->emp_id);
        //    return new UserResource($user);
        $responseData = [
            'message' => 'Profile retrieved successful',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'emp_id' => $user->emp_id,
                'phone' => $user->phone,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'role' => $role,
                'employee_code' => $employee->code,
                'service_group' => $employee->service_group,
            ],
        ];

        return response()->json($responseData);
    }

    public function logout()
    {
        // Get authenticated user
        $user = auth()->user();

        // Delete all tokens for the user
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
    public function profile_update(Request $request)
    {
        try {
            // Properly validate the request
            $validated = $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'email' => 'nullable',
                'image' => 'nullable',
            ]);
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
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
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->image = $filesImage;
            $user->save();
            return response()->json([
                'message' => 'Profile updated successfully',
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
   public function markAllRead()
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return response()->json(['message' => 'All notifications marked as read']);
    }
    public function markcomplated(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }
        $notification = Notification::find($request->notification_id);
        $notification->is_completed = "yes";
        $notification->save();
        $message = [
            'id' => $notification->id,
            'created_at' => $notification->created_at,
            'title' => 'Items',
            'message' => 'Your Item request is completed',
        ];
        event(new notificationEvent($message, $notification->employee_id));
        $user = User::where('emp_id',$notification->employee_id)->first();        
        $newnotification = new Notification();
        $newnotification->user_id = $user->id;
        $newnotification->title = 'Items';
        $newnotification->message = 'Your Item request is completed.';
        $newnotification->save();
        return response()->json(['message' => 'Item Request Completed']);
    }
}
