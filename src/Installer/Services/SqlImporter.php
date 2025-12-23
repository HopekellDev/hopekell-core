<?php

namespace HopekellDev\Core\Installer\Services;

use Illuminate\Support\Facades\DB;

class SqlImporter
{
    public static function import(string $url): void
    {
        $sql = file_get_contents($url);

        DB::unprepared($sql);
    }
}
