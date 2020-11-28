<?php

namespace App\Models;


use App\Traits\Categorizable;
use App\Traits\Commentable;
use App\Traits\Linkable;
use App\Traits\Ownable;
use App\Traits\Ratingable;
use App\Traits\Taggable;
use App\Traits\Typeable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class Media extends Model
{
    use Sluggable, Categorizable, Ownable, Taggable, Commentable, Ratingable, Linkable;

    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title_lb', 'slug_lb', 'image_lb','status_sl', 'type_lb', 'ext_lb', 'path_lb', 'updated_by', 'created_by',
    ];

    public $translatable = ['title_lb', 'slug_lb'];
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updateBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     *
     * @return mixed
     */
    public function getSlugAttribute() {
        return $this->slug_lb;
    }

    /**
     *
     * @return mixed
     */
    public function getThumbnailAttribute() {
        if (Str::startsWith($this->attributes['image_lb'], ['http://', 'https://'])) {
            return $this->attributes['image_lb'];
        }
        return Storage::disk('public')->url($this->attributes['image_lb']);
    }

    public function getLinkAttribute()
    {
        return route('file.show', ['file' => $this]);
    }

    public function getStreamLinkAttribute() {
        $path = $this->attributes['path_lb'];
        if (Str::startsWith($this->attributes['path_lb'], ['http://', 'https://'])) {
            $path = $this->attributes['path_lb'];
        }
        return route('video.link', ['path' => $path]);
    }

    public function toSource()
    {
        return json_encode([
            'path' => $this->streamlink,
            'name' => $this->title_lb,
            'image' => $this->image_lb,
        ]);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function resources()
    {
        return $this->morphedByMany(Resource::class ,'resourceable', 'resourceable', 'resourceable_id')
            ->withTimestamps();
    }

    public function resource()
    {
        return $this->morphOne(Resource::class, 'sourceable');
    }
}
