<?php

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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', function () {
    return redirect('/');
});

Route::group(['middleware' => 'auth'],function () {
    Route::namespace('Inventory')->group(function () {
        Route::prefix('articles')->group(function () {
            Route::get('/', 'ArticleController@index')->name('inv.art.index');

            Route::post('/', 'ArticleController@store')->name('inv.art.store');
        });
    });

    Route::group(['namespace' => 'Maintenance', 'prefix' => 'Maintenance'], function () {
      Route::group(['namespace' => 'User', 'prefix' => 'User'], function () {
          Route::prefix('Permission')->group(function () {
              Route::get('/', 'PermissionController@index')->name('maint.u.permission.index');

              Route::post('/dt', 'PermissionController@dt')->name('maint.u.permission.dt');
              Route::post('/', 'PermissionController@store')->name('maint.u.permission.store');
              Route::get('/get', 'PermissionController@get')->name('maint.u.permission.get');
              Route::put('/', 'PermissionController@update')->name('maint.u.permission.update');
              Route::delete('/', 'PermissionController@delete')->name('maint.u.permission.delete');
          });
      });
    });
});
