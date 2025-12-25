<?php

namespace HopekellDev\Core\Installer\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use HopekellDev\Core\Installer\Services\LicenseVerifier;
use HopekellDev\Core\Installer\Services\DatabaseChecker;
use HopekellDev\Core\Installer\Services\SqlImporter;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    public function step1()
    {
        return view('hopekell-installer::installer.step1');
    }

    public function step2()
    {

        return view('hopekell-installer::installer.step2');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'purchase_code' => 'required'
        ]);

        $data = LicenseVerifier::verify(
            $request->purchase_code,
            $request->getHost()
        );

        Log::info($data);

        if (($data['status'] ?? null) === 'success') {
            session()->put('install_app', true);
            return redirect()->route('hopekell.install.database.form');
        }

        return back()->withErrors([
            'purchase_code' => $data['message'] ?? 'License verification failed'
        ]);
    }

    public function databaseForm()
    {
        if (! session()->get('install_app')) {
            return redirect()->route('hopekell.install');
        }

        return view('hopekell-installer::installer.step3');
    }

    public function database(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);

        $result = DatabaseChecker::check($request->all());

        if (! $result['success']) {
            return back()
                ->withInput()
                ->withErrors([
                    'database' => $result['message']
                ]);
        }

        session()->put('db_credentials', $request->all());

        return redirect()->route('hopekell.install.database.import-sql')->with('success', 'Database connected successfully');
    }

    public function databaseImportSql()
    {
        if (! session()->get('install_app')) {
            return redirect()->route('hopekell.install');
        }

        return view('hopekell-installer::installer.step4');
    }

    public function importSql(Request $request)
    {
        if (! session()->get('install_app')) {
            return response()->json([
                'success' => false,
                'message' => 'Installation session expired'
            ], 403);
        }

        $product = config('app.product');

        // 1️⃣ Fetch SQL URL from license server
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Request-Hash' => '607d20bf9f3d4429667c5498afe1b28beaa6d0739be28e8719'
        ])->timeout(20)->post(
            "https://hopekelltech.com/api/envato/get-sql-url/{$product}",
            [
                'domain' => request()->getHost(),
            ]
        );

        if (! $response->ok()) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch SQL URL from server'
            ], 500);
        }

        $sqlUrl = $response->json('url');

        if (! $sqlUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid SQL URL received'
            ], 500);
        }

        // 2️⃣ Import SQL
        $import = SqlImporter::import($sqlUrl);

        if (! $import['success']) {
            return response()->json([
                'success' => false,
                'message' => $import['message']
            ], 500);
        }

        // 3️⃣ Lock installation
        LicenseVerifier::lock();

        session()->forget(['install_app', 'db_credentials']);

        return response()->json([
            'success' => true,
            'message' => 'Installation completed successfully'
        ]);
    }
    public function success()
    {
        return view('hopekell-installer::installer.success');
    }

}
