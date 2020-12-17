<?php

namespace App\Models;
use App\Traits\Cacheable;
use Psr\SimpleCache\InvalidArgumentException;

class Lang extends Model
{
    use Cacheable;
    protected $table = 'langs';

    protected $fillable = [
        'key_lb', 'value_lb', 'language_lb', 'active_bl'
    ];

    public function makeCache($params)
    {
        return Lang::all();
    }

    public static function getCache($name)
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
