<?php

namespace App\Observers;

use Dcat\Admin\Admin;
use Dcat\Admin\Models\Administrator;

class OwnableObserver
{
    public function saving($model)
    {
        $admin = Admin::user();
        if (!$admin) {
            $admin = Administrator::first();
        }
        if ($admin) {
            if (is_null($model->created_by)) {
                $model->created_by = $admin->id;
            }
            $model->updated_by = $admin->id;
        }
    }
}
