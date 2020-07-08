<?php

namespace App\Http\Controllers\admin\roleModule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin\role\RoleModel;
use App\admin\module\ModuleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\admin\roleModule\RoleModuleModel;


class RoleModuleController extends Controller
{
    

    /**
    * Show the assign form view.
    *@method roleModuleAssignView
    * @param get request
    * @return View an assign form
    */

    public function roleModuleAssignView(){
    $roles      = RoleModel::where('is_active',1)->where('soft_delete',0)->get();
    $modules    = ModuleModel::where('is_active',1)->where('soft_delete',0)->get();

    $data = [
        'roles'    => $roles,
        'modules'  => $modules
    ];

        return view('admin.roleModule.roleModuleView')->with($data);

    }




     /**
     * insert role module
     *@method assignNewRoleModuleInsertAjax
     * @param post request
     * @return json response
     */

    public function assignNewRoleModuleInsertAjax(Request $request){
        $userName = Auth::user()->name;
        
        //gettings attributes
        $attributeNames = array(
            'role_id'               => $request->role_id,
            'module_id'             => $request->module_id,
            'created_by'            => $userName,
            'updated_by'            => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'role_id'                    => 'required',
            'module_id'                  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else if (RoleModuleModel::where('role_id', $request->role_id)->where('module_id',$request->module_id)->where('soft_delete', 0)->exists()) {

            return response()->json(array('warning' => "Record Already Exists"));

        } else {
            RoleModuleModel::create($attributeNames);
            return response()->json("Success");
        }
    }



    /**
     * get role module
     *@method getRoleModuleById
     * @param post request
     * @return view with Array
     */


    public function getRoleModuleById(Request $request){
        $modules = RoleModuleModel::where('role_id',$request->id)->where('soft_delete',0)->get();

        $data =[
            'modules' => $modules
        ];
        
         return view('admin.roleModule.ajaxFile.assignedModule')->with($data);
    }





    /**
     * get assigned role modules
     *@method assignedModuleView
     * @param post request
     * @return view with Array
     */

    public function assignedModuleView(){
        $roles = RoleModel::where('soft_delete',0)
                            ->with(['modules' => function($q){
                                $q->where('soft_delete',0);
                            }])->get();

        $data =[
            'roles' => $roles
        ];

        return view('admin.roleModule.assignedModuleView')->with($data);
    }



    /**
     *  assigned role module delete
     *@method assignedRoleModuleDeleteAjax
     * @param post request
     * @return response json
     */

    public function assignedRoleModuleDeleteAjax(Request $request){
        $roleModuleInfo = RoleModuleModel::findOrFail($request->id);
        $roleModuleInfo->soft_delete = 1;
        $roleModuleInfo->update();
        return response()->json('success');    
    }




    /**
     *  assigned role module active
     *@method activeAssignedModuleAjax
     * @param post request
     * @return response json
     */

    public function activeAssignedModuleAjax(Request $request){
        $roleModuleInfo = RoleModuleModel::findOrFail($request->id);
        $roleModuleInfo->is_active = 1;
        $roleModuleInfo->update();
        return response()->json('success'); 
    }   


    



    /**
     *  assigned role module inactive
     *@method inactiveAssignedModuleAjax
     * @param post request
     * @return response json
     */


    public function inactiveAssignedModuleAjax(Request $request){
        $roleModuleInfo = RoleModuleModel::findOrFail($request->id);
        $roleModuleInfo->is_active = 0;
        $roleModuleInfo->update();
        return response()->json('success'); 
    }   




}
