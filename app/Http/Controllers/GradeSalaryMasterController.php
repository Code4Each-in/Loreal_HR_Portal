<?php

namespace App\Http\Controllers;
use App\Models\BasicGrade;
use App\Models\SalaryHead;
use Illuminate\Http\Request;
use App\Models\GradeWiseSalaryMaster;
use App\Models\DeleteSalaryheadId;
use Illuminate\Support\Facades\DB;



class GradeSalaryMasterController extends Controller
{
    public function index()
    {
        $all_grades  = BasicGrade::all();
        $all_master_head = SalaryHead::all();
        // dd($all_grades);
        return view('GradeSalaryMaster.basicgrade', compact("all_grades"), compact("all_master_head"));
    }

    public function store_grade(Request $req)
    {
        $method = $req->method;

        if ($method == "wid_formula") {
            $validated = $req->validate([
                'head_title' => 'required|unique:grade_wise_salary_masters,head_title,'.$req->id.',id,deleted_at,NULL',
                'formulaOutput' => 'required',
                'grade' => 'required'
            ]);
        
            // Create a new salary head with formula
            $head_title = preg_replace('/\s+/', ' ', $req->head_title);
            $head_title = str_replace(' ', '_', $head_title); 
            $salary_head = GradeWiseSalaryMaster::create([
                'head_title' =>  $head_title,
                'formula' => $req->formulaOutput,
                'method' => $req->method,
                'grade' => $req->grade
            ]);
         
            //-------------------------------------------------------
            $salary_head_id = $salary_head->id;
            $pattern = '/\{([^}]+)\}/';
            preg_match_all($pattern, $req->formulaOutput, $matches);
            $keywords = $matches[1];

            foreach($keywords as $val){
             
               $head = GradeWiseSalaryMaster::where('head_title', $val)->where('deleted_at', '=', NULL)->get();
              if(!empty($head[0]->id)){
                $delete_salary_head_data = array(
                  "salary_head_id" =>   $salary_head_id,
                  "involve_head_id" => $head[0]->id,
                  "type" => "2"
                );
                $salary_head = DeleteSalaryheadId::create($delete_salary_head_data);
              }
            }
            //------------------------------------------------------=
        } else {
            $validated = $req->validate([
                'head_title' => 'required|unique:grade_wise_salary_masters,head_title,NULL,id,deleted_at,NULL',
                'amount' => 'required',
                'grade' => 'required'
            ]);
            // Create a new salary head with fixed amount
            $head_title = str_replace(' ', '_', $req->head_title); 
            $salary_head = GradeWiseSalaryMaster::create([
                'head_title' => $head_title,
                'formula' => '',
                'amount' => $req->amount,
                'method' => $req->method,
                'grade' => $req->grade
            ]);
        }
        return redirect()->route('allBasicGradeSalary')->with('message', 'Basic Grade Salary Master Added Successfully!');
    }
    // Display all basic grade salary masters
    public  function allBasicGradeSalary()
    {
        $allbasicgradesal = GradeWiseSalaryMaster::with('grade')->get()->toArray();
        //dump($allbasicgradesal); dd();
        return view('GradeSalaryMaster.allbasicgradesalarymaster', compact("allbasicgradesal"));
    }

    // Display the form to edit basic grade salary master
    public function edit_basic_salary($id)
    {
        $all_grades  = BasicGrade::all();
        $all_basic_salary = GradeWiseSalaryMaster::all();
        $basic_salary = GradeWiseSalaryMaster::find($id);
        return view('GradeSalaryMaster.update_basicGradeSalary', compact('basic_salary', 'all_basic_salary', 'all_grades'));
    }

    // Update basic grade salary master
    public function update_basic_salary(Request $req, $id)
    {

        $validated = $req->validate([
            'head_title' => 'required',
            'grade' => 'required'
        ]);
        // Determine the method for calculating the salary
          $method = $req->method;
          if($method ==  "wid_formula")
          {
            $sal_head_data = array(
                "grade" => $req-> grade,
                "head_title" => $req-> head_title,
                "formula"  => $req-> formulaOutput,
                "amount" => $req-> amount,

              );
            $affectedRows = GradeWiseSalaryMaster::where("id", $id)->update($sal_head_data);

            }
          else{
            $sal_head_data = array(
                "grade" => $req-> grade,
                "head_title" => $req-> head_title,
                "formula"  => '',
                "amount" => $req-> amount,

              );
            $affectedRows = GradeWiseSalaryMaster::where("id", $id)->update($sal_head_data);
          }
          // Update the salary head details
          return redirect()->route('allBasicGradeSalary')
          ->with('message', 'Basic Grade Salary Master Update successfully!');


    }

    // Delete basic grade salary master
    public function delete_basic_sal(Request $req)
    {
        $id = $req->sal_head_id;
        $check =  DeleteSalaryheadId::where('involve_head_id', $id)->where('type', '2')->get();
        
        if ($check->isEmpty())
        {
            $delete = GradeWiseSalaryMaster::find($id)->delete();
            DeleteSalaryheadId::where('salary_head_id', $id)->where('type', '2')->delete();
            return redirect()->back()->with('message', 'Basic Grade Salary Master Deleted Successfully');
            
         
        } else {
            return redirect()->back()->with('error', 'You Cannot delete this! Its depend on other Succces Factors');
        }
    }
    

}
