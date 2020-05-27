<?php


namespace App\Traits;

use App\Observers\TypeableObserver;

trait Typeable
{
    public static function bootTypeable()
    {
        static::observe(app(TypeableObserver::class));
    }
}
