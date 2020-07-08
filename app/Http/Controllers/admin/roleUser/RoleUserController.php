<?php

namespace App\Http\Controllers\admin\roleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\role\RoleModel;
use App\User;
use App\admin\roleUser\RoleUserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    /**
    * Show the role user view.
    *@method roleUserView
    * @param get request
    * @return View all role and user 
    */

    public function roleUserView(){
        $roles             = RoleModel::where('is_active',1)->where('soft_delete',0)->get();
        $users             = User::where('id','!=',1)->get();

        $data = [
            'roles'             => $roles,
            'users'             => $users,
        ];

        return view('admin.roleUser.roleUserView')->with($data);
    }




    /**
    * Show all role of user
    *@method assignedRoleView
    * @param get request
    * @return View all user with role 
    */

    public function assignedRoleView(){
        $users             = User::where('id','!=',1)
                                  ->with(['roles' => function($q){ $q->where('soft_delete',0);  }])
                                  ->get();
        $data = [
            'users'             => $users,
        ];
        return view('admin.roleUser.assignedRoleView')->with($data);
    }





    



    /**
    * assign user new role 
    *@method userNewRoleAssignInsertAjax
    * @param get request
    * @return View all role and user
    */

    public function userNewRoleAssignInsertAjax(Request $request){

        $userName = Auth::user()->name;
        
        //gettings attributes
        $attributeNames = array(
            'role_id'           => $request->role_id,
            'user_id'           => $request->user_id,
            'created_by'        => $userName,
            'updated_by'        => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'role_id'                  => 'required',
            'user_id'                  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else if (RoleUserModel::where('role_id', $request->role_id)->where('user_id',$request->user_id)->where('soft_delete', 0)->exists()) {

            return response()->json(array('warning' => "Record Already Exists"));

        } else {
            RoleUserModel::create($attributeNames);
            return response()->json("Success");
        }

    }





    /**
    * get user Assigned role 
    *@method getUserById
    * @param post request
    * @return View all assigned role 
    */

    public function getUserRoleById(Request $request){
        $assignedRole = RoleUserModel::where('user_id',$request->id)->where('soft_delete',0)->get();
        $data = [
            'assignedRole' => $assignedRole
        ];

        return view('admin.roleUser.ajaxFile.assignedRole')->with($data);
    }



    /**
    * active assignsed user role
    *@method activeAssignedRoleAjax
    * @param post request
    * @return json alert
    */

    public function activeAssignedRoleAjax(Request $request){
        $assigndRoleInfo                = RoleUserModel::findOrFail($request->id);
        $assigndRoleInfo->is_active     = 1;
        $assigndRoleInfo->update();
        return response()->json('success');
    }



    /**
    * inactive assignsed user role
    *@method inactiveAssignedRoleAjax
    * @param post request
    * @return json alert
    */

    public function inactiveAssignedRoleAjax(Request $request){
        $assigndRoleInfo                = RoleUserModel::findOrFail($request->id);
        $assigndRoleInfo->is_active     = 0;
        $assigndRoleInfo->update();
        return response()->json('success');
    }




        /**
    * delete assignsed user role
    *@method assignedUserRoleDeleteAjax
    * @param post request
    * @return json alert
    */

    public function assignedUserRoleDeleteAjax(Request $request){
        $assigndRoleInfo                  = RoleUserModel::findOrFail($request->id);
        $assigndRoleInfo->soft_delete     = 1;
        $assigndRoleInfo->update();
        return response()->json('success');
    }




}
