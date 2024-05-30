<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory; 
    protected $fillable = [
        'emp_id',
        'grade',
        'base_pay',
        'basic_percentage',
        'incentive',
        'vpp_percentage'
    ];

    public function grader()
    {
        return $this->hasMany(GradeWiseSalaryMaster::class, 'grade', 'grade');
    }

    public function get_grade_name()
    {
        return $this->hasMany(BasicGrade::class, 'id' , 'grade');
    }
 
}
