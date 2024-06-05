<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeleteSalaryheadId extends Model
{
    use HasFactory;
    use SoftDeletes; 
    protected $fillable = [
        'salary_head_id',
        'involve_head_id',
        'type'

    ];
    protected  $table = "dependent_salary_head";
}
