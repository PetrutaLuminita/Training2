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

Route::get('/get_products', 'ProductController@getProducts')->name('products.get.products.ajax');
Route::get('/', 'ProductController@index')->name('products.index');
Route::get('/cart', 'ProductController@getCartProducts')->name('products.cart');
Route::get('/cart_checkout', 'ProductController@cartForCheckout')->name('products.cart.checkout');
Route::get('/add_to_cart/{product}', 'ProductController@addToCart')->name('products.add_to_cart');
Route::get('/remove_from_cart/{product}', 'ProductController@removeFromCart')->name('products.remove_from_cart');
Route::post('/cart_checkout', 'ProductController@checkout')->name('checkout');

Route::middleware(['admin'])->group(function() {
    Route::resource('products' ,'ProductAdminController')->except(['show']);
    Route::get('/get_all_products', 'ProductAdminController@getProducts');
    Route::get('/products/{product}', 'ProductAdminController@getProduct')->name('admin.products.edit.ajax');
});
