<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Page;
use App\Services\SEOTool;
use App\Services\Shortcodes;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SiteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('seo', function ($app) {
            return new SEOTool();
        });
        $this->registerShortCodeService();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('menu', \App\View\Components\Menu::class);
        $this->registerShortCodes();
    }

    public function registerShortCodes() {

        $files = array_slice(scandir(app_path() . '/Shortcodes'), 2);
        foreach ($files as $key => $file) {
            $filename = basename($file, '.php');
            $className = "App\\Shortcodes\\" . $filename;
            if ($filename != 'AbstractShortcode' && class_exists($className)) {
                app('shortcode')->addShortCode($className::$name, $className);
            }
        }
    }

    public function registerShortCodeService() {
        $this->app->bindIf('shortcode', function ($app) {
            return new Shortcodes();
        });
        $this->app->singleton("shortcode", function ($app) {
            return new Shortcodes();
        });
    }
}
