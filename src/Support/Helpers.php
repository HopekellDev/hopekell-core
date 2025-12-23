<?php

namespace HopekellDev\Core\Support;

class Helpers
{
    public static function appName(): string
    {
        return config('app.name');
    }
}
