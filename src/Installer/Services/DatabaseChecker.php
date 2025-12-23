<?php

namespace HopekellDev\Core\Installer\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseChecker
{
    public static function check(array $data): void
    {
        Config::set('database.connections.hopekell_install', [
            'driver'   => 'mysql',
            'host'     => $data['db_host'],
            'database' => $data['db_name'],
            'username' => $data['db_user'],
            'password' => $data['db_pass'],
        ]);

        DB::connection('hopekell_install')->getPdo();
    }
}
