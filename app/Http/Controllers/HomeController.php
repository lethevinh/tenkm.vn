<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Course;
use App\Models\Event;
use App\Models\Page;
use App\Models\Post;
use App\Models\Teacher;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $page = Page::where('slug_lb', 'trang-chu')->published()->firstOrFail();
        return view('pages.home', compact('page'));
    }
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function about()
    {
        $page = Page::where('slug_lb', 'gioi-thieu')->published()->firstOrFail();
        $page->seo();
        $data = [
            'page' => $page
        ];
        return view('pages.about', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function contact()
    {
        $page = Page::where('slug_lb', 'lien-he')->published()->firstOrFail();
        $page->seo();
        return view('pages.contact', [ 'page' => $page]);
    }

    public function doContact(Request $request)
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'message' => ['required', 'string'],
        ]);
        $contact = Contact::create([
            'name_lb' => $request->name,
            'title_lb' => $request->name,
            'email_lb' => $request->email,
            'content_lb' => $request->message,
        ]);
        $message = '';
        if ($contact) {
            $message = __('site.create_contact_success');
        }
        return view('pages.contact', [ 'message' => $message]);
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function show()
    {
        $page = Page::where('slug_lb', 'trang-chu')->published()->firstOrFail();
        $page->seo();
        $teachers = Teacher::where('type_lb', 'teacher')->orderBy('updated_at', 'desc')->limit(10)->with('categories')->get();
        $posts = Post::public()->limit(6)->with(['tags', 'comments', 'creator'])->get();
        $data = [
            'teachers' => $teachers,
            'posts' => $posts,
            'page' => $page
        ];
        return view('pages.home', $data);
    }

    public function search(Request $request) {
        $query = $request->input('s');

        app('seo')->setTitle('Kết quả tìm kiếm của từ khoá '.$query);

        $searchResults = (new Search())
            ->registerModel(Post::class, 'title_lb')
            ->perform($query);
//        dd($searchResults[0]->searchable);
        return view('pages.search', compact(['searchResults', 'query' ]));
    }
}
