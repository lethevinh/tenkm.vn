<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Category extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Category::class;
}
