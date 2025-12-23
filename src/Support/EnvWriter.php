<?php

namespace HopekellDev\Core\Support;

class EnvWriter
{
    public static function set(string $key, string $value): void
    {
        $env = app()->environmentFilePath();

        file_put_contents(
            $env,
            preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$value}",
                file_get_contents($env)
            )
        );
    }
}
