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
Route::get('/', ['middleware' => 'guest', function()
{
    return view('auth.login');
}]);
Route::group(['middleware' => ['auth', 'route-permission']], function () {

    Route::prefix('user')->group(function (){
        Route::get('/', 'App\Http\Controllers\Admin\Test\UserController@index')->name('admin.user.index');
    });
    Route::group(['prefix' => 'profile'], function() {
        Route::get("/", "App\Http\Controllers\Admin\Test\ProfileController@index")->name("admin.profile.index");
    });
    Route::group(['prefix' => 'files'], function() {
        Route::get('/', 'App\Http\Controllers\Admin\Site\FilesController@index')->name('files.index');
        Route::get('/edit/{id}', 'App\Http\Controllers\Admin\Site\FilesController@edit')->name('files.edit');
    });
    Route::group(['prefix' => 'profile'], function() {
        Route::get("/", "App\Http\Controllers\Admin\Test\ProfileController@index")->name("admin.profile.index");
    });
    Route::get('/home', [App\Http\Controllers\Admin\Site\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'config'], function() {
        Route::get("/master-data", "App\Http\Controllers\Admin\Test\ConfigController@masterData")->name("admin.config.masterData");
    });

    Route::group(['prefix' => 'news'], function() {
        Route::get("/", "App\Http\Controllers\Admin\Test\NewsController@index")->name("admin.news.index");
        Route::get("/create", "App\Http\Controllers\Admin\Test\NewsController@create")->name("admin.news.create");
        Route::post("/store", "App\Http\Controllers\Admin\Test\NewsController@store")->name("admin.news.store");

        Route::get("/{id}/edit", "App\Http\Controllers\Admin\Test\NewsController@edit")->name("admin.news.edit");
        Route::put("/{id}", "App\Http\Controllers\Admin\Test\NewsController@update")->name("admin.news.update");
    });
});

