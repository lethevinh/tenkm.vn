<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Contact extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'title_lb', 'slug_lb', 'content_lb', 'name_lb', 'email_lb', 'status_sl'
    ];

    public $translatable = ['title_lb', 'slug_lb'];
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
