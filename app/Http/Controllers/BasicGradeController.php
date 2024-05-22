<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BasicGrade;
class BasicGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Basicgrade.basic_grade');
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
       // dd($request->all());
        $validated = $request->validate([
            'grade' => 'required',
            'basic_salary' => 'required'
        ]);

        $salary_head = BasicGrade::create([
            'grade'        => $request->grade,
            'basic_salary'        => $request->basic_salary
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        $id = $req->sal_head_id;
        $delete = BasicGrade::find($id)->delete();

       // return redirect()->back()->with('message', 'Head Title Deleted Successfully');
    }
}
