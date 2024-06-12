<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Module;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;

class RolePermissionMiddleware 
{
  
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = auth()->user();
            if(auth()->user()->isAdmin())
            {
                return $next($request); 
            }
            else{
                $name = \Request::route()->getName();
                $modules = Module::where('route_name',$name)->first();
                if ($modules == null) {
                    return Redirect::back()->with('error', 'Permission Module Is Not Registered. Try to Access Again After Register.');
                }
                $role_id = $user->role_id;
                $moduleId = $modules->id;
                $role_permission = RolePermission::where('role_id',$role_id)->where('module_id',$moduleId)->exists();
                if($role_permission){
                    return $next($request);
               }
               // If the user doesn't have the required role or permission, you can return a response or redirect as needed
               return Redirect::back()->with('error', 'You do not have permission to access this page.');
                
            }
          
        } 
    }
}

