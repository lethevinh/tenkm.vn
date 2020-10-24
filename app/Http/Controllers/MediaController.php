<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = Post::orderBy('updated_at', 'desc')->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
        ];
        return view('archives.post')->with($data);
    }


    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Media $file)
    {
        $data = [
            'file' => $file,
        ];
        return view('singles.post', $data);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Category $category)
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $category->posts()->orderBy('updated_at', 'desc')->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
            'category' => $category,
        ];
        return view('archives.post')->with($data);
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag(Tag $tag)
    {
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 9;
        $posts = $tag->posts()->orderBy('updated_at', 'desc')->paginate($offset);
        $data = [
            'user' => Auth::user(),
            'posts' => $posts,
            'tag' => $tag,
        ];
        return view('archives.post')->with($data);
    }
}
