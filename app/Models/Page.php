<?php

namespace App\Models;

use App\Traits\Cacheable;
use App\Traits\Metadatable;

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
        return self::findOrFail(1);
    }

    public static function home() {
        return self::published()->findOrFail(self::site()->home_id);
    }
}
