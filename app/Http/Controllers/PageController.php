<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

class PageController extends Controller
{
    /**
     * @param string $slug
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function show(string $slug)
    {
        $page = Page::getCacheByName($slug);
        $page->seo();
        return view()->first(['pages.' . $page->template_lb, 'pages.default'], ['page' => $page]);
    }

    /**
     * @return Application|Factory|View
     * @throws InvalidArgumentException
     */
    public function home()
    {
        $page = Page::getCacheById(Page::site()->home_id);
        $page->seo();
        return view('pages.home', compact('page'));
    }
}
