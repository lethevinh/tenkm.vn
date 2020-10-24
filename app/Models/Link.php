<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use Sluggable;

    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'title_lb', 'meta_lb', 'template_lb', 'slug_lb', 'image_lb','status_sl',
        'type_lb', 'description_lb', 'content_lb', 'updated_by', 'created_by'
    ];

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
     * Get the user that owns the phone.
     */
    public function contentable()
    {
        return $this->morphTo('contentable');
    }

    /**
     * @param Model $linkable
     * @param $data
     * @param Model $creator
     *
     * @return static
     */
    public function createLink(Model $linkable, $data)
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
    public function renderContent() {
        $template = $this->template_lb;
        $content = $this->contentable;
        $data = [
          'content' => $content,
           'link' => $this,
            $content->getModelKey() => $content
        ];
        return theme_view($this->contentable->template, $data);
    }

    public function getUrlAttribute() {
        return route('link.show', ['link' => $this]);
    }
}
