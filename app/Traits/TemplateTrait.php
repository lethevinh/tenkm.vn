<?php
namespace App\Traits;
use Illuminate\Support\Arr;

trait TemplateTrait {
    public $locations = [];
    public function addLocation($paths) {
        $paths = is_array($paths) ? $paths : [$paths];
        if ($paths) {
            foreach ($paths as $key => $path) {
                view()->getFinder()->prependLocation($path);
            }
            $this->locations = view()->getFinder()->getPaths();
        }
    }

    public function render($template, array $params = []) {
        $template = is_array($template) ? $template : [$template];
        $template = self::chooseTemplate($template);
        $html = view()->make($template, $params);
        return app('shortcode')->doShortcodes($html);
    }

    public function templateExists($file) {
        $locations = view()->getFinder()->getPaths();
        foreach ($locations as $dir) {
            $look_for = $dir . '/' . str_replace('.', '/', $file) . '.blade.php';
            if (file_exists($look_for)) {
                return true;
            }
        }
        return false;
    }

    public function chooseTemplate($filenames) {

        if (!is_array($filenames) && $filenames) {
            return $filenames;
        }

        return Arr::last($filenames, function ($filename, $key) {
            return $this->templateExists($filename);
        });
    }

}
