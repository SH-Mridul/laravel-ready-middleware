<?php

Route::group(['middleware' => ['auth', 'CheckAccess']], function () {

    // view route
    Route::get('moduleView','admin\module\ModuleController@moduleView');

    // internal route
    Route::post('moduleInsertAjax','admin\module\ModuleController@moduleInsertAjax');
    Route::post('inactiveModuleAjax', 'admin\module\ModuleController@inactiveModuleAjax');
    Route::post('activeModuleAjax','admin\module\ModuleController@activeModuleAjax');
    Route::post('getModuleInfoDetailsAjax','admin\module\ModuleController@getModuleInfoDetailsAjax');
    Route::post('moduleUpdateAjax','admin\module\ModuleController@moduleUpdateAjax');
    Route::post('moduleDeleteAjax','admin\module\ModuleController@moduleDeleteAjax');

});