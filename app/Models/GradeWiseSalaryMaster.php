<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeWiseSalaryMaster extends Model
{

    use HasFactory;
    protected $fillable = [
        'head_title',
        'amount',
        'method',
        'formula',
        'grade',
    ];
}
