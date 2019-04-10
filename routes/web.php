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

Route::get('/', function () {
    return view('website.welcome');
});

Route::get('welcomme', function () {
    return view('website.welcome');
});

Route::group(['namespace'=>'User'], function(){
	Route::get('cart','CartController@getCartDetails')->name('cart');
	Route::post('addCart','CartController@addCart');
	Route::post('addWishlist','CartController@addWishlist');
	Route::post('addLikedProduct','CartController@addLikedProduct');
	Route::get('order','OrderController@getOrderDetails');
	Route::post('addOrder','OrderController@addOrder');
	Route::post('cancelOrder','OrderController@cancelOrder');
	Route::post('returnOrder','OrderController@returnOrder');
});

Route::get('getProductDetails','EcommController@getProductDetails');
Route::get('getOfferDetails','EcommController@getOfferDetails');
Route::get('getPrice','EcommController@getPrice');
Route::get('getVenueMerchantDetails','EcommController@getVenueMerchantDetails');
