<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // info('AdminMiddleware: Checking if user is admin');
        // info(json_encode(Auth::user()));
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        Auth::logout();
        return to_route('login');
    }
}
