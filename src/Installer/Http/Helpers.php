<?php

/**
 * Custom helper function 
 * Hopekell technologies
 */

use App\Models\Section;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Get settings with settings key
 */
if (!function_exists('setting')) {
    function setting($key)
    {
        Cache::flush();
        static $settings;

        if (is_null($settings)) {
            $settings = Cache::remember('settings', 24 * 60, function () {
                return array_pluck(Setting::all()->toArray(), 'value', 'key');
            });
        }

        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}

/**
 * Update the enviroment variable 
 * from admin panel
 */
if (!function_exists('update_env')) {
    function update_env($data)
    {
        $envFile = base_path('.env');

        // Read the existing .env file into an array
        $envContent = file($envFile);

        // Loop through the array and update the values for the specified environment variables
        foreach ($envContent as $key => $line) {
            foreach ($data->all() as $envKey => $envValue) {
                if (Str::startsWith($line, $envKey)) {
                    $envContent[$key] = "$envKey=\"" . addslashes($envValue) . "\"\n";
                }
            }
        }

        // Write the updated .env file
        file_put_contents($envFile, implode('', $envContent));
    }
}

/**
 * Get services
 */
if (!function_exists('get_services')) {
    function get_services()
    {
        return Service::all();
    }
}

/**
 * Upload file
 * HLFileUploader
 */
if (!function_exists('uploadFile')) {
    function uploadFile($file, $directory = "uploads/", $name = null)
    {
        if ($name == null) {
            $name = $file->hashName();
        }
        $path = $file->move($directory, $name);
        return url('/') . '/'. $path;
    }
}

/**
 * Get light logo
 */
if (!function_exists('lightLogo')) {
    function lightLogo()
    {
        if (setting('light_logo') != null) {
            $logo = setting('light_logo');
        } else {
            $logo = url('/assets/images/logo-light.png');
        }

        return $logo;
    }
}

/**
 * Get dark logo
 */
if (!function_exists('darkLogo')) {
    function darkLogo()
    {
        if (setting('dark_logo') != null) {
            $logo = setting('dark_logo');
        } else {
            $logo = url('/assets/images/logo-dark.png');
        }

        return $logo;
    }
}

/**
 * Get favicon
 */
if (!function_exists('favicon')) {
    function favicon()
    {
        if (setting('favicon') != null) {
            $favicon = setting('favicon');
        } else {
            $favicon = url('/assets/images/favicon.ico');
        }

        return $favicon;
    }
}

/**
 * Get breadcrumb banner
 */
if (!function_exists('breadcrumbBanner')) {
    function breadcrumbBanner()
    {
        if (setting('breadcrumb_banner')) {
            $banner = setting('breadcrumb_banner');
        } else {
            $banner = url('/assets/images/1.jpg');
        }
 
        return $banner;
    }
}

/**
 * Check if user is admin
 */
if(!function_exists('isAdmin')){
    function isAdmin()
    {
        if (Auth::user()->role_id == 3) {
            return true;
        }
    }
}

/**
 * Get frontend sections
 */
if(!function_exists('getSections'))
{
    function getSections()
    {
        $sections = Section::all();
        return $sections;
    }
}

if(!function_exists('hexToRgb'))
{
    function hexToRgb($hex)
    {
        // Remove the '#' if present
        $hex = str_replace('#', '', $hex);

        // Ensure the hex code is valid
        if (!preg_match('/^[a-fA-F0-9]{6}$/', $hex)) {
            return false; // Invalid hex code
        }

        // Split the hex code into three parts (r, g, b)
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Return the RGB values as an associative array
        // return ['r' => $r, 'g' => $g, 'b' => $b];
        return $r . "," .$g . "," . $b;
    }
}
