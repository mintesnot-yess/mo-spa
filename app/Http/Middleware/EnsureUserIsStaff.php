<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is not authenticated
        if (!Auth::check()) {
            // Redirect non-authenticated users to the login page
            return redirect('/admin/login')->with('error', 'Please login as a staff member to access this page.');
        }    
        // Allow the request to proceed for staff members
        return $next($request);
    }
}
