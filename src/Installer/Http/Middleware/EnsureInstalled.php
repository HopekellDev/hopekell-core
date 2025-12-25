<?php

namespace HopekellDev\Core\Installer\Http\Middleware;

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

        // Correct license file path (vendor directory)
        $licensePath = base_path(
            'vendor/hopekell-dev/core/storage/HOPEKELLDEV.LIV'
        );

        // Not installed → redirect to installer
        if (! file_exists($licensePath)) {
            return redirect()->route('hopekell.install');
        }

        return $next($request);
    }
}
