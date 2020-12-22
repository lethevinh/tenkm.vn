<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Address extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Address::class;
}
