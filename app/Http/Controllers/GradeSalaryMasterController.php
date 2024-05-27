<?php

namespace App\Http\Controllers;
use App\Models\BasicGrade;
use App\Models\SalaryHead;

use Illuminate\Http\Request;
use App\Models\GradeWiseSalaryMaster;


class GradeSalaryMasterController extends Controller
{
    public function index()
    {
        $all_grades  = BasicGrade::all();
        $all_master_head = SalaryHead::all();
        // dd($all_grades);
        return view('GradeSalaryMaster.basicgrade', compact("all_grades"), compact("all_master_head"));
    }

    public function store(Request $req)
    {
        $method = $req->method;

        if ($method == "wid_formula") {
            $validated = $req->validate([
                'head_title' => 'required|unique:grade_wise_salary_masters',
                'formulaOutput' => 'required',
                'grade' => 'required'
            ]);

            $salary_head = GradeWiseSalaryMaster::create([
                'head_title' => $req->head_title,
                'formula' => $req->formulaOutput,
                'method' => $req->method,
                'grade' => $req->grade
            ]);
        } else {
            $validated = $req->validate([
                'head_title' => 'required|unique:grade_wise_salary_masters',
                'amount' => 'required',
                'grade' => 'required'
            ]);

            $salary_head = GradeWiseSalaryMaster::create([
                'head_title' => $req->head_title,
                'formula' => '',
                'amount' => $req->amount,
                'method' => $req->method,
                'grade' => $req->grade
            ]);
        }

        return redirect()->route('allsalaryHead')->with('message', 'Salary Head added successfully!');
    }

}
