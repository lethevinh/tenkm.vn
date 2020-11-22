<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::get('/home', function () {
    return redirect(\route('home.show'));
});
Route::get('search.html', 'HomeController@search')->name('home.search');
Route::post('contact.html', 'HomeController@doContact')->name('home.doContact');
Route::post('subscribe.html', 'HomeController@doSubscribe')->name('home.doSubscribe');
Route::get('/', 'PageController@home')->name('home.show');
Route::get('lang/{locale}', 'PageController@lang')->name('lang');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile/{user:username}', 'ProfileController@show')->name('user.profile.show');
    Route::put('profile/{user:username}', 'ProfileController@show')->name('user.profile.show');
    Route::get('profile-edit/{user:username}', 'ProfileController@profile')->name('user.profile.update');
    Route::get('profile-report/{user:username}', 'TeacherController@report')->name('teachers.report');
    Route::post('profile-edit/{user:username}', 'ProfileController@doProfile')->name('user.profile.doProfile');
    Route::post('profile-edit-inline/{user:username}', 'ProfileController@doProfileInline')->name('user.profile.doProfileInline');
    Route::put('profile-edit-inline/{user:username}', 'ProfileController@doProfileInline')->name('user.profile.doProfileInline');
    Route::post('profile-edit-password/{user:username}', 'ProfileController@changePassword')->name('user.profile.changePassword');
    Route::post('profile-edit-avatar/{user:username}', 'ProfileController@changeAvatar')->name('user.profile.changeAvatar');
    Route::resource('profile', 'ProfileController')->except([
        'show', 'update', 'destroy'
    ]);
    Route::post('comment/{type}/{post}', 'CommentController@doComment')->name('comment.doComment');

    Route::post('order/{course_id_validated}','PaymentController@order')->name('order.create');
    Route::get('checkout/{order?}', [
        'name' => 'Payment Checkout',
        'as' => 'order.checkout',
        'uses' => 'PaymentController@form',
    ]);
    Route::post('/checkout/{gateway}/{order}/', [
        'name' => 'Payment Checkout',
        'as' => 'checkout.payment',
        'uses' => 'PaymentController@checkout',
    ]);
    Route::get('/payment/{gateway}/{order}/completed', [
        'name' => 'Payment Checkout Completed',
        'as' => 'payment.checkout.completed',
        'uses' => 'PaymentController@completed',
    ]);
    Route::get('/payment/{gateway}/{order}/cancelled', [
        'name' => 'Payment Checkout Cancelled',
        'as' => 'payment.checkout.cancelled',
        'uses' => 'PaymentController@cancelled',
    ]);
    Route::post('/webhook/{gateway}/{order?}/{env?}', [
        'name' => 'Payment IPN',
        'as' => 'webhook.paypal.ipn',
        'uses' => 'PaymentController@webhook',
    ]);
});

Route::get('products.html', 'ProductController@index')->name('product.index');
Route::get('products-cat/{category:slug_lb}.html', 'ProductController@category')->name('product.category');
Route::get('products-tag/{tag:slug_lb}.html', 'ProductController@tag')->name('product.tag');
Route::get('products/{slug}', 'ProductController@show')->name('product.show');

Route::get('projects.html', 'ProjectController@index')->name('project.index');
Route::get('projects-cat/{category:slug_lb}.html', 'ProjectController@category')->name('project.category');
Route::get('projects-tag/{tag:slug_lb}.html', 'ProjectController@tag')->name('project.tag');
Route::get('projects/{slug}', 'ProjectController@show')->name('project.show');

Route::get('blog.html', 'PostController@index')->name('post.index');
Route::get('blog-cat/{category:slug_lb}.html', 'PostController@category')->name('post.category');
Route::get('blog-tag/{tag:slug_lb}.html', 'PostController@tag')->name('post.tag');
Route::get('blog/{slug}', 'PostController@show')->name('post.show');
Route::get('careers/{slug}', 'PostController@career')->name('career.show');
Route::get('/{category}/{post}.html', 'PathController@subPath');

Auth::routes();
Route::get('/auth/redirect/{provider}', 'AuthController@redirect')->name('social.login.redirect');
Route::get('/callback/{provider}', 'AuthController@callback')->name('social.login.callback');

use Intervention\Image\ImageManagerStatic as Image;
Route::get('image/{width}x{height}x{action}_{path}', function ($width, $height, $action, $path) {
    $filePath = public_path('storage/images/' . $path);
    if (file_exists($filePath)) {
        return Image::make($filePath)->resize($width, $height)->response();
    }
    return Image::canvas($width, $height)->response();
})->name('image.single');
Route::get('/lang/{lang}', function ($locale) {
    $folderPath = resource_path('/lang/' . $locale . '/');
    if (!File::exists($folderPath)) {
        return false;
    }
    $filesInFolder = File::files($folderPath);
    $lang = [];
    foreach($filesInFolder as $path) {
        $file = pathinfo($path);
        $filePath = $file['dirname'] . '/' . $file['basename'];
        if (!is_readable($filePath)) {
            continue;
        }
        $lang[$file['filename']] = @require($filePath);
    }
    return response()->json($lang);
});
Route::get('{slug}', 'PageController@show')->name('page.show');
