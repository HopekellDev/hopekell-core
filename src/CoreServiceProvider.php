<?php

namespace HopekellDev\Core;

use Illuminate\Support\ServiceProvider;
use HopekellDev\Core\Installer\Http\Middleware\EnsureInstalled;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Installer/Routes/install.php');
        $this->loadViewsFrom(__DIR__.'/Installer/resources/views', 'hopekell-installer');

        app('router')->aliasMiddleware(
            'hopekell.installed',
            EnsureInstalled::class
        );
    }

    public function register()
    {
        //
    }
}
