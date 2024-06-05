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
    $headTitleNormalized = preg_replace('/\s+/', '_', trim($req->input('head_title')));
    $req->merge([
      'head_title' => $headTitleNormalized
    ]);
    if ($method ==  "wid_formula") {
      $validated = $req->validate([
        'head_title' => 'required|unique:salary_heads,head_title,NULL,id,deleted_at,NULL',
        'formulaOutput' => 'required',

      ]);
      $head_title = preg_replace('/\s+/', ' ', $req->head_title);
      
      $head_title = str_replace(' ', '_', $head_title);
      $salary_head = SalaryHead::create([
        'head_title'        => $head_title,
        'formula'           => $req->formulaOutput,
        'method'            => $req->method
      ]);


      //--------------------------------------------------------
      $salary_head_id = $salary_head->id;
      $pattern = '/\{([^}]+)\}/';
      preg_match_all($pattern, $req->formulaOutput, $matches);
      $keywords = $matches[1];

      foreach ($keywords as $val) {

        $head = SalaryHead::where('head_title', $val)->get();
        if (!empty($head[0]->id)) {
          $delete_salary_head_data = array(
            "salary_head_id" =>   $salary_head_id,
            "involve_head_id" => $head[0]->id,
            "type" => "1"
          );
          $salary_head = DeleteSalaryheadId::create($delete_salary_head_data);
        }
      }
    } else {

      $validated = $req->validate([
        'head_title' => 'required|unique:salary_heads,head_title,NULL,id,deleted_at,NULL',
        'amount' => 'required',

      ]);
      $salary_head = SalaryHead::create([
        'head_title'        => $req->head_title,
        'formula'           => '',
        'amount'            => $req->amount,
        'method'            => $req->method

      ]);
    }

    return redirect()->route('allsalaryHead')
      ->with('message', 'Salary Head added successfully!');
  }

  public  function allsalaryHead()
  {

    $allsalHead = SalaryHead::all();
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
    if ($method ==  "wid_formula") {
      $sal_head_data = array(
        "head_title" => $req->head_title,
        "formula"  => $req->formulaOutput,
        "amount" => $req->amount,

      );
      $affectedRows = SalaryHead::where("id", $id)->update($sal_head_data);

      //-------------------------------------------------------------------
      // Update  dependent_salary_head table when we update the formula 
      $pattern = '/\{([^}]+)\}/';
      preg_match_all($pattern, $req->formulaOutput, $matches);
      $keywords = $matches[1];
      $delete = DeleteSalaryheadId::where('salary_head_id', $id)->where('type', '1')->delete();
      foreach ($keywords as $val) {

        $head = SalaryHead::where('head_title', $val)->get();
        if (!empty($head[0]->id)) {
          $delete_salary_head_data = array(
            "salary_head_id" =>   $id,
            "involve_head_id" => $head[0]->id,
            "type" => "1"
          );
          $salary_head = DeleteSalaryheadId::create($delete_salary_head_data);
        }
      }
      //-------------------------------------------------------------------
    } else {
      $sal_head_data = array(
        "head_title" => $req->head_title,
        "formula"  => '',
        "amount" => $req->amount,
        'method' => $method

      );
      $affectedRows = SalaryHead::where("id", $id)->update($sal_head_data);

      //-------------------------------------------------------------------
      // when we update the  head title from formula to fixed amount then delete the record  dependent_salary_head table 
      $delete = DeleteSalaryheadId::where('salary_head_id', $id)->where('type', '1')->delete();
      //-------------------------------------------------------------------
    }
    return redirect()->route('allsalaryHead')
      ->with('message', 'Salary Head Update successfully!');
  }

  public function delete_sal_head(Request $req)
  {
    $id = $req->sal_head_id;
    $check =  DeleteSalaryheadId::where('involve_head_id', $id)->where('type',  '1')->get();
    if ($check->isEmpty()) {
      $delete = SalaryHead::find($id)->delete();
      $delete = DeleteSalaryheadId::where('salary_head_id', $id)->where('type', '1')->delete();

      return redirect()->back()->with('message', 'Head Title Deleted Successfully');
    } else {
      return redirect()->back()->with('error', 'You Can not delete this ! Its depends on Success Factor');
    }
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
