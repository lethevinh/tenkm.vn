<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Lang extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Lang::class;
}
