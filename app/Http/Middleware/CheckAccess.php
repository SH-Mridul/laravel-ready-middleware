<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\admin\module\ModuleModel;
use App\admin\role\RoleModel;
use App\admin\roleUser\RoleUserModel;
use App\admin\Route\RouteModel;
use App\admin\roleModule\RoleModuleModel;





class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $user_id         = Auth::user()->id;
        $requested_route = Route::getCurrentRoute()->uri();

        if($user_id === 1){
             return $next($request);
        }else{
            $roles   = RoleUserModel::where('user_id',$user_id)->where('is_active',1)->where('soft_delete',0)->pluck('role_id')->toArray();
            $modules = RoleModuleModel::whereIn('role_id',$roles)->where('is_active',1)->where('soft_delete',0)->pluck('module_id')->toArray();
            $route   = RouteModel::select('id')->where('path',$requested_route)->where('is_active',1)->where('soft_delete',0)->whereIn('module_id',$modules)->count();
            

            if ($route >0) {
                 return $next($request);
            }else{
                 return redirect('/');
            }
        }
       
    }
}
