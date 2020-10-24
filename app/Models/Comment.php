<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Ownable;
use App\Traits\Typeable;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use NodeTrait, Commentable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_lb', 'image_lb','status_sl','creator_id', 'creator_type', 'body_lb', 'review_nb', 'view_nb', 'comment_nb',  'updated_by', 'created_by',
    ];

    /**
     * Determine if a comment has child comments.
     *
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }
    /**
     * Get the commentable entity that the comment belongs to.
     *
     * @return mixed
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
    /**
     * @return mixed
     */
    public function creator(): MorphTo
    {
        return $this->morphTo('creator');
    }
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
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
