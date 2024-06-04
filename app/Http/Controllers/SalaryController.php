<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SalaryHead;
use App\Models\DeleteSalaryheadId;


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
            $head_title = preg_replace('/\s+/', ' ', $req->head_title);
            $head_title = str_replace(' ', '_', $head_title); 
           $salary_head = SalaryHead::create([
               'head_title'        => $head_title,
               'formula'           => $req->formulaOutput,
               'method'            => $req->method
           ]);
           $salary_head_id = $salary_head->id;

        //--------------------------------------------------------
            //dd($req->formulaOutput);
            // $pattern = '/\{([^}]+)\}/';
            // preg_match_all($pattern, $req->formulaOutput, $matches);
            // $keywords = $matches[1];
            // foreach($keywords as $val)
            // {
            //  $head = SalaryHead::where('head_title', $val)->first();
             
            //   $delete_salary_head_data = array(
            //     "salary_head_id" =>   $salary_head_id,
            //     "involve_head_id" => $head->id
            //   );
            //   $salary_head = DeleteSalaryheadId::create($delete_salary_head_data);
             
            // }

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

    public function get_master_head_title(Request $req)
    {
          $term = $req->term; 
          $terms = explode(' ', $term);

          $salaryHeads = SalaryHead::where(function ($query) use ($terms) {
              foreach ($terms as $term) {
                  $query->orWhere('head_title', 'like', '%' . $term . '%');
              }
          })->get();
           return  json_encode($salaryHeads);
        
    }
}
