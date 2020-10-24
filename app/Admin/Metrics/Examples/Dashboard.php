<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Controllers\Dashboard as Base;
use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;

class Dashboard extends Base
{
    public static function title()
    {
        return view('admin.dashboard');
    }
}
