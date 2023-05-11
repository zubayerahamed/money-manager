<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDOException;

class SetupController extends Controller
{

    protected array $dbConfig;

    public function welcome()
    {
        return view('setup.welcome');
    }

    public function requirements()
    {
        [$success, $results] = $this->checkRequirements();

        return view('setup.requirements', [
            'success' => $success,
            'results' => $results,
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
        return view('setup.database');
    }

    public function configure(Request $request)
    {
        $this->createTempDatabaseConnection($request->all());

        if ($this->databaseHasData() && !$request->has('overwrite_data')) {
            return redirect()->back()->with('data_present', true)->withInput();
        }

        $migrationResult = $this->migrateDatabase();

        if ($migrationResult === false) {
            return redirect()->back()->withInput();
        }

        $this->storeConfigurationInEnv();

        return redirect()->route('setup.complete');
    }

    protected function createTempDatabaseConnection(array $credentials): void
    {
        $this->dbConfig = config('database.connections.mysql');

        $this->dbConfig['host'] = $credentials['db_host'];
        $this->dbConfig['port'] = $credentials['db_port'];
        $this->dbConfig['database'] = $credentials['db_name'];
        $this->dbConfig['username'] = $credentials['db_user'];
        $this->dbConfig['password'] = $credentials['db_password'];

        Config::set('database.connections.setup', $this->dbConfig);
    }

    protected function migrateDatabase(): bool
    {
        try {
            Artisan::call('migrate:fresh', [
                '--database' => 'setup', // Specify the correct connection
                '--force' => true, // Needed for production
                '--no-interaction' => true,
                '--seed' => true
            ]);
        } catch (Exception $e) {
            $alert = 'Database could not be configured. Please check your connection details. Details: ' . $e->getMessage();
            return false;
        }

        return true;
    }

    protected function storeConfigurationInEnv(): void
    {
        $envContent = File::get(base_path('.env'));

        $envContent = preg_replace([
            '/DB_HOST=(.*)\S/',
            '/DB_PORT=(.*)\S/',
            '/DB_DATABASE=(.*)\S/',
            '/DB_USERNAME=(.*)\S/',
            '/DB_PASSWORD=(.*)\S/',
        ], [
            'DB_HOST=' . $this->dbConfig['host'],
            'DB_PORT=' . $this->dbConfig['port'],
            'DB_DATABASE=' . $this->dbConfig['database'],
            'DB_USERNAME=' . $this->dbConfig['username'],
            'DB_PASSWORD=' . $this->dbConfig['password'],
        ], $envContent);

        if ($envContent !== null) {
            File::put(base_path('.env'), $envContent);
        }
    }

    protected function databaseHasData(): bool
    {
        try {
            $present_tables = DB::connection('setup')
                ->getDoctrineSchemaManager()
                ->listTableNames();
        } catch (PDOException $e) {
            Log::error($e->getMessage());
            return false;
        }

        return count($present_tables) > 0;
    }

    public function complete()
    {
        Setting::create(['key' => 'system_setup_completed', 'value' => true]);
        Cache::forget('systemsettings');

        return view('setup.complete');
    }
}
