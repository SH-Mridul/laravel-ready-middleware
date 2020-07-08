<?php

namespace App\Http\Controllers\admin\module;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\admin\module\ModuleModel;

class ModuleController extends Controller
{
        /**
    * Show the  modules view.
    *@method moduleView
    * @param  get request
    * @return View all module with all modules
    */

    public function moduleView(){
        $modules = ModuleModel::where('soft_delete',0)->get();
        $data = [
            'modules' => $modules
        ];

        return view('admin.module.moduleView')->with($data);
    }




    /**
     * @name moduleInsertAjax
     * @role insert module info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function moduleInsertAjax(Request $request)
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
        } else if (ModuleModel::where('name', $request->name)->where('soft_delete', 0)->exists()) {

            return response()->json(array('warning' => "Record Already Exists"));

        } else {
            ModuleModel::create($attributeNames);
            return response()->json("Success");
        }
    }





    /**
     * @name inactiveModuleAjax
     * @role module inactive
     * @param Request from array
     * @return json response
     *
     */

    public function inactiveModuleAjax(Request $request){
        $module            = ModuleModel::findOrFail($request->id);
        $module->is_active = 0;
        $module->update();
        return response()->json("Success");
    }




    /**
     * @name activeModuleAjax
     * @role module active
     * @param Request from array
     * @return json response
     *
     */
    public function activeModuleAjax(Request $request){
        $module            = ModuleModel::findOrFail($request->id);
        $module->is_active = 1;
        $module->update();
        return response()->json("Success");
    }



    /**
    * @name getModuleInfoDetailsAjax
    * @role module info
    * @param Request from array
    * @return json response
    *
    */
    public function getModuleInfoDetailsAjax(Request $request){
        $module = ModuleModel::findOrFail($request->id);
        return response()->json($module);
    }




    /**
    * @name moduleUpdateAjax
    * @role module info update
    * @param Request from array
    * @return json response
    *
    */


    public function moduleUpdateAjax(Request $request){
         $module     =  ModuleModel::findOrFail($request->id);
         $userName   =  Auth::user()->name;
    

        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'updated_by'        => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required|unique:modules,name,' . $request->id,
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $module->update($attributeNames);
            return response()->json("Success");
        }
    }







    /**
    * @name moduleDeleteAjax
    * @role module soft delete
    * @param Request from array
    * @return json response
    *
    */


    public function moduleDeleteAjax(Request $request){
         $module                   =  ModuleModel::findOrFail($request->id);
         $module->soft_delete      = 1;
         $module->update();
         return response()->json('success');
    }


}
