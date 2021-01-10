<?php


namespace App\Traits;

use App\Models\Address;
use App\Models\Link;
use App\Models\Model;
use App\Models\Page;
use App\Observers\LinkableObserver;
use Illuminate\Support\Str;
use function Symfony\Component\String\s;

trait Linkable
{
    public static function bootLinkable()
    {
        if (self::class !== Address::class){
           // static::observe(app(LinkableObserver::class));
        }
    }

    /**
     * Get the link the model.
     */
    public function link()
    {
        return $this->morphOne(Link::class, 'contentable');
    }

    public function makeLink($data = [])
    {
        if (empty($data)) {
            $data = $this->convertAttributeLink();
        }
        return (new Link())->createLink($this, $data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateLink($id, $data)
    {
        return (new Link())->updateLink($id, $data);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteLink($id)
    {
        return Link::find($id)->delete();
    }

    public function convertAttributeLink() {
        $class = Str::slug(class_basename(get_class($this)));
        $type = $class === $this->type_lb ? $this->type_lb : $class . '_' . $this->type_lb;
        $language = $this->language_lb ? $this->language_lb : config('site.locale_default');
        $translation_id = NULL;
        $status = $this->status_sl ? $this->status_sl : 'public';
        $template = $this->generateTemplate();
        $title = $this->title_lb;
        switch (self::class) {
            case Address::class:
                $title = $this->address_lb;
                $status = 'public';
                break;
            case Page::class:
                $template = 'page';
                break;
        }
        return [
            'title_lb' => $title,
            'meta_lb' => $this->makeMetaTag(),
            'template_lb' => $template,
            'image_lb' => $this->image_lb,
            'status_sl' => $status,
            'type_lb' => $type,
            'language_lb' => $language,
            'translation_id' => $translation_id,
            'description_lb' => $this->description_lb,
            'content_lb' => $this->content_lb,
            'updated_by' => $this->updated_by,
            'created_by' => $this->created_by
        ];
    }

    public function makeMetaTag() {
        return json_encode([
            'title' => "",
            'keyword' => "",
            'description' => "",
        ]);
    }

    public function getPublicUrlAttribute() {
      return url($this->link()->first()->slug_lb. '.html');
    }
}
