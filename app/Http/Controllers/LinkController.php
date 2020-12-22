<?php

namespace App\Http\Controllers;

use App\Models\Link;

class LinkController extends Controller
{
    public function path($slug = '')
    {
        $link = Link::where('slug_lb', $slug)->with('contentable')->first();
       return $link->renderContent();
    }
}
