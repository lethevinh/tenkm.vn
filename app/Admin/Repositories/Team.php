<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Team extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Team::class;
}
