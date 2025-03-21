<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all services with category details
        $services = Service::with('categories')->get();
        // $services = Service::with('category')
        // ->when($request->category, fn($query) => $query->where('category', $request->category))
        // ->get();
        return response()->json([
            'message' => 'Services retrieved successfully',
            'data' => $services
        ]);
    }
}
