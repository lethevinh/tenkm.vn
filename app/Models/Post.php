<?php

namespace App\Models;

use App\Traits\Cacheable;
use App\Traits\Commentable;
use App\Traits\Linkable;
use App\Traits\Reactable;
use App\Traits\Taggable;
use App\Traits\Translatable;
use App\Traits\Typeable;
use App\Traits\Ratingable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\Categorizable;
use App\Traits\Ownable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

/**
 * @method static findOrFail($id)
 * @method static ofType(string $string)
 * @method static public ()
 * @property mixed title_lb
 * @property mixed slug_lb
 */
class Post extends Model implements Searchable
{
    const STATUS = ['public' => 'public', 'draft' => 'draft', 'private' => 'private', 'trash' => 'trash'];

    use Sluggable, Categorizable, Ownable, Typeable, Taggable, Commentable,
        Ratingable, Linkable, Cacheable, Reactable, Translatable;

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'updated_by', 'created_by', 'title_lb', 'slug_lb', 'image_lb','status_sl', 'template_lb',
        'type_lb', 'description_lb', 'content_lb', 'review_nb', 'view_nb', 'comment_nb',
        'language_lb', 'translation_id',
        'published_at', 'validated_at'
    ];

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

    /**
     * @return BelongsTo
     */
    public function updateBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     *
     * @return mixed
     */
    public function getThumbnailAttribute() {
        $disk = Storage::disk(config('admin.upload.disk'));
        $thumbnail = $this->attributes['image_lb'];
        if (!empty($thumbnail) && !URL::isValidUrl($thumbnail) && $disk->exists($thumbnail)) {
            return $disk->url($thumbnail);
        }
        return $thumbnail;
    }

    public function getLinkAttribute()
    {
        $keyModel = static::getModelKey();
        if (isset($this->attributes['slug_lb'])) {
            return route($keyModel . '.show', ['slug' => $this->attributes['slug_lb']]);
        }
        return '';
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

    public function scopePublic($query)
    {
        $keyModel = static::getModelKey();
        return $query->ofType($keyModel)->validated()->orderByDesc('updated_at');
    }

    public static function getModelCacheByName($name) {
        return static::where('slug_lb', $name)->public()->firstOrFail();
    }

    public static function getModelCacheById($id) {
        return static::findOrFail($id);
    }

    protected static function booted()
    {
        $keyModel = static::getModelKey();
        static::creating(function ($post) use ($keyModel) {
            $post->type_lb = $keyModel;
        });
        static::addGlobalScope('type', function (Builder $builder) use ($keyModel) {
            $builder->where('type_lb', $keyModel);
        });
    }

    /**
     * @param $params
     * @return mixed
     */
    public function makeCache($params)
    {
        return $this;
    }
}
