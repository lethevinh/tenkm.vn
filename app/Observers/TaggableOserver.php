<?php

namespace App\Observers;

use App\Models\Model;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class TaggableOserver
{
    public function created(Model $taggableModel) {
        if (!empty($taggableModel->queuedTags) && count($taggableModel->queuedTags) > 0) {
            $taggableModel->attachTags($taggableModel->queuedTags);
            $taggableModel->queuedTags = [];
        }
    }

    public function deleted(Model $deletedModel) {
        $tags = $deletedModel->tags()->get();
        $deletedModel->detachTags($tags);
    }
}
