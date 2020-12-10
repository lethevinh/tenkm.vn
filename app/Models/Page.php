<?php

namespace App\Models;

use App\Traits\Cacheable;
use App\Traits\Metadatable;
use Illuminate\Support\Str;

class Page extends Post
{
    use Metadatable, Cacheable;

    protected $seoKeys = [
        'keyword' => 'seo_keyword',
        'description' => 'seo_description',
    ];

    public function getLinkAttribute()
    {
        return route('page.show', ['slug' => $this->slug_lb]);
    }

    public static function site()
    {
        $locale = session()->get('locale', config('site.locale_default'));
        $name = $locale == config('site.locale_default') ? 'site-1' : 'site';
        return Page::getCacheByName($name);
    }

    public static function home()
    {
        return self::getCacheById(self::site()->home_id);
    }

    public function getEditAttribute()
    {
        if ($this->id === 1 || $this->id === 2) {
            return route('site.setting', $this->id);
        }
        return parent::getEditAttribute();
    }
}
