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
        $all_emp = User::with('post')->where('type_id', '2')->get()->toarray();
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
        $all_salary_head = [];

        $only_salary_head = SalaryHead::all();

        $salaryhead_with_grades = GradeWiseSalaryMaster::where('grade', $grade)->get();

        foreach ($only_salary_head as $head) {
            $all_salary_head[$head->head_title] = $head;
        }


        $td_variables = [];
        foreach ($salaryhead_with_grades as $data) {
            if (isset($all_salary_head[$data->head_title])) {
                $all_salary_head[$data->head_title] = $data;
            } else {

                $all_salary_head[$data->head_title] = $data;
            }
        }

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
            $pattern = "/\{([A-Za-z_]+)\}/";
            $formula = str_replace(' ', '_', $val->formula);

            preg_match_all($pattern, $formula, $matches);
            $keywordss = $matches[1];
            // print_r($keywordss);
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

            $td_variables[] = [
                'head_title' => $head_title,
                'formula' => $val->formula,
                'calculation' => (!empty($val->formula) ? $basic : ""),
                'amount' => !empty($val->amount) ? $val->amount : round($result)
            ];
        }
        return json_encode($td_variables);
    }

    public  function salary_struc()
    {
        $id = request()->segment(2);

        $all_emp = UserDetail::where('emp_id', $id)->get();
        $base_pay = ($all_emp[0]->base_pay);
        $incentive = $all_emp[0]->incentive;
        $basic_percentage = $all_emp[0]->basic_percentage;
        $basic_percentage = str_replace('%', '/100', $basic_percentage);
        $VPP_PR = $all_emp[0]->vpp_percentage;
        $VPP_PR = str_replace('%', '/100', $VPP_PR);

        $all_salary_head = [];
        $only_salary_head = SalaryHead::all();
        $grade =  $all_emp[0]->grade;
        $salaryhead_with_grades = GradeWiseSalaryMaster::where('grade', $grade)->get();

        foreach ($salaryhead_with_grades as $head) {
            $all_salary_head[$head->head_title] = $head;
        }
        $td_variables = [];
      

        $keywords = '';

        $results['Basic_PAY'] = $base_pay;
        $results['INCENTIVE'] = $incentive;
        $results['basic_percentage'] = $basic_percentage;
        $results['VPP_PR'] = $VPP_PR;

        $key = [];
        $replacement_values = [];


        foreach ($all_salary_head as $val) {
            $result = 0;
            $pattern = "/\{([A-Za-z_]+)\}/";
            $formula = str_replace(' ', '_', $val->formula);

            preg_match_all($pattern, $formula, $matches);
            $keywordss = $matches[1];
            // print_r($keywordss);
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

            $td_variables[] = [
                'head_title' => $head_title,
                'formula' => $val->formula,
                'calculation' => (!empty($val->formula) ? $basic : ""),
                'amount' => !empty($val->amount) ? number_format($val->amount, 2, '.', '') : number_format($result, 2, '.', '')


            ];
        }

        $emp_data = User::with('post')->where('type_id', '2')->where('id', $id)->get();
        //dd($emp_data);
        return view('Employee.salary_structure',  compact("td_variables"),  compact("emp_data"));
    }
}
