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

Route::group(['namespace' => 'Api'], function () {

    Route::post('/admin/user', ['as' => 'api.admin.user.store', 'uses' => 'Admin\UserController@store']);
    Route::get('/admin/user', ['as' => 'api.admin.user.index', 'uses' => 'Admin\UserController@index']);

    Route::get('/product', ['as' => 'api.product.index', 'uses' => 'ProductController@index']);

    Route::post('/login', ['as' => 'api.admin.passport.login', 'uses' => 'PassportController@login']);
});
