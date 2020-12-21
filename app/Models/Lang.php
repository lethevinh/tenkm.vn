<?php

namespace App\Models;
use App\Traits\Cacheable;
use Psr\SimpleCache\InvalidArgumentException;

class Lang extends Model
{
    use Cacheable;

    const KEY_CACHE = 'site-langs';

    protected $table = 'langs';

    protected $fillable = [
        'key_lb', 'value_lb', 'language_lb', 'active_bl'
    ];

    public function makeCache($params)
    {
        return Lang::all();
    }

    public function flushCache()
    {
        return $this->getStore()->delete(self::KEY_CACHE);
    }

    public static function getCache($name = self::KEY_CACHE)
    {
        if (!self::enableCache()) {
            return (new static())->makeCache([]);
        }
        if (!self::getStore()->has($name)) {
            $model = new static();
            $model->forever($model->makeCache([]), $name);
        }
        return self::getStore()->get($name);
    }
}
