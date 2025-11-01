<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
   public function index(Request $request)
    {
        // ✅ Determine start and end dates
        if ($request->filled('start') && $request->filled('end')) {
            // Use selected date range (even if start == end)
            $start = Carbon::parse($request->input('start'))->startOfDay();
            $end   = Carbon::parse($request->input('end'))->endOfDay();
        } else {
            // Default: from the 1st day of this month to today
            $start = Carbon::now()->startOfDay();
            $end   = Carbon::now()->endOfDay();
        }
    
        // ✅ Query transactions within the date range
        $transactions = Transaction::whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->get();
    
        // ✅ Fetch data for filters
        $services   = Service::all();
        $branchs    = Branch::all();
        $customers  = Client::all();
        $employees  = Employee::all();
    
        // ✅ Pass formatted dates for <input type="date">
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');
    
        return view('Pages.report.index', compact(
            'start', 'end', 'services', 'branchs', 'customers', 'employees', 'transactions'
        ));
    }

    public function show(Request $request)
    {
        // $end = $request->input('end', date('Y-m-d'));
        // $start = $request->input('start', date('Y-m-d'));
        
        $start = Carbon::parse($request->input('start'))->startOfDay();
        $end   = Carbon::parse($request->input('end'))->endOfDay();

        $query = Transaction::query();

        // Apply filters if provided
        if ($request->has('start') && $request->has('end')) {
            $query->whereBetween('created_at', [$start, $end ]);
        }

        if ($request->filled('customer') && $request->customer !== 'all') {
            $query->where('client_id', $request->customer);
        }

        if ($request->filled('service') && $request->service !== 'all') {
            $query->where('service_id', $request->service);
        }
        if ($request->filled('branch') && $request->branch !== 'all') {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('employee') && $request->employee !== 'all') {
            $query->where('employee_id', $request->employee);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_type') && $request->customer_type !== 'all') {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('category', $request->customer_type);
            });
        }

        $transactions = $query->get();

        // Fetch other data needed for the filters
        $services = Service::all();
        $branchs = Branch::all();
        $customers = Client::all();
        $employees = Employee::all(); // Ensure `Employee::all()` instead of `Client::all()`
        
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');

        return view('Pages.report.index', compact('start', 'end', 'services', 'branchs', 'customers', 'employees', 'transactions'));
    }
    
    public function service(Request $request)
    {
        
        // ✅ Determine start and end dates
        if ($request->filled('start') && $request->filled('end')) {
            $end = Carbon::parse($request->input('end'))->endOfDay();
            $start = Carbon::parse($request->input('start'))->startOfDay();
            $chartend = Carbon::parse($request->input('end'))->endOfDay();
            $chartstart = Carbon::parse($request->input('start'))->startOfDay();
        } else {
            $end = Carbon::now()->endOfDay();
            $start = Carbon::now()->startOfDay();
            $chartend = Carbon::now()->endOfDay();
            $chartstart = Carbon::now()->startOfDay();
        }
        
        $branchs = Branch::all();

        $transactions = Transaction::with(['service.categories']) // eager load
            ->whereBetween('created_at', [$start , $end])
            ->when($request->filled('service_id') && $request->service_id !== 'all', function ($query) use ($request) {
                $query->where('service_id', $request->service_id);
            })
            ->get()
            ->groupBy('service_id');


        $serviceSummaries = $transactions->map(function ($groupedTransactions) {
            $first = $groupedTransactions->first(); // reference transaction
            return [
                'service_title' => $first->service->title ?? 'Unknown',
                'category_title' => $first->service->type ?? 'Unknown',
                'total_customers' => $groupedTransactions->pluck('client_id')->unique()->count(),
                'transaction_count' => $groupedTransactions->count(),
                'total_price' => $groupedTransactions->sum('price'),
            ];
        })->values(); // reset keys


        $startDate = $start;
        $endDate = $end;

        // 1. Count of transactions per service_id
        $serviceIds = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->pluck('service_id');

        $topServiceCounts = $serviceIds->countBy();
        $topServiceIdsForCount = $topServiceCounts->keys();

        $servicesForCount = Service::whereIn('id', $topServiceIdsForCount)->get()->keyBy('id');

        $clientData = $topServiceIdsForCount->map(function ($serviceId) use ($topServiceCounts, $servicesForCount) {
            return [
                'name' => $servicesForCount[$serviceId]->title ?? 'Unknown',
                'value' => $topServiceCounts[$serviceId],
            ];
        });

        $clientDataArray = $clientData->toArray();

        // 2. Sum of transaction price per service_id
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->get(['service_id', 'price']);

        $topServiceSums = $transactions->groupBy('service_id')->map(function ($group) {
            return $group->sum('price');
        });

        $topServiceIdsForSum = $topServiceSums->keys();

        $servicesForSum = Service::whereIn('id', $topServiceIdsForSum)->get()->keyBy('id');

        $serviceRevenueData = $topServiceIdsForSum->map(function ($serviceId) use ($topServiceSums, $servicesForSum) {
            return [
                'name' => $servicesForSum[$serviceId]->title ?? 'Unknown',
                'value' => $topServiceSums[$serviceId],
            ];
        });

        $serviceRevenueArray = $serviceRevenueData->toArray();
        
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');

        return view('Pages.report.service', compact('start', 'end', 'chartstart', 'chartend', 'clientDataArray', 'serviceRevenueArray', 'branchs', 'transactions','serviceSummaries'));
    }
    
    public function service_show(Request $request)
    {
        // Retrieve request parameters
        $start = Carbon::parse($request->input('start'))->startOfDay();
        $end   = Carbon::parse($request->input('end'))->endOfDay();
        // $service = $request->input('service', 'all');

       // 1. Build the base query
        $query = Transaction::with(['service.categories']); // eager load

        // if ($service !== 'all') {
        //     $query->where('service_id', $service);
        // }

        if ($request->filled('branch') && $request->branch !== 'all') {
            $query->where('branch_id', $request->branch);
        }

        $query->whereBetween('created_at', [
            $start,
            $end
        ]);

        // 2. Execute and group by service_id
        $transactions = $query->get()->groupBy('service_id');

        // 3. Summarize each group
        $serviceSummaries = $transactions->map(function ($groupedTransactions) {
            $first = $groupedTransactions->first();
            return [
                'service_title' => $first->service->title ?? 'Unknown',
                'category_title' => $first->service->categories->title ?? 'Unknown',
                'total_customers' => $groupedTransactions->pluck('client_id')->unique()->count(),
                'transaction_count' => $groupedTransactions->count(),
                'total_price' => $groupedTransactions->sum('price'),
            ];
        })->values(); // optional: reset keys


        // Get the filtered transactions
        $transactions = $query->get();


        // Fetch all services for the filter dropdown
        // $services = Service::all();

        $branchs = Branch::all();


        // Retrieve request parameters
        $chartend = $end;
        $chartstart = $start;
        $startDate = $start;
        $endDate = $end;


        // Base query with date range
        $query = Transaction::whereBetween('created_at', [$startDate, $endDate]);
        // dd($chartbranch = $request->chartbranch,$request->all());
        // Optional branch filter
        if ($request->filled('chartbranch') && $request->chartbranch !== 'all') {
            $query->where('branch_id', $request->chartbranch);
        }

        // Clone the query for count
        $serviceIds = (clone $query)->pluck('service_id');
        $topServiceCounts = $serviceIds->countBy();
        $topServiceIdsForCount = $topServiceCounts->keys();

        $servicesForCount = Service::whereIn('id', $topServiceIdsForCount)->get()->keyBy('id');

        $clientData = $topServiceIdsForCount->map(function ($serviceId) use ($topServiceCounts, $servicesForCount) {
            return [
                'name' => $servicesForCount[$serviceId]->title ?? 'Unknown',
                'value' => $topServiceCounts[$serviceId],
            ];
        });

        $clientDataArray = $clientData->toArray();

        // Clone the query for sum
        $transactions = (clone $query)->get(['service_id', 'price']);

        $topServiceSums = $transactions->groupBy('service_id')->map(function ($group) {
            return $group->sum('price');
        });

        $topServiceIdsForSum = $topServiceSums->keys();

        $servicesForSum = Service::whereIn('id', $topServiceIdsForSum)->get()->keyBy('id');

        $serviceRevenueData = $topServiceIdsForSum->map(function ($serviceId) use ($topServiceSums, $servicesForSum) {
            return [
                'name' => $servicesForSum[$serviceId]->title ?? 'Unknown',
                'value' => $topServiceSums[$serviceId],
            ];
        });

        $serviceRevenueArray = $serviceRevenueData->toArray();


        return view('Pages.report.service', compact('start', 'end','chartstart', 'chartend',  'clientDataArray', 'serviceRevenueArray', 'branchs', 'transactions','serviceSummaries'));
    }

   public function employee(Request $request)
    {
      
        // ✅ Determine start and end dates
        if ($request->filled('start') && $request->filled('end')) {
            $end = Carbon::parse($request->input('end'))->endOfDay();
            $start = Carbon::parse($request->input('start'))->startOfDay();
            $chartend = Carbon::parse($request->input('end'))->endOfDay();
            $chartstart = Carbon::parse($request->input('start'))->startOfDay();
        } else {
            $end = Carbon::now()->endOfDay();
            $start = Carbon::now()->startOfDay();
            $chartend = Carbon::now()->endOfDay();
            $chartstart = Carbon::now()->startOfDay();
        }
        
        $employees = Employee::all();
        $branchs = Branch::all();
        $employee = 'all';
        
        $transactions = Transaction::with(['service.categories', 'employee'])
            ->whereBetween('created_at', [$start, $end])
            ->when($request->filled('employee_id') && $request->employee_id !== 'all', function ($query) use ($request) {
                $query->where('employee_id', $request->employee_id);
            })
            ->get()
            ->groupBy('employee_id');
            
        $employeeSummaries = $transactions->map(function ($groupedTransactions) {
            $first = $groupedTransactions->first();
            return [
                'employee_firstname' => $first->employee->first_name ?? 'Unknown',
                'employee_lastname' => $first->employee->last_name ?? 'Unknown',
                'transaction_count' => $groupedTransactions->count(),
                'total_income' => $groupedTransactions->sum('price'),
                'total_customers' => $groupedTransactions->pluck('client_id')->unique()->count(),
            ];
        })->sortByDesc('total_income')
            ->values();
            
            
        $startDate = $chartstart;
        $endDate = $chartend;

        // Get the transactions within the date range
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->get(['employee_id', 'price']);

        // Group the transactions by employee_id and sum the prices for each employee
        $topEmployeeSums = $transactions->groupBy('employee_id')->map(function ($group) {
            return $group->sum('price');
        });

        // Sort employees by total income in descending order and take the top 10
        $topEmployeeSums = $topEmployeeSums->sortDesc()->take(10);

        // Prepare data for the employee chart
        $chartData = $topEmployeeSums->map(function ($totalPrice, $employeeId) {
            $employee = Employee::find($employeeId);
            return [
                'name' => $employee ? $employee->first_name : 'Unknown Employee',
                'value' => $totalPrice
            ];
        })->values();

        // Now, calculate the number of transactions per employee (client data)
        $topEmployeeCounts = $transactions->groupBy('employee_id')->map(function ($group) {
            return $group->count();
        });

        // Get the employee ids for counting
        $topEmployeeIdsForCount = $topEmployeeCounts->keys();

        // Fetch employees related to the transaction data (just like we did for sums)
        $employeesForCount = Employee::whereIn('id', $topEmployeeIdsForCount)->get()->keyBy('id');

        // Prepare client data (employee count by employee_id)
        $clientData = $topEmployeeIdsForCount->map(function ($employeeId) use ($topEmployeeCounts, $employeesForCount) {
            return [
                'name' => $employeesForCount[$employeeId]->first_name ?? 'Unknown Employee',
                'value' => $topEmployeeCounts[$employeeId],
            ];
        });

        // Convert to array
        $clientDataArray = $clientData->toArray();
        
        
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');
        $chartstart = $chartstart->format('Y-m-d');
        $chartend = $chartend->format('Y-m-d');
        

        return view('Pages.report.employee', compact('employees', 'employee', 'chartstart', 'chartend', 'start', 'end', 'branchs', 'transactions', 'employeeSummaries', 'chartData', 'clientDataArray'));
    }
    public function employee_show(Request $request)
    {
        
         // ✅ Determine start and end dates
        if ($request->filled('start') && $request->filled('end')) {
            $end = Carbon::parse($request->input('end'))->endOfDay();
            $start = Carbon::parse($request->input('start'))->startOfDay();
            $chartend = Carbon::parse($request->input('end'))->endOfDay();
            $chartstart = Carbon::parse($request->input('start'))->startOfDay();
        } else {
            $end = $chartend = Carbon::now()->endOfDay();
            $start = $chartstart = Carbon::now()->startOfDay();
        }
       
        $employee = $request->input('employee', 'all');
        $startDate = $chartstart;
        $endDate = $chartend;
        
        $branchs = Branch::all();

        // Start query
        $query = Transaction::query();

        // Filter transactions by employee if provided
        if ($request->filled('employee') && $request->employee !== 'all') {
            $query->where('employee_id', $request->employee);
        }

        // Filter transactions by branch if provided
        if ($request->filled('branch') && $request->branch !== 'all') {
            $query->where('branch_id', $request->branch);
        }

        // Filter transactions by date range
        $query->whereBetween('created_at', [
            $start,  // First day of the start month
            $end     // Last possible day of the end month
        ]);

        // Execute query and get the results
        $transactions = $query->get()->groupBy('employee_id');  // Group transactions by employee_id

        // Process and summarize the data for each employee
        $employeeSummaries = $transactions->map(function ($groupedTransactions) {
            $first = $groupedTransactions->first(); // Reference the first transaction for employee info

            return [
                'employee_firstname' => $first->employee->first_name ?? 'Unknown',  // Employee name (with fallback)
                'employee_lastname' => $first->employee->last_name ?? 'Unknown',  // Employee name (with fallback)
                'transaction_count' => $groupedTransactions->count(),  // Count of transactions
                'total_income' => $groupedTransactions->sum('price'),  // Total income (sum of price)
                'total_customers' => $groupedTransactions->pluck('client_id')->unique()->count(),  // Unique customer count
            ];
        })
            ->sortByDesc('total_income')  // Sort by total income in descending order
            ->values();  // Reset keys after sorting

        // Fetch all employees for the filter dropdown
        $employees = Employee::all();

        // Initialize the query to fetch transactions
        $query = Transaction::query();

        // Apply filters based on the request
        if ($request->filled('chartemployee') && $request->chartemployee !== 'all') {
            $query->where('employee_id', $request->chartemployee);
        }

        // Filter transactions by branch if provided
        if ($request->filled('chartbranch') && $request->chartbranch !== 'all') {
            $query->where('branch_id', $request->chartbranch);
        }

        // Filter transactions by the date range
        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Execute the query and get the relevant data
        $transactions = $query->get(['employee_id', 'price']);

        // Now group the transactions by employee_id and calculate the sum of price for each employee
        $topEmployeeSums = $transactions->groupBy('employee_id')->map(function ($group) {
            return $group->sum('price');
        });

        // Sort employees by total income in descending order and take the top 10
        $topEmployeeSums = $topEmployeeSums->sortDesc()->take(10);

        // Prepare data for the chart (top employees by income)
        $chartData = $topEmployeeSums->map(function ($totalPrice, $employeeId) {
            $employee = Employee::find($employeeId);
            return [
                'name' => $employee ? $employee->first_name : 'Unknown Employee',
                'value' => $totalPrice
            ];
        })->values();

        // Now calculate the number of transactions per employee (customer count)
        $topEmployeeCounts = $transactions->groupBy('employee_id')->map(function ($group) {
            return $group->count();
        });

        // Get the employee ids for counting
        $topEmployeeIdsForCount = $topEmployeeCounts->keys();

        // Fetch employees related to the transaction data (like we did for sums)
        $employeesForCount = Employee::whereIn('id', $topEmployeeIdsForCount)->get()->keyBy('id');

        // Prepare client data (employee count by employee_id)
        $clientData = $topEmployeeIdsForCount->map(function ($employeeId) use ($topEmployeeCounts, $employeesForCount) {
            return [
                'name' => $employeesForCount[$employeeId]->first_name ?? 'Unknown Employee',
                'value' => $topEmployeeCounts[$employeeId],
            ];
        });

        // Convert to array
        $clientDataArray = $clientData->toArray();
        
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');
        $chartstart = $chartstart->format('Y-m-d');
        $chartend = $chartend->format('Y-m-d');

        return view('Pages.report.employee', compact('employees', 'employee','clientDataArray','chartData', 'transactions', 'chartstart', 'chartend', 'employeeSummaries', 'branchs', 'start', 'end'));
    }

    public function customer(Request $request)
    {
        
        // ✅ Determine start and end dates
        if ($request->filled('start') && $request->filled('end')) {
            $end = Carbon::parse($request->input('end'))->endOfDay();
            $start = Carbon::parse($request->input('start'))->startOfDay();
        } else {
            $end = Carbon::now()->endOfDay();
            $start = Carbon::now()->startOfDay();
        }
        
        $customers = Client::all();
        $customer = 'all';
        // Query transactions with default or selected date range
        $transactions = Transaction::whereBetween('created_at', [
            $start,  // First day of the start month
            $end     // Last possible day of the end month
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');
        
        return view('Pages.report.customer', compact('customers','customer', 'transactions', 'start', 'end'));
    }
    public function customer_show(Request $request)
    {
        
        // ✅ Determine start and end dates
        if ($request->filled('start') && $request->filled('end')) {
            $end = Carbon::parse($request->input('end'))->endOfDay();
            $start = Carbon::parse($request->input('start'))->startOfDay();
        } else {
            $end = Carbon::now()->endOfDay();
            $start = Carbon::now()->startOfDay();
        }
        
        $customer = $request->input('customer', 'all');

        // Start query
        $query = Transaction::query();

        // Filter transactions by customer
        if ($customer !== 'all') {
            $query->where('client_id', $customer);
        }

        // Filter transactions by date range
        $query->whereBetween('created_at', [
            $start,  // First day of the start month
            $end     // Last possible day of the end month
        ]);
        
        $query->orderBy('created_at', 'desc');

        // Get the filtered transactions
        $transactions = $query->get();

        // Fetch all customers for the filter dropdown
        $customers = Client::all();
        
        $start = $start->format('Y-m-d');
        $end   = $end->format('Y-m-d');

        return view('Pages.report.customer', compact('customers', 'customer', 'transactions', 'start', 'end'));
    }

}
