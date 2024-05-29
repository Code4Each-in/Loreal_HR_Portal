<?php

namespace App\Http\Controllers;
use App\Models\SalaryHead;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
       $all_master_head  = SalaryHead::all();
        return view('Salary.salary_head', compact("all_master_head"));
    }
     
    public function store(Request $req)
    {
       
       
       
        $method = $req->method;
        if($method ==  "wid_formula")
        {
            $validated = $req->validate([
            'head_title' => 'required|unique:salary_heads',
            'formulaOutput' => 'required',

            ]);
            $head_title = str_replace(' ', '_', $req->head_title);
           $salary_head = SalaryHead::create([
               'head_title'        => $head_title,
               'formula'           => $req->formulaOutput,
               'method'            => $req->method
           ]);
      
          }
        else{
            
            $validated = $req->validate([
                'head_title' => 'required|unique:salary_heads',
                'amount' => 'required',
    
                ]);
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
        $all_master_head  = SalaryHead::all();
        $SalaryHead = SalaryHead::find($id);
        return view('Salary.update_salaryHead', compact("SalaryHead"), compact("all_master_head"));

    }

    public function update_salary_head(Request $req, $id)
    { 
     
        $validated = $req->validate([
            'head_title' => 'required'
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
