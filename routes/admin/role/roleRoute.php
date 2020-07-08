<?php
Route::group(['middleware' => ['auth', 'CheckAccess']], function () {

    // view route
    Route::get('roleView','admin\role\RoleController@roleView');

    // internal route
    Route::post('roleInsertAjax','admin\role\RoleController@roleInsertAjax');
    Route::post('inactiveRoleAjax', 'admin\role\RoleController@inactiveRoleAjax');
    Route::post('activeRoleAjax','admin\role\RoleController@activeRoleAjax');
    Route::post('getRoleInfoDetailsAjax','admin\role\RoleController@getRoleInfoDetailsAjax');
    Route::post('roleUpdateAjax','admin\role\RoleController@roleUpdateAjax');
    Route::post('roleDeleteAjax','admin\role\RoleController@roleDeleteAjax');

});