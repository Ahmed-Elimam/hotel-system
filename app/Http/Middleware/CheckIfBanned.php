<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->banned_at) {
            auth()->logout(); // Logout the user
            return to_route('receptionists.index')->with('error', 'Your account is banned.');
        }

        return $next($request);
    }
}
