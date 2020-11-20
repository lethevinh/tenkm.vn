<?php

namespace App\Models;
use App\Traits\Cacheable;
use App\Traits\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @property mixed children
 * @property mixed parent
 * @property mixed slug_lb
 * @property mixed url_lb
 */
class Menu extends Model
{
    use HasDateTimeFormatter,
        Translatable,
        Sluggable,
        Cacheable,
        ModelTree {
        allNodes as treeAllNodes;
        ModelTree::boot as treeBoot;
    }

    protected $table = 'menus';

    protected $orderColumn = 'order_nb';

    protected $titleColumn = 'title_lb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_lb', 'translation_id',
        'title_lb', 'slug_lb', 'content_lb', 'order_nb', 'media_lb', 'url_lb', 'status_sl','parent_id', 'updated_by', 'created_by',
    ];

    public function current(): bool
    {
        if ($this->children->count() === 0) {
            return $this->url_lb === url()->current();
        }
        return $this->children->filter(function ($item) {
                return $item->url_lb === url()->current();
            })->count() > 0;

    }
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug_lb' => [
                'source' => 'title_lb'
            ]
        ];
    }
    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        static::treeBoot();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function makeCache($params)
    {
        return $this->toTree();
    }

    public function flushCache()
    {
        if ($this->parent) {
            return $this->parent->flushCache();
        }
        $cacheKey = self::cachePrefix($this->slug_lb);
        return $this->getStore()->delete($cacheKey);
    }

    /**
     * @param $name
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function getCacheByName($name, $params = [])
    {
        if (! self::enableCache()) {
            return self::getModelCacheByName($name)->makeCache($params);
        }
        $cacheKey = self::cachePrefix($name);
        if (!self::isExitCacheByName($name)) {
            $model = new static();
            if ($cache = $model->makeCache($params)){
                $model->forever($cache, $cacheKey);
            }
        }
        return self::getStore()->get($cacheKey);
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function cachePrefix($prefix = '')
    {
        $keyModel = static::getModelKey();
        return config('site.cache.keys.' . $keyModel , 'site-caches') . 'menu-all';
    }
}
