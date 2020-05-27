<?php

namespace App\Observers;


class LinkableObserver
{
    public function created($model)
    {
        if ($model->link()->get()->isEmpty()) {
           $model->makeLink();
        }
    }
}
