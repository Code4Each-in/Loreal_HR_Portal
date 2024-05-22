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
               'formula'           => $req->formulaOutput,
               'method'            => $req->method
           ]);
      
          }
        else{

           $salary_head = SalaryHead::create([
               'head_title'        => $req->head_title,
               'formula'           => '',
               'amount'            =>$req->amount,
               'method'            => $req->method
         
           ]);
        }

        return redirect()->route('allsalaryHead')
        ->with('message', 'Salary Head added successfully!');    
    }

    public  function allsalaryHead()
    {

         $allsalHead = SalaryHead :: all();
         return view('Salary.allsalaryHead', compact("allsalHead"));
    }

    public function edit_salary_head($id)
    {
        $SalaryHead = SalaryHead::find($id);
        return view('Salary.update_salaryHead', compact("SalaryHead"));

    }

    public function update_salary_head(Request $req, $id)
    { 
     
        $validated = $req->validate([
            'head_title' => 'required|unique:salary_heads'
        ]);
   
          $method = $req->method;
          if($method ==  "wid_formula")
          {
            $sal_head_data = array(
                "head_title" => $req-> head_title,
                "formula"  => $req-> formulaOutput,
                "amount" => $req-> amount,
    
              );
            $affectedRows = SalaryHead::where("id", $id)->update($sal_head_data);
        
            }
          else{
            $sal_head_data = array(
                "head_title" => $req-> head_title,
                "formula"  => '',
                "amount" => $req-> amount,
    
              );
            $affectedRows = SalaryHead::where("id", $id)->update($sal_head_data);
          }
          return redirect()->route('allsalaryHead')
          ->with('message', 'Salary Head Update successfully!'); 
        

    }

    public function delete_sal_head(Request $req)
    {
        $id = $req->sal_head_id;
        $delete = SalaryHead::find($id)->delete();

        return redirect()->back()->with('message', 'Head Title Deleted Successfully');
    }
}
