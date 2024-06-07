<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeBenefitsRequest;
use App\Models\BasicGrade;
use App\Models\EmployeeBenefit;
use Illuminate\Http\Request;

class EmployeeBenefitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_grades  = BasicGrade::all();
        $employeeBenefits  = EmployeeBenefit::with('grade')->get();

        return view('Employee.benefits', compact("employeeBenefits","all_grades"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_grades  = BasicGrade::all();
        return view('Employee.benefits_create',compact('all_grades'));
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
    public function edit(string $id)
    {
      
        $edit_data = EmployeeBenefit::find($id);
        echo json_encode($edit_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'grade_id' => 'required|exists:basic_grades,id',
            'amount' => '|numeric|min:0',
        ]);

        $benefit = EmployeeBenefit::findOrFail($id);
        $benefit->name = $request->input('name');
        $benefit->grade_id = $request->input('grade_id');
        $benefit->amount = $request->input('amount');
        $benefit->save();

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
}
