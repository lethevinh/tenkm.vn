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
use Spatie\Searchable\SearchResult;
use AjCastro\Searchable\Searchable;

/**
 * @property mixed title_lb
 */
class Product extends Model
{
    use Sluggable, Orderable, Ownable, Commentable, Cacheable, Categorizable, Taggable, Reactable,
        Locationable, Amenitable, Translatable, Searchable;

    protected $table = 'products';

    protected $fillable = [
        'title_lb', 'slug_lb', 'image_lb', 'status_sl', 'gallery_lb',
        'description_lb', 'content_lb', 'review_nb', 'view_nb', 'comment_nb',
        'price_fl', 'price_sale_fl', 'price_lb',
        'language_lb', 'translation_id','video_lb','property_type','furnishing_status',
        'bedroom_nb', 'bathroom_nb', 'area_nb','floorplan_lb','parking_nb', 'show_in_location',
        'living_room_lb', 'garage_lb', 'dining_area','gym_area','parking_nb', 'end_of_contract',
        'published_at', 'validated_at', 'updated_by', 'created_by',
    ];

    public static $bedrooms = ['2-4','3-4', '1-3', '5-9'];
    public static $bathrooms = ['2-4','3-4', '1-3', '5-9'];
    public function sluggable(): array
    {
        return [
            'slug_lb' => [
                'source' => 'title_lb'
            ]
        ];
    }

    /**
     * Searchable model definitions.
     */
    protected $searchable = [
        'columns' => [
            'products.title_lb',
            'products.slug_lb',
        ],
    ];

    /**
     * Can also be written like this for searchable columns.
     *
     * @var array
     */
    protected $searchableColumns = [
        'title_lb','slug_lb'
    ];

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
            return route( 'product.show', ['slug' => $this->attributes['slug_lb']]);
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

    public function getPropertyTypeLabelAttribute(): string
    {
        if (!isset($this->attributes['property_type']) || empty($this->attributes['property_type'])){
            return '';
        }
        $type = Amenity::find($this->attributes['property_type']);
        if ($type) {
            return $type->title_lb;
        }
        return '';
    }

    public function getFurnishingStatusLabelAttribute(): string
    {
        if (!isset($this->attributes['furnishing_status']) || empty($this->attributes['furnishing_status'])){
            return '';
        }
        $type = Amenity::find($this->attributes['furnishing_status']);
        if ($type) {
            return $type->title_lb;
        }
        return '';
    }

    public function getAddressLabelAttribute(): string
    {

        return $this->address ? $this->address->detail : '';
    }

    public function getPriceAttribute() {
        $priceBase = floatval($this->attributes['price_fl']);
        $priceSale = floatval($this->attributes['price_sale_fl']);
        return $priceSale > 0 ? $priceSale:  $priceBase;
    }

    public function getYoutubeAttribute()
    {
        if (isset($this->attributes['video_lb'])) {
            $url = $this->attributes['video_lb'];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            return $match[1];
        }
        return  '';
    }

    public function getPriceLabelAttribute()
    {
        if (isset($this->attributes['price_lb']) && !empty($priceLabel = $this->attributes['price_lb'])) {
            return $priceLabel;
        }
        $price = $this->getPriceAttribute();
        if ($price === 0) {
            return __('site.price_deal');
        }
        if ($price < 1) {
            return __('site.price_updating');
        }
        $locale = session()->get('locale', config('site.locale_default'));

        return number_format($price, 0) . ' ' . config('site.symbols.' . $locale, '₫');
    }

    public function categoryToTree(): array
    {
        $categories = [];
        $traverse = function ($categories, &$data) use (&$traverse) {
            foreach ($categories as $category) {
                $data[] =  $category;
                $traverse($category->children, $data);
            }
        };
        $traverse($this->categories->toTree(), $categories);
        return $categories;
    }
}
