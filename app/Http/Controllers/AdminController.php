<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Order;
use App\Models\PaymentCollection;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Vehicle;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = User::count();
        $employee = Employee::count();
        $service = Service::count();
        $customer = Client::count();
        $totalCategories = Category::count();
        // $categories = Category::whereNotNUll('parent_category_id')->count();
        // $subCategories = Category::whereNUll('parent_category_id')->count();
        $totalTransaction = Transaction::count();
        $pendingTransaction = Transaction::where('status', 1)->count();
        $complatedTransaction = Transaction::where('status', 0)->count();

        $subscriberData = [323, 245, 265, 4587, 254, 452, 852, 96, 452, 852, 96, 323];
        $contactData = [123, 225, 465, 587, 254, 552, 352, 396, 452, 852, 932, 43];

        return view('Pages.dashboard', compact('subscriberData', 'contactData', 'totalCategories', 'service', 'customer', 'user', 'employee', 'totalTransaction', 'complatedTransaction', 'pendingTransaction'));
    }
    public function markAllRead()
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function login()
    {
        return view('auth.login');
    }
    public function store(LoginRequest $request)
    {
        // Attempt to authenticate the user
        $request->authenticate();
        // Check if the authenticated user is not staff
        // if (Auth::user()->is_staff === 0) {
        //     // Log out the user if they are not staff
        //     Auth::logout();

        //     // Redirect back with an error message
        //     return redirect()->back()->withErrors([
        //         'error' => 'Credentials do not match our database',
        //     ]);
        // }

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Redirect to the intended dashboard
        return redirect()->intended(route('dashboard'));
    }
}
