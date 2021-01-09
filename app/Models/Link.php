<?php

namespace App\Models;

use App\Traits\Ownable;
use App\Traits\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @property mixed template_lb
 */
class Link extends Model
{
    use Sluggable, Ownable, Translatable;

    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title_lb', 'meta_lb', 'template_lb', 'slug_lb', 'image_lb','status_sl',
        'language_lb', 'translation_id',
        'type_lb', 'description_lb', 'content_lb', 'updated_by', 'created_by'
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
     * Get the user that owns the phone.
     */
    public function contentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('contentable');
    }

    /**
     * @param Model $linkable
     * @param $data
     * @return static
     */
    public function createLink(Model $linkable, $data): Link
    {
        $link = new static();
        $link->fill($data);
        $linkable->link()->save($link);
        return $link;
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateLink($id, $data)
    {
        $link = static::find($id);
        $link->update($data);
        return $link;
    }

    /**
     * @return mixed
     */
    public function renderContent()
    {
        $template = $this->template_lb;
        $content = $this->contentable;
        $locale = session()->get('locale', config('site.locale_default'));
        $data = [
            'content' => $content,
            'link' => $this
        ];
        $offset = request()->input('offset', 8);
        if ($translation = $this->translation($locale)) {
            return redirect($translation->link);
        }
        switch ($this->contentable_type){
            case ProductCategory::class:
                $data['products'] = $content->products()->public()->locale()
                ->with(['categories', 'tags', 'comments.comments', 'creator'])
                ->paginate($offset);
                $data['category'] = $content;
                break;
            case Page::class:
                $data['page'] = $content;
                $template = $content->template_lb ? $content->template_lb : $template;
                break;
            case Address::class:
                switch ($this->template_lb) {
                    case 'location':
                    case 'location_product':
                        $data['products'] = $content->wards()
                            ->with(['products', 'products.categories', 'products.tags', 'products.comments.comments', 'products.creator'])
                            ->paginate($offset);
                        $data['address'] = $content;
                        break;
                    case 'location_project';
                        $data['projects'] = $content->wards()
                            ->with(['projects', 'projects.categories', 'projects.tags', 'projects.comments.comments', 'projects.creator'])
                            ->paginate($offset);
                        $data['address'] = $content;
                        break;
                }
                break;
            case ProjectCategory::class:
                $data['projects'] = $content->projects()->public()->locale()
                    ->with(['categories', 'tags', 'comments.comments', 'creator'])
                    ->paginate($offset);
                $data['category'] = $content;
                break;
        }
        return view()->first(['pages.'.$template, 'pages.default'], $data);
    }

    public function getLinkAttribute(): string
    {
        return route('link.show', ['slug' => $this->slug_lb]);
    }
}
