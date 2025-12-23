<?php

namespace HopekellDev\Core\Installer\Services;

class LicenseVerifier
{
    public static function verify(string $code, string $domain): void
    {
        if (strlen($code) < 10) {
            abort(403, 'Invalid purchase code');
        }

        // TODO: Call HopekellDev license server
    }

    public static function lock(): void
    {
        $path = base_path('vendor/hopekell-dev/core/storage');

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        file_put_contents(
            $path.'/HOPEKELLDEV.LIV',
            json_encode([
                'domain'       => request()->getHost(),
                'installed_at' => now()->toDateTimeString(),
                'signature'    => hash_hmac(
                    'sha256',
                    request()->getHost(),
                    config('app.key')
                )
            ], JSON_PRETTY_PRINT)
        );
    }
}
