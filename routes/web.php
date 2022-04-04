<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::redirect('/home', '/');
Route::get('/privacy-policy', 'HomeController@privacyPolicy');
Route::get('/data-deletion', 'HomeController@dataDeletion');

Route::prefix('/socialite')->name('socialite.')->group(function () {
    Route::get('/google', 'SocialiteGoogleController@redirect')->name('google-redirect');
    Route::get('/google-callback', 'SocialiteGoogleController@callback')->name('google-callback');

    Route::get('/facebook', 'SocialiteFacebookController@redirect')->name('facebook-redirect');
    Route::get('/facebook-callback', 'SocialiteFacebookController@callback')->name('facebook-callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/mail', 'HomeController@mail');

    Route::prefix('/pdv')->name('pdv.')->group(function () {
        Route::get('/', 'PdvController@index')->name('index');
        Route::post('/store', 'PdvController@store')->name('store');
    });

    Route::prefix('/order')->name('order.')->group(function () {
        Route::get('/', 'OrderController@index')->name('index');
        Route::get('/export', 'OrderController@export')->name('export');
        Route::get('/{id}', 'OrderController@show')->name('show');
    });

    Route::post('/product/{id}/stock', 'ProductController@stock')->name('product.stock');
    Route::get('/report', 'ReportController@index')->name('report.index');
    Route::get('/graph', 'GraphController@index')->name('graph.index');

    Route::get('/user/export', 'UserController@export')->name('user.export');
    Route::get('/product/export', 'ProductController@export')->name('product.export');
    Route::get('/category/export', 'CategoryController@export')->name('category.export');
    Route::get('/subcategory/export', 'SubcategoryController@export')->name('subcategory.export');
    Route::get('/chargeback/export', 'ChargebackController@export')->name('chargeback.export');
    Route::get('/client/export', 'ClientController@export')->name('client.export');
    Route::get('/supplier/export', 'SupplierController@export')->name('supplier.export');

    Route::resources([
        'user'        => 'UserController',
        'product'     => 'ProductController',
        'category'    => 'CategoryController',
        'subcategory' => 'SubcategoryController',
        'chargeback'  => 'ChargebackController',
        'client'      => 'ClientController',
        'supplier'    => 'SupplierController',
    ]);

    Route::prefix('api')->group(function () {
        Route::get('/products', 'ApiController@products');
        Route::get('/subcategories', 'ApiController@subcategories');
        Route::get('/autocomplete/{type}', 'ApiController@autocomplete');
        Route::post('/upload', 'ApiController@upload');
    });
});
