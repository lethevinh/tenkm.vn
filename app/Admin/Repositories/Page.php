<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Page extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Page::class;
}
