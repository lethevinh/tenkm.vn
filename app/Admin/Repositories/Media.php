<?php

namespace App\Admin\Repositories;

use App\Models\User as UserModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Media extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Media::class;
}
