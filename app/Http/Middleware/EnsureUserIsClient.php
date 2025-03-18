<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next): Response
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        // Redirect non-authenticated users to the login page
        return redirect('/login');
    }

    // If the user is authenticated but is a staff member (not a customer)
    if (Auth::check() && Auth::user()->is_staff !== "0") {
        // Redirect back with a custom error message
        return redirect()->back()->with('error', 'Please login as a customer to access this page.');
    }

    // Allow the request to proceed for customers
    return $next($request);
}
}
