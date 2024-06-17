<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Models\Module;
Use Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $total_emp = User::where('type_id', 2)->get();
        $total_emp =  $total_emp->count();
        return view('Dashboard.index', compact('total_emp'));
    
    }

    public static function permissions()
    {
        $role_id = auth()->user()->role_id;
        return  $rolePermissions = RolePermission::with('module')->where('role_id', $role_id)->get()->toArray();
    }

}
