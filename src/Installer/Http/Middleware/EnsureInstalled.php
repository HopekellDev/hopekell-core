<?php

namespace HopekellDev\Core\Installer\Http\Middleware;

use Closure;

class EnsureInstalled
{
    public function handle($request, Closure $next)
    {
        $license = base_path(
            'vendor/hopekell-dev/core/storage/HOPEKELLDEV.LIV'
        );

        if (! file_exists($license)) {
            return redirect()->route('hopekell.install');
        }

        return $next($request);
    }
}
