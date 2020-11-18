<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;
use App\Models\User;
use App\Models\Location;
Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');

    $router->any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');
    $router->get('/', 'HomeController@index');
    $router->resource('users', 'UserController');
    $router->resource('posts', 'PostController');
    $router->resource('products', 'ProductController');
    $router->resource('projects', 'ProjectController');
    $router->resource('pages', 'PageController');
    $router->resource('partners', 'PartnerController');
    $router->resource('events', 'EventController');
    $router->resource('menus', 'MenuController');
    $router->resource('amenities', 'AmenityController');
    $router->get('site/setting', 'PageController@getSetting')->name('site.setting');
    $router->put('site/setting', 'PageController@putSetting');
    $router->resource('contacts', 'ContactController');
    $router->resource('feedbacks', 'FeedbackController');

    $router->get('media-popup', 'MediaController@popup')->name('media-popup');
    $router->get('media', 'MediaController@folder')->name('media-index');
    $router->get('media/download', 'MediaController@download')->name('media-download');
    $router->delete('media/delete', 'MediaController@delete')->name('media-delete');
    $router->put('media/move', 'MediaController@move')->name('media-move');
    $router->post('media/upload', 'MediaController@upload')->name('media-upload');
    $router->post('media/metadata-upload', 'MediaController@metadataUpload')->name('media-metadata-upload');
    $router->post('media/folder', 'MediaController@newFolder')->name('media-new-folder');

    $router->get('categories/{type}', 'CategoryController@index');
    $router->get('categories/{type}/create', 'CategoryController@create');
    $router->post('categories/{type}', 'CategoryController@storePost');
    $router->get('categories/{type}/{id}', 'CategoryController@showPost');
    $router->get('categories/{type}/{id}/edit', 'CategoryController@editPost');
    $router->post('categories/{type}/{id}', 'CategoryController@updatePost');
    $router->put('categories/{type}/{id}', 'CategoryController@updatePost');
    $router->delete('categories/{type}/{id}', 'CategoryController@destroyPost');

    /*$router->get('posts_t/{type}', 'PostTypeController@index');
    $router->get('posts_t/{type}/create', 'PostTypeController@create');
    $router->post('posts_t/{type}', 'PostTypeController@storePost');
    $router->get('posts_t/{type}/{id}', 'PostTypeController@showPost');
    $router->get('posts_t/{type}/{id}/edit', 'PostTypeController@editPost');
    $router->post('posts_t/{type}/{id}', 'PostTypeController@updatePost');
    $router->put('posts_t/{type}/{id}', 'PostTypeController@updatePost');
    $router->delete('posts_t/{type}/{id}', 'PostTypeController@destroyPost');
*/
    $router->get('/api/users', function (){
        $q = request()->get('q');
        return User::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    });
    $router->get('metadata-inline/{model}/{id}', function ($model, $id) {
        if (empty(Admin::user())) {
            response()->json('');
        }
        $classModel = 'App\\Models\\'.ucfirst($model);
        $field = request()->input('name');
        $value = request()->input('value');
        if (class_exists($classModel) && $field && $value) {
            $obj = $classModel::find($id);
            if ($obj) {
                $obj->setAttribute(request()->name, request()->value);
                $obj->save();
            }
        }
    });
    $router->post('metadata-inline/{model}/{id}', function ($model, $id) {
        if (empty(Admin::user())) {
            response()->json('');
        }
        $classModel = 'App\\Models\\'.ucfirst($model);
        $field = request()->input('name');
        $value = request()->input('value');
        if (class_exists($classModel) && $field && $value) {
            $obj = $classModel::find($id);
            if ($obj) {
                $obj->setAttribute(request()->name, request()->value);
                $obj->save();
            }
        }
    });
    $router->put('metadata-inline/{model}/{id}', function ($model, $id) {
        if (empty(Admin::user())) {
            response()->json('');
        }
        $classModel = 'App\\Models\\'.ucfirst($model);
        $field = request()->input('name');
        $value = request()->input('value');
        if (class_exists($classModel) && $field && $value) {
            $obj = $classModel::find($id);
            if ($obj) {
                $obj->setAttribute(request()->name, request()->value);
                $obj->save();
            }
        }
    });
    $router->get('/api/locations', function (){
        $q = request()->get('q');
        return Location::where('parent_id', $q)
            ->where('type_lb', '<>', 'project')
            ->where('type_lb', '<>', 'street')
            ->get(['id', DB::raw("CONCAT(prefix_lb,' ', title_lb) as text")]);
    });
    $router->get('/api/locations/street', function (){
        $q = request()->get('q');
        return Location::where('parent_id', $q)
            ->where('type_lb', 'street')
            ->get(['id', DB::raw("CONCAT(prefix_lb,' ', title_lb) as text")]);
    });
});
