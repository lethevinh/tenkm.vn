<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Link extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Link::class;
}
