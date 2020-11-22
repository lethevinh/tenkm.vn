<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Career extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Career::class;
}
