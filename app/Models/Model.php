<?php

namespace App\Models;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model as Base;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;

/**
 * @method static published()
 */

class Model extends Base
{
    const STATUS = ['public' => 'public', 'draft' => 'draft', 'private' => 'private', 'trash' => 'trash'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (method_exists($this, 'onConstruct')){
            $this->onConstruct($attributes);
        }
    }

    public static function getModelKey($remove = '', $default = '')
    {
        if (!empty($remove)) {
            $key = strtolower(str_replace($remove, '', class_basename(static::class)));
            $key = !empty($key) ? $key : $default;
            return $key;
        }
        return strtolower(class_basename(static::class));
    }

    public function generateTemplate() {
        $class = $this->getModelKey();
        $type = $class !== $this->type_lb ? Str::plural($class) . '.' . Str::plural($this->type_lb) : Str::plural($this->type_lb);
        $templates = [];
        $templates[] = $type . '.' . $this->slug;
        $templates[] = $type . '.default';
        if ($class !== $this->type_lb) {
            $templates[] = Str::plural($class) . '.' . $this->type_lb;
            $templates[] = Str::plural($class) . '.default';
        }
        $templates[] = 'pages.default';
        $templates = array_filter($templates, function ($template) {
            return View::exists($template);
        });
        return Arr::first($templates);
    }

    public function scopePublished($query)
    {
        return $query->where('status_sl', 'public');
    }

    public function scopePrivate($query, $status = true)
    {
        $condition = $status ? '<>' : '=';
        return $query->where('status_sl', $condition, 'private');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type_lb', $type);
    }

    public function scopeLang($query, $lang)
    {
        return $query->where('language_lb', $lang);
    }

    public function scopeLocale($query)
    {
        $locale = session()->get('locale', 'vi');
        return $query->where('language_lb', $locale);
    }

    public function scopeValidatedTime($query)
    {
        $dt = Carbon::now();
        return $query->where(function ($query) use ($dt) {
            $query->where('published_at', '<=', $dt->toDateTimeString())
                ->where('validated_at', '>=', $dt->toDateTimeString());
        })->orWhere(function ($query) use ($dt) {
            $query->where('published_at', '<=', $dt->toDateTimeString())
                ->whereNull('validated_at');
        });
        // return $query->where('published_at','<=',$dt->toDateTimeString())->where('validated_at','>=',$dt->toDateTimeString());
    }

    public function scopeValidated($query)
    {
        return $query->published()->validatedTime();
    }

    public function scopePublic($query)
    {
        return $query->validated()->orderByDesc('updated_at');
    }

    public function getThumbnailAttribute() {
        if (!isset($this->attributes['image_lb'])) {
            return '';
        }
        $disk = Storage::disk(config('admin.upload.disk'));
        $image = $this->attributes['image_lb'];
        if (!empty($image) && !URL::isValidUrl($image) && $disk->exists($image)) {
            return $disk->url($image);
        }
        return $image;
    }

    public function next() {
        return static::published()->where('id', $this->id + 1)->first();
    }

    public function prev() {
        return static::published()->where('id', $this->id - 1)->first();
    }
    /**
     * @return Application|UrlGenerator|string
     */
    public function getEditAttribute() {
        $keyModel = self::getModelKey();
        return route(Str::plural($keyModel).'.edit', $this->id);
    }
}
