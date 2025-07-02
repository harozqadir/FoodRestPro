<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guard = $guards[0] ?? null;
    
        if (Auth::guard($guard)->check()) {
            // Redirect to dashboard, NOT /login
            return redirect('/admin/home'); // or your custom dashboard
        }
    
        return $next($request);
    }
}