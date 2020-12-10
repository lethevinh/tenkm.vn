<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectTag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Psr\SimpleCache\InvalidArgumentException;
use Spatie\Searchable\Search;

class ProjectController extends Controller
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
        $projects = Project::public()->locale()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $user =  Auth::user();
        return view('archives.project', compact('user', 'projects'));
    }

    /**
     * @param string $slug
     * @return Application|RedirectResponse|Redirector
     * @throws InvalidArgumentException
     */
    public function show(string $slug)
    {
//        $project = Project::where('slug_lb', $slug)->published()->firstOrFail();
        $project = Project::getCacheByName($slug);
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $project->translation($locale)) {
            return redirect($translation->link);
        }
        return view('singles.project', compact('project'));
    }

    /**
     * @param ProjectCategory $category
     * @return Application|RedirectResponse|Redirector
     */
    public function category(ProjectCategory $category)
    {
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $category->translation($locale)) {
            return redirect($translation->link);
        }

        $offset = request()->input('offset');
        $offset = $offset ? $offset : 8;
        $projects = $category->projects()->public()
            ->with(['categories', 'tags', 'comments.comments', 'creator'])
            ->paginate($offset);
        $user = Auth::user();
        return view('archives.project', compact('user', 'projects', 'category'));
    }

    /**
     * @param ProjectTag $tag
     * @return Application|RedirectResponse|Redirector
     */
    public function tag(ProjectTag $tag)
    {
        $locale = session()->get('locale', config('site.locale_default'));
        if ($translation = $tag->translation($locale)) {
            return redirect($translation->link);
        }
        $offset = request()->input('offset');
        $offset = $offset ? $offset : 8;
        $posts = $tag->projects()->public()->paginate($offset);
        $user = Auth::user();
        return view('archives.project', compact('user', 'posts', 'tag'));
    }

    public function search(Request $request) {
        $query = $request->input('s');
        $title = __('site.result_search').$query;
        app('seo')->setTitle($title);
        $products = (new Search())->registerModel(Project::class, 'title_lb')->perform($query);
        $products = $products->map(function ($project){
            return $project->searchable;
        });
        $user = Auth::user();
        return view('archives.product', compact('products', 'query', 'title'));
    }
}
