<?php
Route::group(['middleware' => ['auth', 'CheckAccess']], function () {

    // view route
    Route::get('routeView','admin\route\RouteController@routeView');


    // internal route
    Route::post('routeInsertAjax','admin\route\RouteController@routeInsertAjax');
    Route::post('inactiveRouteAjax', 'admin\route\RouteController@inactiveRouteAjax');
    Route::post('activeRouteAjax','admin\route\RouteController@activeRouteAjax');
    Route::post('getRouteByModule','admin\route\RouteController@getRouteByModule');
    Route::post('getRouteInfoDetailsAjax','admin\route\RouteController@getRouteInfoDetailsAjax');
    Route::post('routeUpdateAjax','admin\route\RouteController@routeUpdateAjax');
    Route::post('routeDeleteAjax','admin\route\RouteController@routeDeleteAjax');
    

});