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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => ['auth', 'CheckAccess']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});


// external route file path
include('admin/role/roleRoute.php');
include('admin/module/moduleRoute.php');
include('admin/route/routeRoute.php');
include('admin/roleUser/roleUserRoute.php');
include('admin/roleModule/roleModuleRoute.php');




