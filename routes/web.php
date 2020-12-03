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
      Route::group(['namespace' => 'User', 'prefix' => 'User Maintenance'], function () {
          Route::prefix('Permission')->group(function () {
              Route::get('/', 'PermissionController@index')->name('maint.u.permission.index');
              Route::post('/dt', 'PermissionController@dt')->name('maint.u.permission.dt');
              Route::post('/', 'PermissionController@store')->name('maint.u.permission.store');
              Route::get('/get', 'PermissionController@get')->name('maint.u.permission.get');
              Route::put('/', 'PermissionController@update')->name('maint.u.permission.update');
              Route::delete('/', 'PermissionController@delete')->name('maint.u.permission.delete');
          });

          Route::prefix('Role')->group(function () {
              Route::get('/', 'RoleController@index')->name('maint.u.role.index');
              Route::post('/dt', 'RoleController@dt')->name('maint.u.role.dt');
              Route::post('/', 'RoleController@store')->name('maint.u.role.store');
              Route::get('/get', 'RoleController@get')->name('maint.u.role.get');
              Route::put('/', 'RoleController@update')->name('maint.u.role.update');
              Route::delete('/', 'RoleController@delete')->name('maint.u.role.delete');
          });

          Route::prefix('User')->group(function () {
              Route::get('/', 'UserController@index')->name('maint.u.user.index');
              Route::post('/dt', 'UserController@dt')->name('maint.u.user.dt');
              Route::post('/', 'UserController@store')->name('maint.u.user.store');
              Route::get('/get', 'UserController@get')->name('maint.u.user.get');
              Route::put('/', 'UserController@update')->name('maint.u.user.update');
              Route::delete('/', 'UserController@delete')->name('maint.u.user.delete');
          });
      });
    });
});
