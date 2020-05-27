<?php

namespace App\Admin\Repositories;

use App\Models\User as UserModel;
use Dcat\Admin\Repositories\EloquentRepository;

class User extends EloquentRepository
{
    protected $eloquentClass = UserModel::class;
}
