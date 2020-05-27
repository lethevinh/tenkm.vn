<?php


namespace App\Traits;

use App\Models\Comment;
use App\Models\Model;
use Dcat\Admin\Admin;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Auth;

trait Commentable
{
    /**
     * The name of the comments model.
     *
     * @return string
     */
    public function commentableModel(): string
    {
        return Comment::class;
    }

    /**
     * The comments attached to the model.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany($this->commentableModel(), 'commentable');
    }

    /**
     * The comments attached to the model.
     *
     * @return MorphMany
     */
    public function publicComments(): MorphMany
    {
        return $this->comments()->where('status_sl', 'public');
    }

    /**
     * Create a comment.
     *
     * @param array $data
     * @return BaseModel
     */
    public function comment(array $data)
    {
        return $this->comments()->firstOrCreate($data);
    }

    /**
     * Update a comment.
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateComment($id, $data)
    {
        return $this->comments()->first($id)->update($data);
    }

    /**
     * Delete a comment.
     *
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function deleteComment(int $id): bool
    {
        $this->comments()->find($id)->delete();
    }
    /**
     * The amount of comments assigned to this model.
     *
     * @return mixed
     */
    public function commentCount(): int
    {
        return $this->comments->count();
    }

    public static function bootCommentable() {
        static::deleted(function ($model) {
            $model->comments()->delete();
        });
    }
}
