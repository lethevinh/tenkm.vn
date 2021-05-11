<?php

namespace App\Models;

use App\Traits\Ownable;
use App\Traits\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;

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
        $offset = request()->input('offset', 12);
        if ($translation = $this->translation($locale)) {
            return redirect($translation->link);
        }
        switch ($this->contentable_type){
            case ProductCategory::class:
                $data['products'] = $content->products()->public()->locale()
                ->where('end_of_contract','<>', 0)
                ->with(['categories', 'tags', 'comments.comments', 'creator'])
                ->paginate($offset);
                $data['category'] = $content;
                break;
            case Page::class:
                $data['page'] = $content;
                $template = $content->template_lb ? $content->template_lb : $template;
                switch ($template){
                    case 'products_rented':
                        $data['products'] = Product::public()->locale()
                            ->where('end_of_contract', 0)
                            ->with(['categories', 'tags', 'comments.comments', 'creator'])
                            ->whereHas('categories', function ($query){
                                $query->whereIn('category_id', [81, 82]);
                            })
                            ->orderBy('created_at', 'desc')
                            ->paginate($offset);
                        $data['user'] = Auth::user();
                        break;
                    case 'blog':
                        $data['posts'] = Post::public()->locale()
                            ->notReport()
                            ->with(['categories', 'tags', 'comments.comments', 'creator'])
                            ->orderBy('created_at', 'desc')
                            ->paginate($offset);
                        $data['user'] = Auth::user();
                        break;
                }
                break;
            case Address::class:
                switch ($this->template_lb) {
                    case 'location':
                    case 'location_product':
                        $q = $content->wards();
                        if ($content->ward_id){
                            $q = $content->productsInWard()
                                ->with([
                                    'product' => function ($query) use ($locale) {
                                        $query->where('language_lb', $locale)
                                            ->where('end_of_contract', 1)
                                            ->where('status_sl', 'public');
                                    },
                                    'product.categories' => function ($query) use ($locale) {
                                        $query->whereIn('category_id', [81, 82]);
                                    }
                                ])
                                ->whereHas('product.categories', function ($query) use ($locale) {
                                    $query->whereIn('category_id', [81, 82]);
                                });
                        }elseif ($content->district_id){
                            $q = $content->districts();
                            $data['children'] = $content->districts()
                                ->has('productsInWard')
                                ->with([
                                    'productsInWard',
                                    'productsInWard.product' => function($query) use($locale){
                                        $query->where('language_lb', $locale)
                                            ->where('end_of_contract', 1)
                                            ->where('status_sl', 'public');
                                    },
                                    'productsInWard.product.categories' => function($query) use($locale){
                                        $query->whereIn('category_id', [81, 82]);
                                    },
                                    'link' => function($query) use($locale){
                                        $query->where('language_lb', $locale);
                                    }
                                ])
                                ->whereHas('productsInWard.product.categories', function ($query) use ($locale) {
                                    $query->whereIn('category_id', [81, 82]);
                                })
                                ->whereHas('productsInWard.product', function ($query) use ($locale) {
                                    $query->where('language_lb', $locale)
                                        ->where('end_of_contract', 1)
                                        ->where('status_sl', 'public');
                                })
                                ->whereNull('street_id')
                                ->whereNotNull('ward_id')
                                ->where('show_in_parrent', 1)
                                ->get();
                            //dd($data['children'][0]->link->toArray());
                            $template = 'location_district_product';
                        }
                        $data['products'] = $q
                            ->has('products')
                            ->with(['products'=>function($query) use($locale){
                                $query->where('language_lb', $locale)
                                    ->where('end_of_contract', 1)
                                    ->where('status_sl', 'public');
                            }, 'products.categories', 'products.tags', 'products.comments.comments', 'products.creator'])
                            ->paginate($offset);
                        $data['address'] = $content;
                        break;
                    case 'location_project';
                        $data['projects'] = $content->districts()
                            ->has('projects')
                            ->with(['projects' => function($query) use($locale){
                                $query->where('language_lb', $locale)->where('status_sl', 'public');
                            }, 'projects.categories', 'projects.tags', 'projects.comments.comments', 'projects.creator'])
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
            case PostCategory::class:
                $data['posts'] = $content->posts()->public()->locale()
                    ->with(['categories', 'tags', 'comments.comments', 'creator'])
                    ->paginate($offset);
                $data['category'] = $content;
                $template = 'category_post';
                break;
        }
        return view()->first(['pages.'.$template, 'pages.default'], $data);
    }

    public function getLinkAttribute(): string
    {
        return route('link.show', ['slug' => $this->slug_lb]);
    }
}
