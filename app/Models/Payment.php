<?php

namespace App\Models;

use App\Traits\Ownable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use Sluggable, Ownable;

    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'updated_by', 'created_by', 'title_lb', 'slug_lb', 'image_lb','status_sl',
        'description_lb', 'content_lb'
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

    /**
     * @return BelongsTo
     */
    public function updateBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     *
     * @return mixed
     */
    public function getSlugAttribute() {
        return $this->slug_lb;
    }
}
