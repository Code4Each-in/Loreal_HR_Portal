<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Models\Module;
Use Session;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    
    }

    public static function permissions()
    {
        $role_id = auth()->user()->role_id;
        return  $rolePermissions = RolePermission::with('module')->where('role_id', $role_id)->get()->toArray();;
  
  
        
      
    }

}
