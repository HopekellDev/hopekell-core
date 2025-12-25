<?php

namespace HopekellDev\Core\Installer\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class DatabaseChecker
{
    public static function check(array $data): array
    {
        // Validate required fields first
        $required = ['db_host', 'db_name', 'db_user', 'db_pass'];
        foreach ($required as $key) {
            if (empty($data[$key] ?? null)) {
                return [
                    'success' => false,
                    'message' => "Missing required field: {$key}"
                ];
            }
        }

        try {
            // 1. Set temporary dynamic connection
            Config::set('database.connections.hopekell_install', [
                'driver'    => 'mysql',
                'host'      => $data['db_host'],
                'port'      => $data['db_port'] ?? '3306',
                'database'  => $data['db_name'],
                'username'  => $data['db_user'],
                'password'  => $data['db_pass'],
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'    => '',
                'strict'    => true,
                'engine'    => null,
            ]);

            // Clear any cached connection
            DB::purge('hopekell_install');

            // Test the connection
            DB::connection('hopekell_install')->getPdo();

            // Optional: Run a simple query to be extra sure
            DB::connection('hopekell_install')->statement('SELECT 1');

            // 2. If connection works → Update .env file
            $envPath = base_path('.env');

            if (!File::exists($envPath)) {
                return [
                    'success' => false,
                    'message' => '.env file not found!'
                ];
            }

            $envContent = File::get($envPath);

            // Helper function to replace env key
            $replacements = [
                'DB_HOST'     => $data['db_host'],
                'DB_DATABASE' => $data['db_name'],
                'DB_USERNAME' => $data['db_user'],
                'DB_PASSWORD' => $data['db_pass'],
                'DB_PORT'     => $data['db_port'] ?? '3306',
            ];

            $updated = false;
            foreach ($replacements as $key => $value) {
                $pattern = "/^{$key}=(.*)$/m";

                // Escape special characters in value (especially for passwords with quotes/special chars)
                $quotedValue = '"' . addslashes($value) . '"';

                if (preg_match($pattern, $envContent)) {
                    // Key exists → replace it
                    $envContent = preg_replace($pattern, "{$key}={$quotedValue}", $envContent);
                    $updated = true;
                } else {
                    // Key doesn't exist → append it
                    $envContent .= "\n{$key}={$quotedValue}\n";
                    $updated = true;
                }
            }

            if ($updated) {
                File::put($envPath, $envContent);
            }

            // Optional: Clear config cache so new values are picked up immediately
            // Artisan::call('config:clear'); // Uncomment if needed

            return [
                'success' => true,
                'message' => 'Database connection successful and .env file updated!'
            ];

        } catch (Throwable $e) {
            // Get a clean error message without exposing sensitive info
            $message = $e->getMessage();

            // Common friendly messages
            if (str_contains($message, 'Access denied for user')) {
                $message = 'Invalid database username or password.';
            } elseif (str_contains($message, "Unknown database")) {
                $message = 'Database name does not exist.';
            } elseif (str_contains($message, 'No such host is known') || str_contains($message, 'Connection refused')) {
                $message = 'Cannot connect to database host. Check host and port.';
            }

            return [
                'success' => false,
                'message' => 'Database connection failed: ' . $message
            ];
        }
    }
}
