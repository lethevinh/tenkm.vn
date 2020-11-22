<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

class PostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $offset = request()->input('offset', 9);
        $posts = Post::public()->locale()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
        ];
        return view('archives.post')->with($data);
    }

    /**
     * @param string $slug
     * @return Application|RedirectResponse|Redirector
     * @throws InvalidArgumentException
     */
    public function show(string $slug)
    {
        $post= Post::getCacheByName($slug);
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $post->translation($locale)) {
           return redirect($translation->link);
        }
        return view('singles.post', compact('post'));
    }

    /**
     * @param string $slug
     * @return Application|RedirectResponse|Redirector
     * @throws InvalidArgumentException
     */
    public function career(string $slug)
    {
        $post= Career::getCacheByName($slug);
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $post->translation($locale)) {
           return redirect($translation->link);
        }
        return view('singles.post', compact('post'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|RedirectResponse|Redirector|View
     */
    public function category(Category $category)
    {
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $category->translation($locale)) {
            return redirect($translation->link);
        }

        $offset = request()->input('offset', 9);
        $posts = $category->posts()->public()->locale()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $user = Auth::user();
        return view('archives.post', compact('user', 'posts', 'category'));
    }

    /**
     * @param Tag $tag
     * @return Application|RedirectResponse|Redirector
     */
    public function tag(Tag $tag)
    {
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $tag->translation($locale)) {
            return redirect($translation->link);
        }
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $tag->posts()->public()->locale()->paginate($offset);
        $user =  Auth::user();
        return view('archives.post', compact('user', 'posts', 'tag'));
    }
}
