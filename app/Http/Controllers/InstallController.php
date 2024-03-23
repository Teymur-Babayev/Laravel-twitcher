<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PDO;

class InstallController extends Controller
{
    public function __construct()
    {
    }

    public function install(Request $request)
    {
        if (env('IS_INSTALLED') == 'yes') {
            session()->flash('message', __("Already installed"));
            return to_route('home');
        }

        $requirements = $this->checkRequirements();
        $canContinue = !in_array(false, $requirements);
        return view('install/requirements', compact('requirements', 'canContinue'));
    }

    public function database()
    {
        if (env('IS_INSTALLED') == 'yes') {
            session()->flash('message', __("Already installed"));
            return to_route('home');
        }

        return view('install/database');
    }

    public function saveDB(Request $request)
    {
        if (env('IS_INSTALLED') == 'yes') {
            session()->flash('message', __("Already installed"));
            return to_route('home');
        }

        $request->validate([
            'DB_HOST' => 'required',
            'DB_DATABASE' => 'required',
            'DB_USERNAME' => 'required'
        ]);

        try {
            // check connection
            $db = new PDO('mysql:host=localhost;dbname=' . $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // update .env file with the details
            $envItems = $request->only(['DB_HOST', 'DB_DATABASE', 'DB_PASSWORD', 'DB_USERNAME']);

            foreach ($envItems as $key => $val) {
                if ($key == "DB_PASSWORD") {
                    $this->__updateEnvKey($key, '"'.$val.'"');
                } else {
                    $this->__updateEnvKey($key, $val);
                }
            }

            // import database
            $file = File::get(base_path('database/twitcher.sql'));

            $db->exec($file);

            // update app url
            $this->__updateEnvKey('APP_URL', route('home'));

            // update installation status
            $this->__updateEnvKey('IS_INSTALLED', 'yes');

            return redirect(route('installer.finished'));
        } catch(\Exception $e) {
            return redirect(route('installer.db'))
                    ->with('message', $e->getMessage())
                    ->withInput();
        }
    }

    public function finished()
    {
        return view('install.finished');
    }


    private function checkRequirements(): array
    {
        return [
            'php-version' => version_compare(PHP_VERSION, '8.0.26', '>='),
            'bcmath' => extension_loaded("bcmath"),
            'ctype' => extension_loaded("ctype"),
            'curl' => extension_loaded("curl"),
            'dom' => extension_loaded("dom"),
            'fileinfo' => extension_loaded("fileinfo"),
            'json' => extension_loaded("json"),
            'mbstring' => extension_loaded("mbstring"),
            'openssl' => extension_loaded("openssl"),
            'pcre' => extension_loaded("pcre"),
            'pdo' => defined('PDO::ATTR_DRIVER_NAME'),
            'tokenizer' => extension_loaded("tokenizer"),
            'xml' => extension_loaded("xml"),
            'gd' => extension_loaded("gd"),
        ];
    }

    public function __updateEnvKey($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        $newContents = preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        );

        if (fopen($path, 'r+')) {
            file_put_contents($path, $newContents);
        } else {
            dd("MAKE SURE $path IS WRITABLE");
        }

        return $newContents;
    }
}
