<?php

Route::group(['middleware' => ['auth', 'CheckAccess']], function () {
           
            // view route
            Route::get('roleModuleAssignView','admin\roleModule\RoleModuleController@roleModuleAssignView');
            Route::get('assignedModuleView','admin\roleModule\RoleModuleController@assignedModuleView');

            
            // internal route
            Route::post('assignNewRoleModuleInsertAjax','admin\roleModule\RoleModuleController@assignNewRoleModuleInsertAjax');
            Route::post('getRoleModuleById','admin\roleModule\RoleModuleController@getRoleModuleById');
            Route::post('assignedRoleModuleDeleteAjax','admin\roleModule\RoleModuleController@assignedRoleModuleDeleteAjax');
            Route::post('activeAssignedModuleAjax','admin\roleModule\RoleModuleController@activeAssignedModuleAjax');
            Route::post('inactiveAssignedModuleAjax','admin\roleModule\RoleModuleController@inactiveAssignedModuleAjax');

});
