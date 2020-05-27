<?php

namespace App\Observers;

use App\Models\Model;
use Illuminate\Support\Str;

class TypeableObserver
{
    public function saving($model)
    {
        if (empty($model->type_lb)) {
            $keyModel = $model->getModelKey();
            $keyModel = str_replace('tag', '', $keyModel);
            $keyModel = str_replace('category', '', $keyModel);
            $keyModel = !empty($keyModel) ? $keyModel : 'post';
            $model->type_lb = $keyModel;
        }
    }
}
