<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Menu extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Menu::class;
}
