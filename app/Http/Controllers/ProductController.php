<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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
        $offset = $offset ? $offset : 8;
        $products = Product::public()->locale()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $user = Auth::user();
        return view('archives.product', compact('user', 'products'));
    }

    /**
     * @param string $slug
     * @return Application|RedirectResponse|Redirector
     * @throws InvalidArgumentException
     */
    public function show(string $slug)
    {
//        $post= Post::where('slug_lb', $slug)->published()->firstOrFail();
        $product = Product::getCacheByName($slug);
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $product->translation($locale)) {
            return redirect($translation->link);
        }
        return view('singles.product', compact('product'));
    }

    /**
     * @param ProductCategory $category
     * @return Application|RedirectResponse|Redirector
     */
    public function category(ProductCategory $category)
    {
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $category->translation($locale)) {
            return redirect($translation->link);
        }

        $offset = request()->input('offset');
        $offset = $offset ? $offset : 8;
        $products = $category->products()->public()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $user = Auth::user();
        return view('archives.product', compact('user', 'products', 'category'));
    }

    /**
     * @param ProductTag $tag
     * @return Application|RedirectResponse|Redirector
     */
    public function tag(ProductTag $tag)
    {
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $tag->translation($locale)) {
            return redirect($translation->link);
        }
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 8;
        $posts = $tag->products()->public()->paginate($offset);
        $user = Auth::user();
        return view('archives.product', compact('user', 'posts', 'tag'));
    }
}
