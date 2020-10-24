<?php

namespace App\Admin\Repositories;

use App\Models\User as UserModel;
use Dcat\Admin\Repositories\EloquentRepository;

class Feedback extends EloquentRepository
{
    protected $eloquentClass = \App\Models\Feedback::class;
}
