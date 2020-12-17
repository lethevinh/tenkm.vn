<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

use \Illuminate\Support\Facades\File;
Artisan::command('lang:js {locale=vi}', function ($locale) {
    $folderPath = resource_path('/lang/' . $locale . '/');
    if (!File::exists($folderPath)) {
        return false;
    }
    $filesInFolder = File::files($folderPath);
    $lang = [];
    foreach($filesInFolder as $path) {
        $file = pathinfo($path);
        $filePath = $file['dirname'] . '/' . $file['basename'];
        if (!is_readable($filePath)) {
           continue;
        }
        $lang[$file['filename']] =  require($filePath);
    }
    $langContent = json_encode($lang, JSON_UNESCAPED_UNICODE);
    $folderPublicPath = public_path('lang');
    if (!File::exists($folderPublicPath)) {
        File::makeDirectory($folderPublicPath);
    }
    $filePublicPath = 'public/lang/'.$locale.'.json';
    file_put_contents(base_path($filePublicPath), stripslashes($langContent));
})->describe('Make lang to json');

Artisan::command('lang:db {locale=vi}', function ($locale) {
    $folderPath = resource_path('/lang/' . $locale . '/');
    if (!File::exists($folderPath)) {
        return false;
    }
    $filesInFolder = File::files($folderPath);
    $lang = [];
    foreach($filesInFolder as $path) {
        $file = pathinfo($path);
        $filePath = $file['dirname'] . '/' . $file['basename'];
        if (!is_readable($filePath)) {
            continue;
        }
        $lang[$file['filename']] =  require($filePath);
    }
    foreach ($lang['site'] as $key => $lang) {
        if (is_string($lang)){
            \App\Models\Lang::updateOrCreate([
                'key_lb' => 'site.' . $key,
                'language_lb' => $locale,
            ], [
                'value_lb' => $lang,
            ]);
        }else{
            foreach ($lang as $skey => $slang) {
                \App\Models\Lang::updateOrCreate([
                    'key_lb' => 'site.' .$skey.'.'. $key,
                    'language_lb' => $locale,
                ], [
                    'value_lb' => $slang,
                ]);
            }
        }
    }
})->describe('Make lang to db');
