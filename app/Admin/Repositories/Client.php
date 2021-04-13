<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Client extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Client::class;
}
