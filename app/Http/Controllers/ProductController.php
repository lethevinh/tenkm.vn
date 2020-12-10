<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Psr\SimpleCache\InvalidArgumentException;
use Spatie\Searchable\Search;

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
        // $post= Post::where('slug_lb', $slug)->published()->firstOrFail();
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
        $products = $tag->products()->public()->paginate($offset);
        $user = Auth::user();
        return view('archives.product', compact('user', 'products', 'tag'));
    }

    public function search(Request $request) {
        $query = $request->input('s');
        $title = __('site.result_search').$query;
        $locale = session()->get('locale', config('site.locale_default'));
        app('seo')->setTitle($title);
        $products = (new Search())->registerModel(Product::class, 'title_lb')->perform($query);
        $products = $products->map(function ($product){
           return $product->searchable;
        })->where('language_lb', $locale);
        $user = Auth::user();
        return view('archives.product', compact('products', 'query', 'title'));
    }
}
