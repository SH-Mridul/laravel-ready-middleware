<?php

namespace App\Http\Controllers\admin\role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\admin\role\RoleModel;

class RoleController extends Controller
{

    /**
    * Show the  roles view.
    *@method roleView
    * @param  get request
    * @return View all role with all roles
    */

    public function roleView(){
        $roles = RoleModel::where('soft_delete',0)->get();
        $data = [
            'roles' => $roles
        ];

        return view('admin.role.roleView')->with($data);
    }




    /**
     * @name roleInsertAjax
     * @role insert role info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function roleInsertAjax(Request $request)
    {
        $userName = Auth::user()->name;
    

        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'created_by'        => $userName,
            'updated_by'        => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else if (RoleModel::where('name', $request->name)->where('soft_delete', 0)->exists()) {

            return response()->json(array('warning' => "Record Already Exists"));

        } else {
            RoleModel::create($attributeNames);
            return response()->json("Success");
        }
    }





    /**
     * @name inactiveRoleAjax
     * @role role inactive
     * @param Request from array
     * @return json response
     *
     */

    public function inactiveRoleAjax(Request $request){
        $role            = RoleModel::findOrFail($request->id);
        $role->is_active = 0;
        $role->update();
        return response()->json("Success");
    }




    /**
     * @name activeRoleAjax
     * @role role active
     * @param Request from array
     * @return json response
     *
     */
    public function activeRoleAjax(Request $request){
        $role            = RoleModel::findOrFail($request->id);
        $role->is_active = 1;
        $role->update();
        return response()->json("Success");
    }



    /**
    * @name getRoleInfoDetailsAjax
    * @role role info
    * @param Request from array
    * @return json response
    *
    */
    public function getRoleInfoDetailsAjax(Request $request){
        $role = RoleModel::findOrFail($request->id);
        return response()->json($role);
    }




    /**
    * @name roleUpdateAjax
    * @role role info update
    * @param Request from array
    * @return json response
    *
    */


    public function roleUpdateAjax(Request $request){
         $role     =  RoleModel::findOrFail($request->id);
         $userName =  Auth::user()->name;
    

        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'updated_by'        => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required|unique:roles,name,' . $request->id,
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $role->update($attributeNames);
            return response()->json("Success");
        }
    }







    /**
    * @name roleDeleteAjax
    * @role role soft delete
    * @param Request from array
    * @return json response
    *
    */


    public function roleDeleteAjax(Request $request){
         $role                   =  RoleModel::findOrFail($request->id);
         $role->soft_delete     = 1;
         $role->update();
         return response()->json('success');
    }





}
