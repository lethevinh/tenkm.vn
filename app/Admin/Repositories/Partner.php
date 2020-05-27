<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Partner extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Partner::class;
}
