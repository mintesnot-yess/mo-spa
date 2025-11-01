<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
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
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:show_dashboard', ['only' => ['index']]);
    }
     public function test(){
        return view('Pages.test');
    }
    public function index(Request $request)
    {
        $user = User::count();
        $employee = Employee::count();
        $service = Service::count();
        $customer = Client::count();
        $totalCategories = Category::count();
        $year = date('Y');
        // $categories = Category::whereNotNUll('parent_category_id')->count();
        // $subCategories = Category::whereNUll('parent_category_id')->count();
        $totalTransaction = Transaction::count();
        $pendingTransaction = Transaction::where('status', 1)->count();
        $complatedTransaction = Transaction::where('status', 0)->count();

        
        $year = now()->year;

        $pending = Transaction::whereYear('created_at', $year)
            ->selectRaw('branch_id, MONTH(created_at) as month, SUM(price) as total_price')
            ->groupBy('branch_id', 'month')
            ->get();

        // Structure data per branch
        $pendingData = [];

        foreach ($pending as $record) {
            $branch = $record->branch->name ?? 'unknown';
            $month = (int) $record->month;
            $price = $record->total_price;

            // Fill data in correct month position (1-12)
            if (!isset($pendingData[$branch])) {
                $pendingData[$branch] = array_fill(1, 12, 0); // months 1 to 12
            }

            $pendingData[$branch][$month] = $price;
        }

        // Final format for chart (array of series)
        $chartSeries = [];

        foreach ($pendingData as $branch => $monthlyData) {
            $chartSeries[] = [
                'name' => "$branch",
                'type' => 'line',
                'smooth' => true,
                'symbol' => 'circle',
                'symbolSize' => 8,
                'data' => array_values($monthlyData),
            ];
        }
        $complated = Transaction::whereYear('created_at', $year)
            ->selectRaw('branch_id, MONTH(created_at) as month, COUNT(*) as total_count')
            ->groupBy('branch_id', 'month')
            ->with('branch') // eager load branch relationship
            ->get();

        // Structure data per branch
        $complatedData = [];

        foreach ($complated as $record) {
            $branch = $record->branch->name ?? 'Unknown';
            $month = (int) $record->month;
            $count = $record->total_count;

            // Initialize array if not set
            if (!isset($complatedData[$branch])) {
                $complatedData[$branch] = array_fill(1, 12, 0);
            }

            $complatedData[$branch][$month] = $count;
        }

        // Final format for ECharts
        $transactionSeries = [];

        foreach ($complatedData as $branch => $monthlyCounts) {
            $transactionSeries[] = [
                'name' => $branch,
                'type' => 'line',
                'smooth' => true,
                'symbol' => 'circle',
                'symbolSize' => 8,
                'data' => array_values($monthlyCounts), // values from Jan to Dec
            ];
        }

        // dd($transactionSeries,$chartSeries);


        return view('Pages.dashboard', compact('chartSeries','transactionSeries', 'totalCategories', 'service', 'customer', 'user', 'employee', 'totalTransaction', 'complatedTransaction', 'pendingTransaction'));
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
    protected function getRedirectRouteByPermission($user)
    {
        // Priority-based route list matching sidebar order
        $routes = [
            'show_dashboard'      => route('dashboard'),
            'show_pending_transaction'        => route('pendingTransaction'),
            'show_completed_transaction'        => route('complatedTransaction'),
            'show_item'        => route('item'),
            'show_category'    => route('category'),
            'show_branch'      => route('branch'),
            'show_service'     => route('service'),
            'show_employee'    => route('employee'),
            'show_customer'    => route('client'),
            'show_report'      => route('report'),
            'show_staff_user'  => route('staff.index'),
            'show_role'        => route('rolepermission'),
        ];
    
        foreach ($routes as $permission => $route) {
            if ($user->can($permission)) {
                return $route;
            }
        }
    
        return null;
    }

    // public function store(LoginRequest $request)
    // {
    //     $request->authenticate();
    //     $user = Auth::user();

    //     if (!$user) {
    //         throw ValidationException::withMessages([
    //             'email' => ['Authentication failed.'],
    //         ]);
    //     }
    
    //     $user->refresh();
    //     $request->authenticate();
    //     if ($user->status == 0) {
    //         Auth::logout();
    
    //         // optional: invalidate session and regenerate token
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();
    
    //         throw ValidationException::withMessages([
    //             'email' => ['Account is deactivated.'],
    //         ]);
    //     }
        
    //     // Regenerate session to prevent session fixation
    //     $request->session()->regenerate();

    //     // Redirect to the intended dashboard
    //     // return redirect()->intended(route('dashboard'));
    //     // Redirect based on first available permission
        
    //     $redirectRoute = $this->getRedirectRouteByPermission($user);
    
    //     return redirect()->intended($redirectRoute ?? route('setting.index'));
    // }
    
    public function store(LoginRequest $request)
    {
        // Authenticate user
        $request->authenticate();
    
        $user = Auth::user();
    
        // Check if authentication failed (just in case)
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Authentication failed.'],
            ]);
        }
    
        // Check if the user account is deactivated
        if ($user->status == 0) {
            Auth::logout();
    
            // Invalidate session & regenerate CSRF token for security
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            throw ValidationException::withMessages([
                'email' => ['Account is deactivated.'],
            ]);
        }
    
        // Regenerate session to prevent session fixation
        $request->session()->regenerate();
    
        // Determine redirect route based on permissions
        $redirectRoute = $this->getRedirectRouteByPermission($user);
    
        // Redirect to intended page or fallback route
        return redirect()->intended($redirectRoute ?? route('setting.index'));
    }

}
