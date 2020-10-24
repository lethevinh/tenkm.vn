<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Post extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Post::class;
}
