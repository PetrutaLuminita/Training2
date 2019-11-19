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
    Route::get('/get_all_products', 'ProductAdminController@getProducts');
    Route::get('/products', 'ProductAdminController@index')->name('admin.products.index');
    Route::get('/products/create', 'ProductAdminController@edit')->name('admin.products.create');
    Route::post('/products/create', 'ProductAdminController@save')->name('admin.products.save');
    Route::get('/products/{product}/edit', 'ProductAdminController@edit')->name('admin.products.edit');
    Route::put('/products/{product}/edit', 'ProductAdminController@save')->name('admin.products.update');
    Route::get('/products/{product}', 'ProductAdminController@getProductForEdit')->name('admin.products.edit.ajax');
    Route::get('/products/{product}/delete', 'ProductAdminController@destroy')->name('admin.products.delete');
});
