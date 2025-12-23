<?php

namespace HopekellDev\Core\Modules;

class ModuleManager
{
    protected static array $modules = [];

    public static function enable(string $module): void
    {
        static::$modules[$module] = true;
    }

    public static function enabled(string $module): bool
    {
        return static::$modules[$module] ?? false;
    }
}
