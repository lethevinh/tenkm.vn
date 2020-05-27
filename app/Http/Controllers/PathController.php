<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Model;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

class PathController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param $link
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function path($link)
    {
        $link = Link::where('slug_lb', $link)->first();
        if (empty($link)) {
           return theme_view();
        }
        return $link->renderContent();
    }

    /**
     * @param Link $link
     * @return mixed
     */
    public function link(Link $link)
    {
        return $link->renderContent();
    }

    /**
     * Show the application dashboard.
     *
     * @param $slugCategory
     * @param $slugPost
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function subPath($slugCategory, $slugPost)
    {
        $post = Post::where('slug_lb', $slugPost)->first();
        $category = Category::where('slug_lb', $slugCategory)->first();
        if (empty($category)) {
            $category = Tag::where('slug_lb', $slugCategory)->first();
        }
        return view('pages.home');
    }

    public function renderPage($page)
    {
        return view('pages.home');
    }

    public function renderPost(Model $post)
    {
        $class = Str::plural($post->getModelKey());
        $type = $post->type_lb;
        $templates = [];
        $templates[] = $class . '.' . Str::plural($type) . '.' . $post->slug;
        $templates[] = $class . '.' . Str::plural($type) . '.default';
        $templates[] = $class . '.' . $type;
        $templates[] = $class . '.default';
        $data = [];
        return theme_view($templates, $data);
    }

    public function renderCategory($category)
    {
        $type = Str::slug(class_basename(get_class($category))) . '-' . $category->type_lb;
        $template = 'pages.home';
        return view($template);
    }

    public function renderTag($tag)
    {
        $type = Str::slug(class_basename(get_class($tag))) . '-' . $tag->type_lb;
        $template = 'pages.home';
        return view($template);
    }
}
