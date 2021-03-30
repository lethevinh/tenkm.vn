<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        $offset = request()->input('offset', 8);
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

        $offset = request()->input('offset', 8);
        $products = $category->products()->lang($category->language_lb)->public();
        if (Str::contains(request()->path(), 'nha-dat-cho-thue')  || Str::contains(request()->path(), 'properties-for-sell')){
            $products = Product::where('end_of_contract', 1)->lang($locale)->public();
        }
        $products = $products->with(['categories', 'tags', 'comments.comments', 'creator'])->paginate($offset);
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
        $string = $request->input('s','');
        $offset = request()->input('offset', 8);
        $title = __('site.result_search').$string;
        $locale = session()->get('locale', config('site.locale_default'));
        app('seo')->setTitle($title);

        $query = Product::where('language_lb', $locale)->public();

        if(($bedroom = $request->input('bedroom', -1)) >= 0) {
            $min = explode('-', Product::$bedrooms[$bedroom])[0];
            $max = explode('-', Product::$bedrooms[$bedroom])[1];
            $query = $query->where('bedroom_nb', '>', $min)->where('bedroom_nb', '<', $max);
        }

        if(($bathroom = $request->input('bathroom', -1)) >= 0) {
            $min = explode('-', Product::$bathrooms[$bathroom])[0];
            $max = explode('-', Product::$bathrooms[$bathroom])[1];
            $query = $query->where('bathroom_nb', '>', $min)->where('bedroom_nb', '<', $max);
        }

        if($minArea = $request->input('mi_size','')) {
            $query = $query->where('area_nb','>', floatval($minArea));
        }
        if($maxArea = $request->input('ma_size','')) {
            $query = $query->where('area_nb','<', floatval($maxArea));
        }
        if($minPrice = $request->input('mi_price','')) {
            $minPrice = floatval($minPrice);
            $query = $query->where('price_fl','>', floatval($minPrice));
        }
        if($maxPrice = $request->input('ma_price','')) {
            $maxPrice = floatval($maxPrice);
            $query = $query->where('price_fl','<', $maxPrice);
        }
        if($string) {
            $query = $query->search($string);
        }
        if($category = $request->input('cat','')) {
            $query = $query->withAndWhereHas('categories', function($query) use ($category) {
                $query->where('category_id', $category);
            });
        }
        if($ward = $request->input('ward','')) {
            $query = $query->withAndWhereHas('address', function($query) use ($ward) {
                $query->where('ward_id', $ward);
            });
        }
        if($type = $request->input('property_type','')) {
            $query = $query->where('property_type', $type);
        }
        $products = $query->paginate($offset);
        $categories = ProductCategory::where('language_lb', $locale)->get();
        $parentCategories = $categories->whereNull('parent_id');
        $types = Amenity::ofType('property_type')->lang($locale)->get();
        $wards = Address::whereNotNull('ward_id')
            ->where('show_form_search', 1)
            ->whereNull('street_id')
            ->with('ward')->get()
            ->map(function($address){
                return $address->ward;
            })->unique('id');
        $category = Category::find($request->input('cat'));
        $option = [
            'minPrice' => 0,
            'maxPrice' => 100000000,
            'minArea' => 0,
            'maxArea' => 500,
        ];
        if($category && Str::contains(Str::slug($category->title_lb), 'ban')){
            $option['minPrice'] = 500000000;
            $option['maxPrice'] = 50000000000;
        }
        if($locale == 'en'){
            $option['minPrice'] = 0;
            $option['maxPrice'] = 5000;
            if($category && Str::contains(Str::slug($category->title_lb), 'sell')){
                $option['minPrice'] = 20000;
                $option['maxPrice'] = 20000000;
            }
        }

        return view('pages.search', compact(
            'products', 'query', 'title', 'categories','parentCategories', 'types', 'wards', 'option')
        );
    }
}
