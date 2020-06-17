<?php

namespace App\Traits;

use App\Models\Metadata;
use App\Models\Metafield;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;


trait Metadatable
{

    /**
     * The name of the comments model.
     *
     * @return string
     */
    public function metadatableModel(): string
    {
        return Metadata::class;
    }

    /**
     * @return MorphMany
     */
    public function fields(): MorphMany
    {
        return $this->morphMany(Metafield::class, 'fieldable')->orderBy('order_nb');
    }

    public function addField($field)
    {
        return $this->fields()->create($field);
    }

    /**
     * @param string $field
     * @param array $data
     * @return bool
     */
    public function updateField(string $field, array $data)
    {
        return (bool)$this->fields()->where('name_lb', $field)->update($data);
    }

    /**
     * @return MorphMany
     */
    public function metas(): MorphMany
    {
        return $this->morphMany($this->metadatableModel(), 'metadatable');
    }

    /**
     * @param array $meta
     * @return BaseModel
     */
    public function setMeta(array $meta)
    {
        return $this->metas()->create($meta);
    }

    /**
     * @param array $metas
     */
    public function setMetas(array $metas)
    {
        $metas = is_array($metas) ? $metas : [$metas];
        foreach ($metas as $meta) {
            $this->setMeta($meta);
        }
    }

    public function updateOrCreateMeta($key, $value)
    {
        if ($this->metas()->where('key_lb', $key)->first()) {
            $this->updateMeta($key, $value);
        } else {
            $this->setMeta([
                'key_lb' => $key,
                'value_lb' => $value
            ]);
        }
    }

    /**
     * @param $key
     * @return BaseModel|MorphMany|object|null
     */
    public function getMeta($key)
    {
        return $this->metas()->where('key_lb', $key)->first();
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function updateMeta(string $key, string $value)
    {
        return (bool)$this->metas()->where('key_lb', $key)->update(['value_lb' => $value]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function unsetMeta(string $key): bool
    {
        return (bool)$this->metas()->where('key_lb', $key)->delete();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (empty($this->$key) &&
            empty($this->attributes[$key]) &&
            !in_array($key, $this->fillable) &&
            !method_exists($this, $key) &&
            isset($this->metas) &&
            $metas = $this->metas) {
            $meta = $metas->reject(function ($meta) use ($key) {
                return $meta->key_lb !== $key;
            })->first();
            if ($meta) {
                // file
                if (strpos($meta->value_lb, 'files/') > -1) {
                    return Storage::disk('public')->url($meta->value_lb);
                }
                //json
                if ((strpos($meta->value_lb, '[') > -1)) {
                    return json_decode($meta->value_lb, true);
                }
                return $meta->value_lb;
            }
        }
        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (empty($this->attributes[$key]) &&
            !in_array($key, $this->fillable) &&
            !method_exists($this, $key) &&
            isset($this->attributes['id']) &&
            !empty($this->attributes['id'])) {
            $value = is_string($value) ? $value : json_encode($value, true);
            Metadata::updateOrCreate([
                'key_lb' => $key,
                'metadatable_id' => $this->attributes['id'],
                'metadatable_type' => static::class,
            ], [
                'value_lb' => $value
            ]);
            return $this;
        }
        return parent::setAttribute($key, $value);
    }

    /**
     *
     */
    public static function bootMetadatable()
    {
        static::deleted(function ($model) {
            $model->metas()->delete();
            $model->fields()->delete();
        });
        static::addGlobalScope('metadata', function (Builder $builder) {
            $builder->with('metas')->with('fields');
        });
    }

    public function onConstruct($attributes = [])
    {

    }

    protected $seoMap = [
        'title' => 'title_lb',
        'keyword' => 'keyword',
        'description' => 'description_lb',
        'image' => 'image_lb',
        'published_time' => 'created_at',
    ];

    public function seo()
    {
        $this->seoMap = array_merge($this->seoMap, $this->seoKeys);
        $seo = app('seo');
        $title = $this->{$this->seoMap['title']} ? $this->{$this->seoMap['title']} : '';
        $description = $this->{$this->seoMap['description']} ? $this->{$this->seoMap['description']} : '';
        $keyword = $this->{$this->seoMap['keyword']} ? $this->{$this->seoMap['keyword']} : '';
        $publishedTime = $this->{$this->seoMap['published_time']} ? $this->{$this->seoMap['published_time']} : '';
        $seo->setTitle($title);
        $seo->setDescription($description);
        $seo->setKeyword($keyword);
        $seo->setPublished($publishedTime);
        return $seo;
    }
}
