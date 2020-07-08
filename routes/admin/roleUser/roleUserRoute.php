<?php
Route::group(['middleware' => ['auth', 'CheckAccess']], function () {

        // view route
        Route::get('roleUserView','admin\roleUser\RoleUserController@roleUserView');
        Route::get('assignedRoleView','admin\roleUser\RoleUserController@assignedRoleView');


        // internal route
        Route::post('userNewRoleAssignInsertAjax','admin\roleUser\RoleUserController@userNewRoleAssignInsertAjax');
        Route::post('getUserRoleById','admin\roleUser\RoleUserController@getUserRoleById');
        Route::post('activeAssignedRoleAjax','admin\roleUser\RoleUserController@activeAssignedRoleAjax');
        Route::post('inactiveAssignedRoleAjax','admin\roleUser\RoleUserController@inactiveAssignedRoleAjax');
        Route::post('assignedUserRoleDeleteAjax','admin\roleUser\RoleUserController@assignedUserRoleDeleteAjax');
        
});