<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $end = date('Y-m');
        $start = date('Y-m', strtotime('-2 months'));
        $services = Service::all();
        $customers = Client::all();
        $employees = Client::all();
        $services = Service::all();
        $transactions = Transaction::all();
        return view('Pages.report.index', compact('start','end','services','customers','employees', 'transactions'));
    }
    public function service(Request $request)
    {        
        $end = date('Y-m');
        $start = date('Y-m', strtotime('-2 months'));
        $services = Service::all();
        $transactions = Transaction::all();

        // $clients = Order::whereBetween('arrival_date', [$startDate, $endDate])->pluck('client_id');
        // $clients = Order::pluck('client_id');
        // $clientCounts = $clients->countBy();

        // Get the top 10 clients based on order count
        // $topClients = $clientCounts->sortDesc()->take(10);

        // Fetch client names and format data for both table & chart
        // $clientData = Client::whereIn('id', $topClients->keys())->get()->map(function ($client) use ($topClients) {
        //     return [
        //         'name' => $client->name,
        //         'value' => $topClients[$client->id], // For chart
        //         'orderCount' => $topClients[$client->id] // For table
        //     ];
        // });

        // Convert the collection to an array for JSON encoding
        // $clientDataArray = $clientData->toArray();

        return view('Pages.report.service', compact('start','end','services', 'transactions'));
    }
    public function service_show(Request $request)
    {
        
        $end = $request->end;
        $start = $request->start;
        $service = $request->service;
        $services = Service::all();
        if ($service === 'all') {
            $transactions = Transaction::all();
        } else {
            $transactions = Transaction::where('service_id', $service);
        }
        return view('Pages.report.service', compact('start','end','services', 'service', 'transactions'));
    }
    public function employee(Request $request)
    {
        $employees = Employee::all();
        $transaction = Transaction::all();
        return view('Pages.report.employee', compact('employees', 'transaction'));
    }
    public function employee_show(Request $request)
    {
        $employee = $request->employee;
        if ($employee === 'all') {
            $transaction = Transaction::all();
        } else {
            $transaction = Transaction::where('employee_id', $employee);
        }
        $employees = Employee::all();
        return view('Pages.report.employee', compact('employees', 'employee', 'transaction'));
    }
    public function customer(Request $request)
    {
        $customers = Client::all();
        $transaction = Transaction::all();
        return view('Pages.report.customer', compact('customers', 'transaction'));
    }
    public function customer_show(Request $request)
    {
        $customer = $request->customer;
        $customers = Client::all();
        if ($customer === 'all') {
            $transaction = Transaction::all();
        } else {
            $transaction = Transaction::where('customer_id', $customer);
        }
        return view('Pages.report.customer', compact('customers', 'customer', 'transaction'));
    }
    public function customer_type(Request $request)
    {
        $category = $request->category;
        $customers = Client::where('category', $category)->get();
        $transaction = Transaction::all();
        return view('Pages.report.customer', compact('customers', 'transactions'));
    }

    public function customer_type_show(Request $request)
    {
        $category = $request->category;
        if ($category === 'all') {
            $customers = Client::all();
        } else {
            $customers = Client::where('category', $category)->get();
        }
        $transactions = Transaction::where('client_id', $customers)->get();

        return view('Pages.report.customer', compact('customers', 'customer', 'transactions'));
    }
}
