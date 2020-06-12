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
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $page->translation($locale)) {
            return redirect($translation->link);
        }
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
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $page->translation($locale)) {
            $page = $translation;
        }
        $page->seo();
        return view('pages.home', compact('page'));
    }

    public function lang($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
