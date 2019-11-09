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
Route::post('register', 'api\UserController@register');
Route::get('user/{id}', 'api\UserController@getUser');
Route::get('user', 'api\UserController@index');
Route::put('user/{id}', 'api\UserController@update');
Route::post('reset-password', 'api\ResetPasswordController@sendMail');
Route::put('reset-password/{token}', 'api\ResetPasswordController@reset');
Route::post('shop/{id}', 'api\UserController@createShop');

// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('details', 'api\UserController@details');
// });
// Route::get('user-products-sell/{user}', 'api\UserController@getShop');


Route::get('product','api\ProductController@index');
Route::get('product/{id}','api\ProductController@show');
Route::post('product','api\ProductController@store');
Route::put('product/{id}','api\ProductController@update');
Route::delete('product/{id}', 'api\ProductController@delete');
Route::get('products-by-type/{type}', 'api\ProductController@getByType');
Route::get('products-by-category/{category}', 'api\ProductController@getByCategory');
Route::get('products-by-shop/{shop}', 'api\ProductController@getByShop');

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
Route::get('types-by-category/{category}', 'api\TypeController@getByCategory');


Route::get('images/{product}', 'api\ImageController@getImages');
Route::post('images/{product}', 'api\ImageController@store');
Route::post('images-update/{id}', 'api\ImageController@update');
Route::delete('images/{id}', 'api\ImageController@delete');

//
Route::get('order/{user}', 'api\OrderController@getOrder');
Route::post('order','api\OrderController@store');
Route::delete('order/{id}', 'api\OrderController@delete');
Route::get('order-detail/{order}','api\OrderController@getDetailOrder');

Route::get('histories/{user}','api\HistoryController@getHistory');
Route::post('histories','api\HistoryController@store');
