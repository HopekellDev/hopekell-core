<?php

namespace HopekellDev\Core\Installer\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SqlImporter
{
    public static function import(string $url): array
    {
        try {
            $sql = @file_get_contents($url);

            if ($sql === false) {
                return [
                    'success' => false,
                    'message' => 'Unable to download SQL file'
                ];
            }

            DB::unprepared($sql);

            return [
                'success' => true,
                'message' => 'Database imported successfully'
            ];

        } catch (\Throwable $e) {

            Log::error('SQL Import Failed', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'SQL execution error: ' . $e->getMessage()
            ];
        }
    }
}
