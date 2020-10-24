<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Amenity extends Model
{
    use Sluggable;

    protected $table = 'amenities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_lb', 'description_lb', 'slug_lb', 'type_lb'
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
}
