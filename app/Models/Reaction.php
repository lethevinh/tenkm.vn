<?php

namespace App\Models;


use Cviebrock\EloquentSluggable\Sluggable;
use Dcat\Admin\Models\Administrator;
use Illuminate\Support\Facades\Auth;

class Reaction extends Model
{
    use Sluggable;
    protected $table = 'reactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'title_lb',  'image_lb','status_sl',  'description_lb', 'content_lb'
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
}
