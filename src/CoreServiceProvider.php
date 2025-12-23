<?php

namespace HopekellDev\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use HopekellDev\Core\Middleware\EnsureInstalled;

class CoreServiceProvider extends ServiceProvider
{
    public function boot(Router $router): void
    {
        // Load package routes
       $this->loadRoutesFrom(__DIR__ . '/Installer/Routes/install.php');

        // Load package views
        $this->loadViewsFrom(
            __DIR__ . '/Installer/resources/views',
            'hopekell-installer'
        );

        // Alias middleware (optional, but fine)
        $router->aliasMiddleware(
            'hopekell.installed',
            EnsureInstalled::class
        );

        // 🔴 IMPORTANT: Automatically APPLY middleware
        $router->pushMiddlewareToGroup(
            'web',
            EnsureInstalled::class
        );
    }

    public function register(): void
    {
        //
    }
}
