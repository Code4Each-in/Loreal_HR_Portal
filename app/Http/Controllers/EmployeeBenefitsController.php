<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeBenefitsRequest;
use App\Models\GradeWiseSalaryMaster;
use App\Models\EmployeeBenefit;
use App\Models\BasicGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class EmployeeBenefitsController extends Controller
      
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $all_grades = GradeWiseSalaryMaster::groupBy('grade')->distinct()->pluck('grade');
        $employeeBenefits  = EmployeeBenefit::all();
        return view('Benefit.benefits', compact("employeeBenefits","all_grades"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_grades  = GradeWiseSalaryMaster::groupBy('grade')->pluck('grade');
       
        return view('Benefit.benefits_create',compact('all_grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeBenefitsRequest $request)
    {
         $Validated = $request->validated();
         EmployeeBenefit::create($Validated);
         
         return redirect()->route('employee_benefits.index')
         ->with('message', 'Record Saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
   
        $edit_data = EmployeeBenefit::find($request->id);
        echo json_encode($edit_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       $id = $request->emp_benefit_id;
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required ',
            'amount' => '|numeric|min:0',
        ]);

        $benefit = EmployeeBenefit::findOrFail($id);
        $benefit->name = $request->input('name');
        $benefit->grade_id = $request->input('grade_id');
        $benefit->amount = $request->input('amount');
        $benefit->save();
        Session::flash('message', 'Benefit updated successfully');
        return response()->json(['success' => 'Benefit updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $benefit = EmployeeBenefit::find($request->id);
        $benefit->delete();

        return redirect()->route('employee_benefits.index')
         ->with('message', 'Record Deleted successfully!');
    }

    public function apply_benefit()
    {
        $benefits = EmployeeBenefit::all();
        return view('Benefit.apply_benefit', compact('benefits'));
    }

    public function sbt_detail(Request $request)
    {
        $validated = $request->validate([
            'detail' => 'required',
        ]);
    }
}