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

Route::get('/login', 'LoginController@show')->name('show.login');
Route::post('/login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::get('/', 'ProductController@index')->name('product.index');
Route::get('/cart', 'ProductController@cart')->name('product.cart');
Route::get('/get_products', 'ProductController@getProducts')->name('product.get.products.ajax');
Route::get('/get_cart', 'ProductController@getCart')->name('product.get.cart');
Route::get('/add_to_cart/{product}', 'ProductController@addToCart')->name('product.add_to_cart');
Route::get('/remove_from_cart/{product}', 'ProductController@removeFromCart')->name('product.remove_from_cart');
Route::post('/cart_checkout', 'ProductController@checkout')->name('checkout');

Route::middleware(['admin'])->group(function() {
    Route::resource('products' ,'ProductAdminController')->except(['show']);
    Route::get('/get_all_products', 'ProductAdminController@getProducts');
    Route::get('/products/{product}', 'ProductAdminController@getProduct')->name('admin.products.edit.ajax');
});
