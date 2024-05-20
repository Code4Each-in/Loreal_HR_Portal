<?php

namespace App\Http\Controllers;
use App\Models\SalaryHead;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        return view('salary_head');
    }
     
    public function store(Request $req)
    {
         ///  dd($req->percentage);
        // $validated = $req->validate([
        //     'head_title' => 'required|max:255',
        //     'formula' => 'required',
        // ]);
        $method = $req->method;
        if($method ==  "wid_formula")
        {
            $com =  $req->salary_component ;
            $symbol =  $req->symbol ;
            $percentage =  $req->percentage;
   
   
            $formula = "($com $symbol $percentage) / 100";
            //print_r($formula);
           // dd($req->percentage);
           $product = SalaryHead::create([
               'head_title'        => $req->head_title,
               'salary_component'  => $req->salary_component,
               'symbol'            => $req->symbol,
               'percentage'       => $req->percentage,
               'formula'           => $formula
           ]);
           return redirect()->route('salaryHead')
           ->with('message', 'Salary Head added successfully!');     
          }
        else{

        $product = SalaryHead::create([
               'head_title'        => $req->head_title,
               'salary_component'  => "",
               'symbol'            => "",
               'amount'            =>$req->amount,
               'formula'           => ""
           ]);
        }
    


    }
}
