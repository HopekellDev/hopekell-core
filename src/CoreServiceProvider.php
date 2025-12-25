<?php

namespace HopekellDev\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use HopekellDev\Core\Installer\Http\Middleware\EnsureInstalled;

class CoreServiceProvider extends ServiceProvider
{
    public function boot(Router $router): void
    {
        // 🔹 Load package routes
        $this->loadRoutesFrom(__DIR__ . '/Installer/Routes/install.php');

        // 🔹 Load package views
        $this->loadViewsFrom(__DIR__ . '/Installer/resources/views', 'hopekell-installer');

        // 🔹 Alias middleware (optional)
        $router->aliasMiddleware('hopekell.installed', EnsureInstalled::class);

        // 🔹 Apply middleware globally to all HTTP requests
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(EnsureInstalled::class);
    }

    public function register(): void
    {
        //
    }
}
