<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class ProductCategory extends EloquentRepository
{
    protected $eloquentClass = \App\Models\ProductCategory::class;
}
