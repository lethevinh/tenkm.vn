<?php

namespace App\Models;


use App\Traits\Linkable;
use App\Traits\Ownable;
use App\Traits\Typeable;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Kalnoy\Nestedset\NodeTrait;

class Location extends Model
{
    use Ownable, Sluggable, NodeTrait {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $fillable = ['title_lb', 'parent_id'];

    protected $table = 'locations';

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

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }
}
