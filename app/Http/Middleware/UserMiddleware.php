<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya user biasa (bukan admin) yang boleh lanjut
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
