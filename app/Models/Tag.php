<?php

namespace App\Models;

use App\Traits\Typeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model implements Sortable
{
    use SortableTrait, Sluggable, Typeable;

    protected $table  = 'tags';

    public $translatable = ['title_lb', 'slug_lb'];

    public $guarded = [];

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
     * @return string
     */
    public function getLinkAttribute(){
        $keyModel = static::getModelKey('Tag', 'post');
        return route($keyModel.'.tag', ['tag' => $this]);
    }

    public function __call($method, $parameters)
    {
        $keyModel= static::getModelKey('Tag', 'post');
        if ($method == Str::plural($keyModel)  && !method_exists($this, $method )) {
            $classModel = "App\\Models\\" . ucfirst($keyModel);
            if (class_exists($classModel)) {
                return $this->morphedByMany($classModel ,'taggable', 'taggable', 'tag_id', 'taggable_id')->withTimestamps();
            }
        }
        return parent::__call($method, $parameters);
    }

    protected static function booted()
    {
        $keyModel = static::getModelKey('Tag');
        if (!empty($keyModel)) {
            static::creating(function ($post) use ($keyModel) {
                $post->type_lb = $keyModel;
            });
            static::addGlobalScope('type', function (Builder $builder) use ($keyModel) {
                $builder->where('type_lb', $keyModel);
            });
        }
    }
}
