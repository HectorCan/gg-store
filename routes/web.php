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
});
