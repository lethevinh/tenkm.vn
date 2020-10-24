<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Product extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Product::class;
}
