<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class JSTrans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'js:translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create JS translations from laravel language resources.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $langs = File::directories(resource_path('lang'));
        $trans = [];

        for ($i = 0; $i < count($langs); $i++) {
            $lang = pathinfo($langs[ $i ])['basename'];

            if ($lang != 'vendor') {
                $langCode = $lang;

                if ($lang == 'cz') $langCode = 'cs';
                $trans[ $langCode ] = $this->handleLang($lang);
            }

            $content = json_encode($trans);

            $content =
                '(function (window, document, undefined) {'.
                '"use strict";'.
                'App.lang = '.
                $content.
                '})(window, document);';

            // Write the contents of a file
            File::put(resource_path('assets/js/trans.js'), $content);
        }
    }


    private function handleLang($lang)
    {
        echo "Processing ".$lang.PHP_EOL;
        App::setLocale($lang);
        $trans = trans('javascript');

        return $trans;
    }
}
