<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class ProjectCategory extends EloquentRepository
{
    protected $eloquentClass = \App\Models\ProjectCategory::class;
}
