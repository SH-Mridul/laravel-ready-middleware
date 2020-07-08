<?php

namespace App\Http\Controllers\admin\route;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\admin\route\RouteModel;
use App\admin\module\ModuleModel;

class RouteController extends Controller
{
     /**
    * Show the  route view.
    *@method routeView
    * @param  get request
    * @return View all route with all routes
    */

    public function routeView(){
        $routes   = RouteModel::where('soft_delete',0)->get();
        $modules  = ModuleModel::where('is_active',1)->where('soft_delete',0)->get();
        $data = [
            'routes'    => $routes,
            'modules'   => $modules 
        ];

        return view('admin.route.routeView')->with($data);
    }


     /**
     * @name routeInsertAjax
     * @role insert route info into  database
     * @param Request from array
     * @return json response
     *
     */

    public function routeInsertAjax(Request $request)
    {
        $userName = Auth::user()->name;
    

        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'path'              => $request->path,
            'type'              => $request->type,
            'module_id'         => $request->module_id,
            'created_by'        => $userName,
            'updated_by'        => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'path'                  => 'required',
            'type'                  => 'required',
            'module_id'             => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else if (RouteModel::where('path', $request->path)->where('soft_delete', 0)->exists()) {

            return response()->json(array('warning' => "Record Already Exists"));

        } else {
            RouteModel::create($attributeNames);
            return response()->json("Success");
        }
    }



    /**
     * @name activeRouteAjax
     * @role route active
     * @param Request from array
     * @return json response
     *
     */
    public function activeRouteAjax(Request $request){
        $route            = RouteModel::findOrFail($request->id);
        $route->is_active = 1;
        $route->update();
        return response()->json("Success");
    }



    /**
     * @name inactiveRouteAjax
     * @role route inactive
     * @param Request from array
     * @return json response
     *
     */

    public function inactiveRouteAjax(Request $request){
        $route            = RouteModel::findOrFail($request->id);
        $route->is_active = 0;
        $route->update();
        return response()->json("Success");
    }




     /**
    * @name routeDeleteAjax
    * @role route soft delete
    * @param Request from array
    * @return json response
    *
    */


    public function routeDeleteAjax(Request $request){
         $route                   =  RouteModel::findOrFail($request->id);
         $route->soft_delete      = 1;
         $route->update();
         return response()->json('success');
    }



     /**
    * @name getRouteByModule
    * @role route get by category
    * @param Request from array
    * @return json response
    *
    */
    public function getRouteByModule(Request $request){
        $module_id = $request->id;
        $routes    = RouteModel::where('module_id',$module_id)->where('soft_delete',0)->get();

        $data = [
            'routes' => $routes
        ];

        return view('admin.route.ajaxFile.routeAjax')->with($data);
    }



     /**
    * @name getRouteInfoDetailsAjax
    * @role route info get by id
    * @param Request from array
    * @return json response
    *
    */
    public function getRouteInfoDetailsAjax(Request $request){
        $route  = RouteModel::findOrFail($request->id);
        return response()->json($route);
    }




    /**
     * @name routeUpdateAjax
     * @role insert route info  update into  database
     * @param Request from array
     * @return json response
     *
     */

    public function routeUpdateAjax(Request $request)
    {
        $routeInfo  = RouteModel::findOrFail($request->id);
        $userName   = Auth::user()->name;
    

        //gettings attributes
        $attributeNames = array(
            'name'              => $request->name,
            'path'              => $request->path,
            'type'              => $request->type,
            'module_id'         => $request->module_id,
            'updated_by'        => $userName
        );


        //validating the attributes
        $validator = Validator::make($attributeNames, [
            'name'                  => 'required',
            'path'                  => 'required|unique:routes,path,' . $request->id,
            'type'                  => 'required',
            'module_id'             => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $routeInfo->update($attributeNames);
            return response()->json("Success");
        }
    }
    

}
