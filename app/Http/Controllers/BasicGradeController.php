<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BasicGrade;
use App\Models\SalaryHead;
use App\Models\GradeWiseSalaryMaster;
use Session;

class BasicGradeController extends Controller
{
   
    public function index()
    {
        $salary_head = SalaryHead::all();
        return view('Basicgrade.basic_grade',  compact("salary_head"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade'            => 'required',
            'salary_head'      =>  'required'
        ]);

        $salary_head = $request->salary_head;
        foreach($salary_head as $id)
        {
            $salary = SalaryHead::where('id', $id)->get();
          
               $salary_head = GradeWiseSalaryMaster::create([
                    'grade'        => $request->grade,
                    'head_title'   => $salary[0]->head_title,
                    'amount'       =>  $salary[0]->amount,
                    'method'       =>  $salary[0]->method,
                    'formula'        => $salary[0]->formula
        ]);
           
        }

        return redirect()->route('allBasicGrade')->with('message', 'New Grade Added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
       $basic_grades =   BasicGrade :: all();
        return view('Basicgrade.allBasicGrade', compact("basic_grades"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function editBasicGrade(Request $request)
    {
        $id = $request->input('id');
         $edit_data = BasicGrade::find($id);
         echo json_encode($edit_data);
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'grade' => 'required',
            // 'basic_salary' => 'required'
        ]);

      $edit_form_data = array(
         "grade"        => $request->grade,
        //  "basic_salary" =>$request->basic_salary
      );

      $update_basic_grades = BasicGrade::where("id", $request->sal_head_id)->update($edit_form_data);
      if($update_basic_grades) {
        $request->session()->flash('message', 'Updated successfully.');
        return Response()->json(['status' => 200 , "message" => "Updated successfully"]);

      }
      else {
        return response()->json(['status' => 400, 'error' => 'Failed to update.']);
    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        $id = $req->sal_head_id;
        $delete = BasicGrade::find($id)->delete();

        return redirect()->route('allBasicGrade')->with('message', 'Deleted  successfully!');
    }
}
