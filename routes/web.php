<?php

use App\Http\Livewire\Product\Index;
use App\Http\Livewire\Shop\Cart;
use App\Http\Livewire\Shop\Checkout;
use App\Http\Livewire\Shop\Index as ShopIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::get('/admin', ['middleware' => 'guest', function()
{
    return view('auth.login');
}]);
Route::get("/", "App\Http\Controllers\Client\ClientController@index")->name("client.home");
Route::get("/product", "App\Http\Controllers\Client\ClientController@product")->name("client.product");
Route::get("/product/{id}", "App\Http\Controllers\Client\ClientController@productDetail")->name("client.product_detail");
Route::get("/news", "App\Http\Controllers\Client\ClientController@news")->name("client.news");
Route::get("/news/{id}", "App\Http\Controllers\Client\ClientController@newsDetail")->name("client.news_detail");

Route::group(['middleware' => ['auth', 'route-permission']], function () {
   
    Route::group(['prefix' => 'admin'], function() {
        Route::get("/home", "App\Http\Controllers\Admin\Site\HomeController@index")->name("home");
        Route::get("/product-type", "App\Http\Controllers\Admin\AdminController@productType")->name("admin.product-type");
        Route::get("/product", "App\Http\Controllers\Admin\AdminController@product")->name("admin.product");
        Route::get("/product/create", "App\Http\Controllers\Admin\AdminController@productCreate")->name("admin.product.create");
        Route::get("/product/{id}", "App\Http\Controllers\Admin\AdminController@productEdit")->name("admin.product.edit");
        Route::get("/news", "App\Http\Controllers\Admin\AdminController@news")->name("admin.news.index");
        Route::get("/news/create", "App\Http\Controllers\Admin\AdminController@newsCreate")->name("admin.news.create");
        Route::post("/news/store", "App\Http\Controllers\Admin\AdminController@newsStore")->name("admin.news.store");
        Route::get("/news/{id}", "App\Http\Controllers\Admin\AdminController@newsEdit")->name("admin.news.edit");
        Route::put("/news/{id}", "App\Http\Controllers\Admin\AdminController@newsUpdate")->name("admin.news.update");
        Route::get("/master-data", "App\Http\Controllers\Admin\AdminController@masterData")->name("admin.master-data");
    });

});

