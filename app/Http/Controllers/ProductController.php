<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Psr\SimpleCache\InvalidArgumentException;

class ProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = Product::public()
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
     * @return Factory|View
     * @throws InvalidArgumentException
     */
    public function show(string $slug)
    {
//        $post= Post::where('slug_lb', $slug)->published()->firstOrFail();
        $post= Product::getCacheByName($slug);
        $data = [
            'post' => $post,
        ];
        return view('singles.post', $data);
    }

    /**
     * @param ProductCategory $category
     * @return Factory|View
     */
    public function category(ProductCategory $category)
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $category->products()->public()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
            'category' => $category,
        ];
        return view('archives.post')->with($data);
    }

    /**
     * @param Tag $tag
     * @return Factory|View
     */
    public function tag(ProductTag $tag)
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $tag->products()->public()->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
            'tag' => $tag,
        ];
        return view('archives.post')->with($data);
    }
}
