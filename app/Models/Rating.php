<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class Rating extends Model
{
    use Sluggable;
    /**
     * @var string
     */
    protected $table = 'ratings';
    /**
     * @var array
     */
    protected $fillable = ['rating', 'ratingable_id' , 'ratingable_type' ,'creator_id', 'creator_type',];

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
     * @return MorphTo
     */
    public function ratingable()
    {
        return $this->morphTo();
    }
    /**
     * @return MorphTo
     */
    public function creator()
    {
        return $this->morphTo('creator');
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $user = Auth::user();
            if (!$user) {
                $user = Administrator::first();
            }
            if ($user) {
                $model->creator_id = $user->getAuthIdentifier();
                $model->creator_type = $user->getMorphClass();
            }
        });
    }
}
