<?php


namespace App\Traits;

use App\Models\Link;
use App\Models\Model;
use App\Observers\LinkableObserver;
use Illuminate\Support\Str;

trait Linkable
{
    public static function bootLinkable()
    {
        static::observe(app(LinkableObserver::class));
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
     * @param Model|null $parent
     *
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
        $status = $this->status_sl ? $this->status_sl : 'draft';
        return [
            'title_lb' => $this->title_lb,
            'meta_lb' => $this->makeMetaTag(),
            'template_lb' => $this->generateTemplate(),
            'image_lb' => $this->image_lb,
            'status_sl' => $status,
            'type_lb' => $type,
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
}
