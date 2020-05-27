<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
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
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = Post::public()
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
        $post= Post::getCacheByName($slug);
        $data = [
            'post' => $post,
        ];
        return view('singles.post', $data);
    }

    /**
     * @param Category $category
     * @return Factory|View
     */
    public function category(Category $category)
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $category->posts()->public()
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
    public function tag(Tag $tag)
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $tag->posts()->public()->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
            'tag' => $tag,
        ];
        return view('archives.post')->with($data);
    }
}
