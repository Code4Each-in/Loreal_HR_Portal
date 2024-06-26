<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalarySlip extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $fillable = [
     'emp_id',
     'month',
     'year',
     'grade',
     'base_pay',
     'basic_percentage',
     'incentive',
     'vpp_percentage'
 ];

 public function salary_slip_meta()
 {
     return $this->hasMany(SalarySlipMetaData::class, 'id' , 'salary_slip_id');
 }
}
