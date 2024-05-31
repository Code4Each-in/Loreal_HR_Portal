<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryHead;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\GradeWiseSalaryMaster;

class EmployeeController extends Controller
{
    public function index()
    {
        // Get all  employees  came  from success factor  
        //  Join with user detail table 
        $all_emp = User::with(['post', 'post.get_grade_name'])->where('type_id', '2')->get();
        $all_salary_head = SalaryHead::all();
        return view('Employee.all_employee',  compact("all_emp"), compact("all_salary_head"));
    }

    public function emp_data(Request $req)
    {
        $grade = $req->grade;
        $id = $req->id;
        $all_emp = UserDetail::where('emp_id', $id)->get();


        $base_pay = ($all_emp[0]->base_pay);
        $incentive = $all_emp[0]->incentive;
        $basic_percentage = $all_emp[0]->basic_percentage;
        $basic_percentage = str_replace('%', '/100', $basic_percentage);

        $VPP_PR = $all_emp[0]->vpp_percentage;

        $VPP_PR = str_replace('%', '/100', $VPP_PR);


        //$emp = Employee::find($id);
           $all_salary_head = [];

           $only_salary_head = SalaryHead::all();

           $salaryhead_with_grades = GradeWiseSalaryMaster::where('grade', $grade)->get();
           
          
           foreach ($salaryhead_with_grades as $head) {
            //  dump($head->head_title);
            $all_salary_head[$head->head_title] = $head; 
        }
          

        foreach ($only_salary_head as $data) {
            if (isset($all_salary_head[$data->head_title])) {
               $all_salary_head[$data->head_title];
            }else {
           
            $all_salary_head[$data->head_title] = $data;
            }
        }

    
        
      

      
        // $heads = SalaryHead::with('head')->where('grade', $grade)->get();

        //  Relationship with GradeWiseSalaryMaster 
        // $all_salary_head = SalaryHead::with(['head' => function ($q) use ($grade) {
        //     $q->where('grade', $grade);
        // }])->get();
        // dump($all_salary_head->toarray());


        $html = "<table class='table'> 
       
            <thead>
              <tr>
                <th scope='col'>Head Title</th>
                <th scope='col' id='show_formula' style='display:none'>Formula</th>
                <th scope='col' id='show_cal' style='display:none'>Calculation</th>
                <th scope='col'>Result</th>
              </tr>
            </thead>
            <tbody>";
        $keywords = '';

        $results['Basic_PAY'] = $base_pay;
        $results['INCENTIVE'] = $incentive;
        $results['basic_percentage'] = $basic_percentage;
        $results['VPP_PR'] = $VPP_PR;

        $key = [];
        $replacement_values = [];
       // dump($all_salary_head);
        foreach ($all_salary_head as $val) {
            $result = 0;
           // $basic = 0;
           // echo $val->formula;
           // echo $val->head_title;
            //dump($val);
            // if (!empty($val->head->formula)) {
            //     $val->formula = $val->head->formula;
            // }
          
            // if (!empty($val->head->amount)) {
            //     $val->amount = $val->head->amount;
            // }
           

            $pattern = "/\{([A-Za-z_]+)\}/";
            $formula = str_replace(' ', '_', $val->formula);
            preg_match_all($pattern, $formula, $matches);
            $keywordss = $matches[1];

            $dynamicKeywords = array_map(function ($keyword) {
                return "{" . $keyword . "}";
            }, $keywordss);
            if (!empty($val->formula)) {
                $formulaMasterVals =  [];
                foreach ($dynamicKeywords as $dynamicVals) {

                    $withoutBrackets = str_replace('{', '', $dynamicVals);
                    $withoutBrackets = str_replace('}', '', $withoutBrackets);
                    $formulaMasterVals[$dynamicVals] = $results[$withoutBrackets];
                }


                $basic = str_replace($dynamicKeywords, array_values($formulaMasterVals), $val->formula);

                $result = eval("return $basic;");
                $results[$val->head_title] = $result;
            } else {
                $results[$val->head_title] = is_numeric($val->amount) ? floatval($val->amount) : $val->amount;
            }


            $head_title = str_replace('_', ' ', $val->head_title);
            $html .= "<tr>
                <td> $head_title</td>
                <td  style='display:none' class='show_formula'> $val->formula </td>
                <td  class='show_cal' style='display:none'>" . (!empty($val->formula) ? $basic : "") . "</td>
                <td>" . (!empty($val->amount) ? $val->amount : round($result)) . "</td>
              </tr>";
        }

        $html .= "</tbody></table>";
        return $html;
    }
}
