<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalarySlipMetaData extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $fillable = [
     'salary_slip_id',
     'meta_key',
     'meta_value'

 ];
}
