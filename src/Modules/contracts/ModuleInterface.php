<?php

namespace HopekellDev\Core\Modules\Contracts;

interface ModuleInterface
{
    public function register(): void;
    public function boot(): void;
}
