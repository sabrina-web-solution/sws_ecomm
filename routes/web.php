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
});

Route::group(['middleware'=>'adminAuth'],function(){
	Route::resource('product','ProductController',['except'=>'show']);
	Route::resource('venue','VenueController',['except'=>'show']);
	Route::resource('merchant','MerchantController',['except'=>'show']);
	Route::resource('productbrand','ProductBrandController',['except'=>'show']);
	Route::resource('productcategory','ProductCategoryController',['except'=>'show']);
	Route::resource('productmodifier','ProductModifierController',['except'=>'show']);
	Route::resource('product','ProductController',['except'=>'show']);
});

Route::group(['middleware'=>'userAuth'],function(){
	Route::resource('product','ProductController',['except'=>'show']);
	Route::resource('venue','VenueController',['except'=>'show']);
	Route::resource('merchant','MerchantController',['except'=>'show']);
	Route::resource('productbrand','ProductBrandController',['except'=>'show']);
	Route::resource('productcategory','ProductCategoryController',['except'=>'show']);
	Route::resource('productmodifier','ProductModifierController',['except'=>'show']);
	Route::resource('product','ProductController',['except'=>'show']);
});
