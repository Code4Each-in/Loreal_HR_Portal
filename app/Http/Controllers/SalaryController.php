<?php

namespace App\Http\Controllers;
use App\Models\SalaryHead;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        return view('Salary.salary_head');
    }
     
    public function store(Request $req)
    {
         
        $validated = $req->validate([
            'head_title' => 'required|unique:salary_heads'
        ]);
        $method = $req->method;
        if($method ==  "wid_formula")
        {
           $salary_head = SalaryHead::create([
               'head_title'        => $req->head_title,
               'formula'           => $req->formulaOutput
           ]);
      
          }
        else{

           $salary_head = SalaryHead::create([
               'head_title'        => $req->head_title,
               'formula'           => '',
               'amount'            =>$req->amount,
         
           ]);
        }

        return redirect()->route('salaryHead')
        ->with('message', 'Salary Head added successfully!');    
    }

    public  function allsalaryHead()
    {
        return view('Salary.allsalaryHead');
    }
}
