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


Route::group(['namespace' => 'Api'], function () {

    Route::group(['middleware' => 'auth:api'], function () {
        # Admin routes
        Route::group(['prefix' => 'admin', 'middleware' => 'is.admin', 'namespace' => 'Admin'], function () {
            Route::post('/user', ['as' => 'api.admin.user.store', 'uses' => 'UserController@store']);
            Route::get('/user', ['as' => 'api.admin.user.index', 'uses' => 'UserController@index']);
        });

        # Seller routes
        Route::group(['middleware' => 'is.seller'], function () {
            Route::post('/product', ['as' => 'api.product.store', 'uses' => 'ProductController@store']);
        });

        # user routes
        Route::group(['prefix' => 'user'], function () {
            Route::get('/factor', ['as' => 'api.user.factor', 'uses' => 'UserController@factors']);
            Route::get('/factor/{factor}', ['as' => 'api.user.showFactor', 'uses' => 'UserController@showFactor']);
        });


        Route::get('/product', ['as' => 'api.product.index', 'uses' => 'ProductController@index']);
    });


    Route::post('/login', ['as' => 'api.admin.passport.login', 'uses' => 'PassportController@login']);


});
