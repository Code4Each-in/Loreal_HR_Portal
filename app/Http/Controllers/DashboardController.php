<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Models\Module;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $total_emp = User::where('type_id', config('app.EMP_TYPE_ID'))->get();
        $total_emp =  $total_emp->count();
        return view('Dashboard.index', compact('total_emp'));
    }

    public static function permissions()
    {
        $session_type = Session::get('user_session_type');

        if ($session_type == 1) {
            $role_id = 1;
        } else {
            $role_id = auth()->user()->role_id;
        }


        return  $rolePermissions = RolePermission::with('module')->where('role_id', $role_id)->get()->toArray();
    }

    public  function profile_to_admin()
    {
        Session::forget('user_session_type');
        Session::put('user_session_type', 1);
        return redirect()->route('dashboard')->with('success', 'You have change profile  to  admin');
    }

    public function profile_to_emp()
    {
        Session::forget('user_session_type');
        Session::put('user_session_type', 2);
        return redirect()->route('dashboard')->with('success', 'You have change profile  to  Employee');
    }

    public static function  check_type_id()
    {
        $role_id = auth()->user()->type_id;
        return $role_id;
    }
}
