<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryHead;

class EmployeeController extends Controller
{
    public function index()
    {
        $all_emp = Employee::all();
        $all_salary_head = SalaryHead::all();
        return view('Employee.all_employee',  compact("all_emp"), compact("all_salary_head"));
    }
}
