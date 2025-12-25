<?php

namespace HopekellDev\Core\Installer\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LicenseVerifier
{
    // private const REQUEST_HASH = '607d20bf9f3d4429667c5498afe1b28beaa6d0739be28e8719';
    public static function verify(string $code, string $domain)
    {
        if (! Str::isUuid($code)) {
            return [
                'status' => 'error',
                'message' => 'Invalid purchase code format'
            ];
        }

        $response =  Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Request-Hash' => '607d20bf9f3d4429667c5498afe1b28beaa6d0739be28e8719'
        ])->post(
            'https://hopekelltech.com/api/envato/verify-license',
            [
                'purchase_code' => $code,
                'domain'        => $domain,
                'product' => config('app.product'),
            ]
        );

        return $response->json();
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
