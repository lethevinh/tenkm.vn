<?php

namespace App\Models;
use App\Traits\Cacheable;
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
     * @param $template
     * @return mixed
     */
    public function makeCache($params)
    {
        $templates = [
            'menus.' . $this->slug_lb,
            'menus.default'
        ];
        if (!empty($params['template']) && $params['template'] != 'default') {
            array_unshift($templates, 'menus.' . $params['template']);
        }
        return view()->first($templates, ['menu' => $this])->render();
    }

    protected function getCacheKey()
    {
        return config('site.cache.keys.menu') . $this->slug_lb;
    }

    public function flushCache()
    {
        if ($this->parent) {
            return $this->parent->flushCache();
        }
        return $this->getStore()->delete($this->getCacheKey());
    }

}
