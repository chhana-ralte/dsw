<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
            return redirect('/')->with('error', 'Unauthorized access.'); // Redirect to home with error message
            // Or return an error response
            // return response('Unauthorized', 403);
        }
        return $next($request);
    }
}
