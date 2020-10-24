<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Page;
use App\Services\SEOTool;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('menu', \App\View\Components\Menu::class);
    }
}
