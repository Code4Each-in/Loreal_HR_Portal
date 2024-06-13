<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasicGrade;
use App\Models\SalaryHead;
use App\Models\GradeWiseSalaryMaster;
use App\Models\DeleteSalaryheadId;
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
            'grade' => 'required|unique:grade_wise_salary_masters,grade,NULL,id,deleted_at,NULL',
            'salary_head'      =>  'required'
        ]);

        $salary_head = $request->salary_head;
        foreach ($salary_head as $id) {
            //dd($id);
            $salary = SalaryHead::where('id', $id)->get();

            $salary_head = GradeWiseSalaryMaster::create([
                'grade'        => $request->grade,
                'head_title'   => $salary[0]->head_title,
                'amount'       => $salary[0]->amount,
                'method'       => $salary[0]->method,
                'formula'      => $salary[0]->formula
            ]);
            //-------------------------------------------------------
            // Store  the id of salary head in dependent_salary_head table
            $sal_id = $salary_head->id;
            $master_id_data = GradeWiseSalaryMaster::where('id', $sal_id)->get();
            $formulaOutput = $master_id_data[0]->formula;

            $salary_head_id = $salary_head->id;
            $pattern = '/\{([^}]+)\}/';
            preg_match_all($pattern, $formulaOutput, $matches);
            $keywords = $matches[1];


            foreach ($keywords as $val) {

                $head = GradeWiseSalaryMaster::where('head_title', $val)->where('deleted_at', '=', NULL)->where('grade', $request->grade)->get();
                if (!empty($head[0]->id)) {
                    $delete_salary_head_data = array(
                        "salary_head_id" =>   $salary_head_id,
                        "involve_head_id" => $head[0]->id,
                        "type" => "2",
                        'grade' => $request->grade
                    );
                    $salary_head = DeleteSalaryheadId::create($delete_salary_head_data);
                }
            }
            //------------------------------------------------------=
            //  Dependent delete

            //--------------------------------------------------------
        }

        return redirect()->route('allBasicGrade')->with('message', 'New Grade Added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $basic_grades = GradeWiseSalaryMaster::all()->groupBy('grade');
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
            'grade'  => 'required',
        ]);
        $salary_head = $request->salary_head;

      

        $current_heads = GradeWiseSalaryMaster::where('grade', $request->grade)->pluck('head_title')->toArray();
        if ($salary_head) {
            foreach ($salary_head as $val) {
                $salary = SalaryHead::where('head_title', $val)->first();

                if ($salary) {
                    $check_sal_head = in_array($val, $current_heads);

                    if ($check_sal_head) {
                        $current_heads = array_diff($current_heads, [$val]);
                    } else {
                        // Create new record if it doesn't exist
                        $salary_head =  GradeWiseSalaryMaster::create([
                            'grade'      => $request->grade,
                            'head_title' => $salary->head_title,
                            'amount'     => $salary->amount,
                            'method'     => $salary->method,
                            'formula'    => $salary->formula
                        ]);
                        //-------------------------------------------------------
                        // Store  the id of salary head in dependent_salary_head table
                        $sal_id = $salary_head->id;

                        $master_id_data = GradeWiseSalaryMaster::where('id', $sal_id)->get();

                        $formulaOutput = $master_id_data[0]->formula;

                        $salary_head_id = $salary_head->id;
                        $pattern = '/\{([^}]+)\}/';
                        preg_match_all($pattern, $formulaOutput, $matches);
                        $keywords = $matches[1];


                        foreach ($keywords as $val) {

                            $head = GradeWiseSalaryMaster::where('head_title', $val)->where('deleted_at', '=', NULL)->where('grade', $request->grade)->get();
                            if (!empty($head[0]->id)) {
                                $delete_salary_head_data = array(
                                    "salary_head_id" =>   $salary_head_id,
                                    "involve_head_id" => $head[0]->id,
                                    "type" => "2",
                                    'grade' => $request->grade
                                );
                                $salary_head = DeleteSalaryheadId::create($delete_salary_head_data);
                            }
                        }
                        //------------------------------------------------------=
                    }
                }
            }
        }



        $recordsToDelete = GradeWiseSalaryMaster::where('grade', $request->grade)
            ->whereIn('head_title', $current_heads)
            ->get(['id']);

        $deletedIds = $recordsToDelete->pluck('id');

        GradeWiseSalaryMaster::whereIn('id', $deletedIds)->delete();

        if (!$recordsToDelete->isEmpty()) {

            $del_id =   $recordsToDelete[0]->id;
            DeleteSalaryheadId::where('salary_head_id', $del_id)->delete();
        }
        //-------------------------------------------------------
        // Store  the id of salary head in dependent_salary_head table
        //------------------------------------------------------=
        return redirect()->route('allBasicGrade')->with('message', ' Grade Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        $grade = $req->sal_head_id;

        $delete = GradeWiseSalaryMaster::where('grade', $grade)->delete();
        $delete_from_dependent = DeleteSalaryheadId::where('grade', $grade)->delete();

        return redirect()->route('allBasicGrade')->with('message', 'Deleted  successfully!');
    }

    public function edit_grade()
    {
        $grade =  Request()->segment(2);
        $salary_head = SalaryHead::all();
        $GradeWiseSalaryMaster = GradeWiseSalaryMaster::where('grade', $grade)->get()->toarray();
        return view('Basicgrade.edit_grade', compact("salary_head"), compact("GradeWiseSalaryMaster"), compact('grade'));
    }
}
