<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Project extends EloquentRepository
{
    /**
     * @var string
     */
    protected $eloquentClass = \App\Models\Project::class;
}
