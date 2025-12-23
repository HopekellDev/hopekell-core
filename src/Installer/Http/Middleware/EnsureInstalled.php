<?php

namespace HopekellDev\Core\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureInstalled
{
    public function handle(Request $request, Closure $next)
    {
        // Allow installer routes
        if ($request->is('install*')) {
            return $next($request);
        }

        $license = storage_path('hopekell/HOPEKELLDEV.LIV');

        if (! file_exists($license)) {
            return redirect()->route('hopekell.install');
        }

        return $next($request);
    }
}
