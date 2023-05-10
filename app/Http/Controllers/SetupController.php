<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SetupController extends Controller
{
    public function welcome(){

        if(request()->ajax()){
            return view('layouts.setup.welcome', [
                'nextUrl' => route('setup.requirements')
            ]);
        }

        return view('setup', [
            'nextUrl' => route('setup.requirements')
        ]);
    }

    public function requirements()
    {
        [$success, $results] = $this->checkRequirements();

        return view('layouts.setup.requirements', [
            'success' => $success,
            'results' => $results,
            'nextUrl' => route('setup.database'),
            'prevUrl' => route('setup.welcome')
        ]);
    }

    private function checkRequirements(): array
    {
        $results = [
            'PHP version >= 7.4.0' => PHP_VERSION_ID >= 70400,
            'PHP Extension: BCMath' => extension_loaded('bcmath'),
            'PHP Extension: Ctype' => extension_loaded('ctype'),
            'PHP Extension: JSON' => extension_loaded('json'),
            'PHP Extension: Mbstring' => extension_loaded('mbstring'),
            'PHP Extension: OpenSSL' => extension_loaded('openssl'),
            'PHP Extension: PDO' => extension_loaded('pdo_mysql'),
            'PHP Extension: Tokenizer' => extension_loaded('tokenizer'),
            'PHP Extension: XML' => extension_loaded('xml'),
            '.env file is present and writable' => File::isWritable(base_path('.env')),
            '/storage and /storage/logs directories are writable' => File::isWritable(storage_path()) && File::isWritable(storage_path('logs')),
        ];

        $success = !in_array(false, $results, true);

        return [$success, $results];
    }

    public function database()
    {
        return view('layouts.setup.database', [
            'prevUrl' => route('setup.requirements')
        ]);
    }
}
