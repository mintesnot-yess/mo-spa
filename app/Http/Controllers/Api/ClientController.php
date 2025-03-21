<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function activeCustomers()
    {
        // Fetch active clients (status = 1)
        $clients = Client::where('status', 1)->get();

        return response()->json([
            'message' => 'Active customers retrieved successfully',
            'data' => $clients
        ]);
    }
}
