<?php

namespace App\Models;

use App\Traits\Linkable;
use App\Traits\Translatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Traits\Ownable;
use App\Traits\Typeable;

class Category extends Model
{

    use Ownable, Typeable, Linkable, Sluggable, NodeTrait, Translatable {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $fillable = ['title_lb', 'parent_id',  'language_lb', 'translation_id',];

    protected $table = 'categories';

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            collect(['posts', 'products'])->each(function ($relation) use ($model) {
                if (method_exists($model, $relation)) {
                    $model->{$relation}()->sync([]);
                }
            });
        });
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type_lb', $type);
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable():array
    {
        return [
            'slug_lb' => [
                'source' => 'title_lb'
            ]
        ];
    }


    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    public function categorizables($class)
    {
        return $this->morphedByMany($class, 'categorizable', 'categorizable', 'category_id');
    }

    public function getRelationValue($key)
    {

        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        if (class_exists($key)) {
            $class = class_basename($key);
            $relation = $this->categorizables($class);
            return tap($relation->getResults(), function ($results) use ($key) {
                $this->setRelation($key, $results);
            });
        }
        return parent::getRelationValue($key);
    }
    public function __call($method, $arguments)
    {
        if (class_exists($method)) {
            $class = class_basename($method);
            return $this->categorizables($class);
        }
        $keyModel= static::getModelKey('Category', 'post');
        if ($method == Str::plural($keyModel) && !method_exists($this, $method )) {
            $classModel = "App\\Models\\" . ucfirst($keyModel);
            if (class_exists($classModel)) {
                return $this->morphedByMany($classModel ,'categorizable', 'categorizable', 'category_id', 'categorizable_id')
                    ->withTimestamps();
            }
        }
        return parent::__call($method, $arguments);
    }

    /**
     * @return string
     */
    public function getLinkAttribute(){
        $keyModel = static::getModelKey('Category', 'post');
        return route($keyModel.'.category', ['category' => $this]);
    }

    protected static function booted()
    {
        $keyModel = static::getModelKey('Category');
        if (!empty($keyModel)) {
            static::creating(function ($post) use ($keyModel) {
                $post->type_lb = $keyModel;
            });
            static::addGlobalScope('type', function (Builder $builder) use ($keyModel) {
                $builder->where('type_lb', $keyModel);
            });
        }
    }
    /**
     * @return Application|UrlGenerator|string
     */
    public function getEditAttribute() {
        $keyModel = static::getModelKey('Category');
        return url('admin/categories/'.$keyModel.'/'.$this->id.'/edit');
    }
}
