<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Artisan;
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
        $posts = [];
        $offset = request()->input('offset', 9);
        switch ($page->template_lb){
            case 'career':
                $posts = Career::public()->locale()->paginate($offset);
                break;
            case 'blog':
                $posts = Post::public()->locale()
                    ->with(['categories', 'tags', 'comments.comments', 'creator'])
                    ->paginate($offset);
                break;
        }
        return view()->first(['pages.' . $page->template_lb, 'pages.default'], ['page' => $page, 'posts'=>$posts]);
    }

    /**
     * @return Application|Factory|View
     */
    public function home()
    {
        $page = Page::home();
        $page->seo();
        return $this->render('pages.home', compact('page'));
    }

    public function lang($locale)
    {
        $currentlyLocale = session()->get('locale', config('site.locale_default'));
        if ($locale != $currentlyLocale) {
            app()->setLocale($locale);
            session()->put('locale', $locale);
            Artisan::call('cache:clear');
        }
        return redirect()->back();
    }
}
