<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Course extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Course::class;
}
