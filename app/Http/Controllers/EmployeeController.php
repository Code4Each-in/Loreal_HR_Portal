<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryHead;
use App\Models\User;
use App\Models\UserDetail;

class EmployeeController extends Controller
{
    public function index()
    {
       // Get all  employees  came  from success factor  
        $all_emp = User::with('post')->where('type_id', '2')->get();
        $all_salary_head = SalaryHead::all();
        return view('Employee.all_employee',  compact("all_emp"), compact("all_salary_head"));
    }

    public function emp_data(Request $req)
    {
       
        $id = $req->id;
        $all_emp = UserDetail::where('emp_id', $id)->get();
        $base_pay = ($all_emp[0]->base_pay);
        $incentive = $all_emp[0]->incentive;
        $basic_percentage = $all_emp[0]->basic_percentage;
        $basic_percentage = str_replace('%', '/100', $basic_percentage);

        $VPP_PR = $all_emp[0]->vpp_percentage;
      
        $VPP_PR = str_replace('%', '/100', $VPP_PR);

       
        //$emp = Employee::find($id);
       
        $all_salary_head = SalaryHead::all();
      
        
        $html = "<table class='table'>
            <thead>
              <tr>
                <th scope='col'>Head Title</th>
                <th scope='col'>Formula</th>
                <th scope='col'>Calculation</th>
                <th scope='col'>Result</th>
              </tr>
            </thead>
            <tbody>";
            $keywords = '';
            
            $results['Basic_PAY']= $base_pay;
            $results['INCENTIVE']= $incentive;
            $results['basic_percentage']= $basic_percentage;
            $results['VPP_PR']= $VPP_PR;
           
           $key = [];
           $replacement_values = [];
        foreach ($all_salary_head as $val) {
          
            $pattern = "/\{([A-Za-z_]+)\}/";
            $formula = str_replace(' ', '_', $val->formula);
            preg_match_all($pattern, $formula, $matches);
            $keywordss = $matches[1];
            
            $dynamicKeywords = array_map(function($keyword) {
                return "{" . $keyword . "}";
            }, $keywordss);
            if(!empty($val->formula))
            {
                $formulaMasterVals =  [];
                foreach($dynamicKeywords as $dynamicVals){
                    
                    $withoutBrackets = str_replace('{', '', $dynamicVals);
                    $withoutBrackets = str_replace('}', '', $withoutBrackets);
                    $formulaMasterVals[$dynamicVals] = $results[$withoutBrackets]; 
                    
                }
              
            
                $basic = str_replace($dynamicKeywords, array_values($formulaMasterVals), $val->formula);
                
                $result = eval("return $basic;");
                $results[$val->head_title] = $result ;
            
            }else{
                $results[$val->head_title] = is_numeric($val->amount) ? floatval($val->amount) : $val->amount;
              
            }
          
           
            $head_title = str_replace('_', ' ', $val->head_title);
            $html .= "<tr>
                <td> $head_title</td>
                <td> $val->formula </td>
                <td>" . (!empty($val->formula) ? $basic : "") . "</td>
                <td>" . (!empty($val->amount) ? $val->amount : round($result)) . "</td>

              
              </tr>";
        }
        
        $html .= "</tbody></table>";
        return $html;
    }



}
