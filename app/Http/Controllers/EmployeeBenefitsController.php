<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeBenefitsRequest;
use App\Models\GradeWiseSalaryMaster;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeBenefit;
use App\Models\BasicGrade;
use App\Models\User;
use App\Models\AppliedBenefit;
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
         ->with('message', 'Benefit Created successfully!');
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
        return  json_encode($edit_data);
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
        $userId = Auth::id();
        $get_grade = User::with('user_detail')->has('user_detail')->where('id', $userId)->get()->toArray();
        if($get_grade){
            $grade = $get_grade[0]['user_detail'][0]['grade'];
            $benefits = EmployeeBenefit::where('grade_id', $grade)->get();
            $apply_benefits =   AppliedBenefit::where('user_id', $userId)->get();
            return view('Benefit.apply_benefit', compact('benefits', 'apply_benefits'));
        }else{
          
            return view('errorPage');
        }
       
    }

    public function sbt_detail(Request $request)
    {
        $validated = $request->validate([
            'detail' => 'required',
        ]);
    
       $data = array(
        "user_id" =>  Auth::id(),
        "benefit_id"  => $request-> benefit_id,
        "detail"  => $request-> detail,
        "status" => 2
       ); 

       $benefits_applied = AppliedBenefit::create($data);
       if($benefits_applied)
       {
        Session::flash('message', 'Benefit applied successfully');
       }

    }
    public function approval_benefits()
    {
        if (request()->ajax()) {
            $status = request()->input('status');
            
            $query = AppliedBenefit::with('users', 'EmployeeBenefit');
            
            if ($status == config('app.APPROVED') || $status == config('app.PENDING') || $status == config('app.REJECTED')) {
                $query->where('status', $status);
            }
            
            if (request()->has('search') && request()->input('search.value') !== null) {
                $searchText = request()->input('search.value');
                $query->where(function ($query) use ($searchText) {
                    $query->whereHas('users', function ($query) use ($searchText) {
                        $query->where('Fname', 'like', '%' . $searchText . '%')
                              ->orWhere('Lname', 'like', '%' . $searchText . '%');
                    })
                    ->orWhereHas('EmployeeBenefit', function ($query) use ($searchText) {
                        $query->where('name', 'like', '%' . $searchText . '%')
                              ->orWhere('amount', 'like', '%' . $searchText . '%');
                    });
                });
            }
            
            $start = request()->input('start', 0);
            $length = request()->input('length', 10);
            $draw = request()->input('draw', 1);
            
            $totalRecords = $query->count();
            
            $data = $query->skip($start)->take($length)->get()->toArray();
            
            return response()->json([
                'data' => $data,
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
            ]);
        }
        
        return view('Benefit.benefits_for_approval');
    }
    

    public function approve_benefit(Request $request)
    {
        $userid     = $request->userid; 
        $benefitId  = $request->benefitId; 

        $status = array(
         "status" => 1
        );
      
        $update_status = AppliedBenefit::where(['user_id' =>$userid,'benefit_id' => $benefitId])->update($status);
        if($update_status )
        {
           
            echo json_encode(["success" => "Benefit approved successfully"]);
        }
    }

    public function reject_benefit(Request $request)
    {
        $userid     = $request->userid; 
        $benefitId  = $request->benefitId; 

        $status = array(
         "status" => 3
        );
      
        $update_status = AppliedBenefit::where(['user_id' =>$userid,'benefit_id' => $benefitId])->update($status);
        if($update_status )
        {
            
            echo json_encode(["success" => "Benefit rejected successfully"]);
        }
    }
}