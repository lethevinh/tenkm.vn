<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;

class Contact extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Contact::class;
}
