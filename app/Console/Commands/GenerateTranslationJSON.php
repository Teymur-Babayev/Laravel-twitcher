<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateTranslationJSON extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan and generate translations JSON';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // specify paths
        $paths = [
                'Blade Files' => resource_path('views'),
                'APP Files' => app_path(),
                'JSX Files' => resource_path('js')
        ];

        // build array of translatable files
        $translateFiles = [];

        // push the files in the array
        foreach ($paths as $type => $path) {
            $this->line("--");
            $this->info('Scanning for ' . $type);
            $this->line("--");
            $files = File::allFiles($path);

            foreach ($files as $f) {
                $translateFiles[] = $f;
            }
        }

        // now scan the files in the array
        $strings = [];

        foreach ($translateFiles as $file) {
            $this->info($file->getPathname());
            $found = $this->findTranslateableStrings($file->getContents());
            $this->info("Found: " . count($found));
            $this->line("--");
            $strings[] = $found;
        }

        $strings = collect($strings)
                    ->flatten()
                    ->reject(fn ($value) => Str::startsWith($value, 'navigation.'))
                    ->reject(fn ($value) => Str::startsWith($value, 'auth.'))
                    ->reject(fn ($value) => Str::startsWith($value, 'v16.'))
                    ->reject(fn ($value) => Str::startsWith($value, 'v103.'))
                    ->reject(fn ($value) => Str::startsWith($value, 'post.'))
                    ->reject(fn ($value) => preg_match('/coffee/i', $value))
                    ->reject(fn ($value) => preg_match('/platinum/i', $value))
                    ->unique();


        $jsonStrings = [];

        foreach ($strings as $s) {
            $jsonStrings[$s] = $s;
        }


        $writeTo = lang_path('en.json');

        file_put_contents($writeTo, collect($jsonStrings)->toJson());

        $this->info('Written ' . $strings->count() . ' strings to ' . $writeTo);

        return Command::SUCCESS;
    }


    public function findTranslateableStrings($contents)
    {
        $regex = '/[^\w](?<!->)(trans|trans_choice|Lang::get|Lang::choice|Lang::trans|Lang::transChoice|@lang|@choice|__)\s*\([\'|"]([^\'|"]+)/i';
        preg_match_all($regex, $contents, $output_array);

        if (isset($output_array[2])) {
            return $output_array[2];
        }

        return [];
    }
}
