<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response {
		//Check if user logged in
		if (!Auth::check()) {
			return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
		}

		//Check if user is admin
		if (Auth::user()->role !== 'admin') {
			return redirect()->route('customerDashboard')->with('error', 'You do not have permission to access this page.');
		}

		return $next($request);
	}
}
