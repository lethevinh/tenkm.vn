<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Amenity extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Amenity::class;
}
