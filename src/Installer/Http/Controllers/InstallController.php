<?php

namespace HopekellDev\Core\Installer\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use HopekellDev\Core\Installer\Services\LicenseVerifier;
use HopekellDev\Core\Installer\Services\DatabaseChecker;
use HopekellDev\Core\Installer\Services\SqlImporter;

class InstallController extends Controller
{
    public function step1()
    {
        return view('hopekell-installer::installer.step1');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'purchase_code' => 'required'
        ]);

        LicenseVerifier::verify(
            $request->purchase_code,
            $request->getHost()
        );

        return view('hopekell-installer::installer.step2');
    }

    public function database(Request $request)
    {
        DatabaseChecker::check($request->all());

        SqlImporter::import(
            config('hopekell.sql_url')
        );

        LicenseVerifier::lock();

        return redirect('/install/success');
    }

    public function success()
    {
        return view('hopekell-installer::installer.success');
    }
}
