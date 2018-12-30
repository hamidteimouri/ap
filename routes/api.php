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
            # create a user by admin
            Route::post('/user', ['as' => 'api.admin.user.store', 'uses' => 'UserController@store']);
            # get all users and sellers
            Route::get('/user', ['as' => 'api.admin.user.index', 'uses' => 'UserController@index']);
            # get all sellers
            Route::get('/seller', ['as' => 'api.admin.user.seller', 'uses' => 'UserController@seller']);
            # create a store for a seller
            Route::post('/seller/{user}/store', ['as' => 'api.admin.user.createStore', 'uses' => 'UserController@createStoreForSeller']);
        });

        # Seller routes
        Route::group(['middleware' => 'is.seller'], function () {
            # create a new product
            Route::post('/product', ['as' => 'api.product.store', 'uses' => 'ProductController@store']);
        });

        # user routes
        Route::group(['prefix' => 'user'], function () {
            # user's factors
            Route::get('/factor', ['as' => 'api.user.factor', 'uses' => 'UserController@factors']);
            # user's specific factor
            Route::get('/factor/{factor}', ['as' => 'api.user.showFactor', 'uses' => 'UserController@showFactor']);
        });

        # get all products
        Route::get('/product', ['as' => 'api.product.index', 'uses' => 'ProductController@index']);
    });

    # login
    Route::post('/login', ['as' => 'api.admin.passport.login', 'uses' => 'PassportController@login']);


});
