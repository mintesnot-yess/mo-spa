<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); 
         $transactions = Transaction::where(function ($query) use ($user) {
            $query->where('employee_id', $user->emp_id)
                  ->orWhere('parent_emp_id', $user->emp_id);
        })
        ->where('created_at', '>=', Carbon::now()->subDays(11)) // ✅ Filter last 11 days
        ->orderBy('status', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();
       
        return response()->json([
            'message' => 'Services retrieved successfully',
            'data' => ReportResource::collection($transactions)
        ]);
    }
}
