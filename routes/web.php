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
        Route::get('/', 'App\Http\Controllers\Admin\Site\FilesController@index')->name('admin.files.index');
        Route::get('/edit/{id}', 'App\Http\Controllers\Admin\Site\FilesController@edit')->name('admin.files.edit');
    });
    Route::group(['prefix' => 'profile'], function() {
        Route::get("/", "App\Http\Controllers\Admin\Test\ProfileController@index")->name("admin.profile.index");
    });
    Route::get('/home', [App\Http\Controllers\Admin\Site\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'config'], function() {
        Route::get("/master-data", "App\Http\Controllers\Admin\Test\ConfigController@masterData")->name("admin.config.masterData");
        Route::get('/seo-config', 'App\Http\Controllers\Admin\Test\SEOConfigController@index')->name('admin.config.seoConfig');
        // Route::get('/site-config', 'App\Http\Controllers\Admin\Test\SiteConfigController@index')->name('admin.config.siteConfig');
    });

    Route::group(['prefix' => 'news'], function() {
        Route::get("/", "App\Http\Controllers\Admin\Test\NewsController@index")->name("admin.news.index");
        Route::get("/create", "App\Http\Controllers\Admin\Test\NewsController@create")->name("admin.news.create");
        Route::post("/store", "App\Http\Controllers\Admin\Test\NewsController@store")->name("admin.news.store");
        Route::get("/{id}/edit", "App\Http\Controllers\Admin\Test\NewsController@edit")->name("admin.news.edit");
        Route::put("/{id}", "App\Http\Controllers\Admin\Test\NewsController@update")->name("admin.news.update");
    });

    Route::group(['prefix' => 'faqs'], function() {
        Route::get("/", "App\Http\Controllers\Admin\Test\FaqsController@index")->name("admin.faqs.index");
    });

    // danh sách nhận tự vấn
    Route::get("/advise-list", "App\Http\Controllers\Admin\Test\AdviseController@index")->name("admin.advise.index");
    // câu hỏi khách hàng
    Route::get("/question-of-customer", "App\Http\Controllers\Admin\Test\QuestionOfCustomerController@index")->name("admin.question-of-customer.index");

});

