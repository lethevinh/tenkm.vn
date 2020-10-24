<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return auth()->guard('sanctum')->user();
});
// Course Api
Route::post('/login', "UserController@loginApi");

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user/profile', function () {
        // Uses first & second Middleware
    });
    Route::get('/logout', "UserController@logoutApi");
});
