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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'api\UserController@login');
Route::get('user/{id}', 'api\UserController@getUser');
Route::get('user', 'api\UserController@index');
Route::post('register', 'api\UserController@register');
Route::post('reset-password', 'api\ResetPasswordController@sendMail');
Route::put('reset-password/{token}', 'api\ResetPasswordController@reset');
Route::put('shop/{id}', 'api\UserController@createShop');
Route::put('user/{id}', 'api\UserController@update');

// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('details', 'api\UserController@details');
// });
// Route::get('user-products-sell/{user}', 'api\UserController@getShop');


Route::get('product','api\ProductController@index');
Route::get('product/{id}','api\ProductController@show');
Route::post('product','api\ProductController@store');
Route::put('product/{id}','api\ProductController@update');
Route::delete('product/{id}', 'api\ProductController@delete');


Route::get('categories', 'api\CategoryController@index');
Route::get('categories/{id}', 'api\CategoryController@show');
Route::post('categories', 'api\CategoryController@store');
Route::put('categories/{id}', 'api\CategoryController@update');
Route::delete('categories/{id}', 'api\CategoryController@delete');

Route::get('types', 'api\TypeController@index');
Route::get('types/{id}', 'api\TypeController@show');
Route::post('types', 'api\TypeController@store');
Route::put('types/{id}', 'api\TypeController@update');
Route::delete('types/{id}', 'api\TypeController@delete');

Route::get('types-category/{category}', 'api\TypeController@getTypeByCategory');

// Route::get('images/{id}', 'api\ImageController@getImages');


