<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class PostCategory extends EloquentRepository
{
    protected $eloquentClass = \App\Models\PostCategory::class;
}
