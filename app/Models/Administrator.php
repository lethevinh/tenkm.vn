<?php

namespace App\Models;

use \Dcat\Admin\Models\Administrator as Base;

class Administrator extends Base
{
    protected $fillable = ['username', 'password', 'name', 'avatar', 'address', 'phone' , 'email'];
}
