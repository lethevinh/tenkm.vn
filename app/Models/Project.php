<?php

namespace App\Models;

use App\Traits\Amenitable;
use App\Traits\Cacheable;
use App\Traits\Categorizable;
use App\Traits\Commentable;
use App\Traits\Locationable;
use App\Traits\Orderable;
use App\Traits\Ownable;
use App\Traits\Reactable;
use App\Traits\Taggable;
use App\Traits\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * @property mixed title_lb
 */
class Project extends Model implements Searchable
{
    use Sluggable, Orderable, Ownable, Commentable, Cacheable, Categorizable, Taggable, Reactable,
        Locationable, Amenitable, Translatable;

    protected $table = 'projects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title_lb', 'slug_lb', 'image_lb', 'status_sl', 'gallery_lb',
        'description_lb', 'content_lb', 'document_lb', 'area_lb', 'floorplan_lb',
        'review_nb', 'view_nb', 'comment_nb',
        'price_fl', 'price_sale_fl',
        'language_lb', 'translation_id',
        'bedroom_nb', 'bathroom_nb', 'area_nb','streetview_lb', 'shop_nb', 'department_nb', 'floor_nb',
        'block_nb', 'type_lb',
        'published_at', 'validated_at', 'updated_by', 'created_by', 'opened_at', 'stopped_at'
    ];

    public function sluggable(): array
    {
        return [
            'slug_lb' => [
                'source' => 'title_lb'
            ]
        ];
    }

    public function makeCache($params)
    {
        return $this;
    }

    public function getSearchResult(): SearchResult
    {
        $url = $this->getLinkAttribute();
        return new SearchResult(
            $this,
            $this->title_lb,
            $url
        );
    }

    /**
     *
     * @return mixed
     */
    public function getGalleriesAttribute() {
        $disk = Storage::disk(config('admin.upload.disk'));
        $galleries = [];
        $images = explode(',', $this->attributes['gallery_lb']);
        foreach ($images as $image)
        {
            if (!empty($image) && !URL::isValidUrl($image) && $disk->exists($image)) {
                $galleries[] = $disk->url($image);
            }else {
                $galleries[] = $image;
            }
        }
        return $galleries;
    }

    public function getLinkAttribute()
    {
        if (isset($this->attributes['slug_lb'])) {
            return route( 'project.show', ['slug' => $this->attributes['slug_lb']]);
        }
        return '';
    }

    public function amenities(): MorphToMany
    {
        return $this->morphToMany(Amenity::class, 'amenitable', 'amenitable')
            ->withTimestamps();
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }
}
